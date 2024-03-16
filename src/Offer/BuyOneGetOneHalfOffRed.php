<?php

namespace Acme\WidgetCo\Offer;

use Acme\WidgetCo\Catalog\Product;

class BuyOneGetOneHalfOffRed implements OfferInterface {
    /**
     * Warning: this function modifies the products in the basket
     * @param array<Product> $products Products passed in from the basket.
     */
    public function applyDiscount(array $products): void {
        $redWidgets = array_filter($products, fn($product) => $product->getCode() === 'R01');
        $discountedCount = floor(count($redWidgets) / 2);
        foreach ($redWidgets as $product) {
            if ($discountedCount > 0) {
                $discountedPrice = $product->getPrice()/2;
                $product->updatePrice($discountedPrice);
                $discountedCount--;
            }
        }
    }
}
