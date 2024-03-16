<?php

namespace Acme\WidgetCo;

use Acme\WidgetCo\Catalog\Product;
use Acme\WidgetCo\Catalog\Catalog;
use Acme\WidgetCo\Delivery\ChargeCalculator;
use Acme\WidgetCo\Offer\OfferInterface;

class Basket {
    /**
     * @var array<Product> $products
    */
    private array $products = [];

    /**
     * @var array<string, OfferInterface> $offers
    */
    private array $offers = [];

    /**
     * @param array<array{'limit': float, 'charge': float}> $deliveryChargeRules
     * @param array<OfferInterface> $offers
     */
    public function __construct(private Catalog $catalog, private array $deliveryChargeRules, array $offers = []) {
        foreach ($offers as $offer) {
            $this->offers[get_class($offer)] = $offer;
        }
    }

    public function addOffer(OfferInterface $offer): void {
        // Are there offer limits?
        // Using associative array to only allow adding one instance of a specific offer
        $this->offers[get_class($offer)] = $offer;
    }

    public function add(string $productCode): void {
        $catalogProduct = $this->catalog->getProductByCode($productCode);
        if ($catalogProduct) {
            $this->products[] = clone $catalogProduct;
        }
    }

    public function remove(string $productCode): void {
        // Not part of the prompt. Come back if time remains.
    }

    public function total(): float {
        // Quick way to reset all the prices in the basket 
        foreach ($this->products as $product) {
            $catalogProduct = $this->catalog->getProductByCode($product->getCode());
            if(!$catalogProduct){
                throw new \Exception("Cart contains product not in catalog");
            }
            $product->updatePrice($catalogProduct->getPrice());
        }

        foreach ($this->offers as $offer) {
            $offer->applyDiscount($this->products);
        }

        $total = array_sum(array_map(fn($product) => $product->getPrice(), $this->products));
        return round($total + ChargeCalculator::calculate($total, $this->deliveryChargeRules),2, PHP_ROUND_HALF_DOWN);
    }
}
