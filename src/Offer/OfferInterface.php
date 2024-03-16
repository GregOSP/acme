<?php

namespace Acme\WidgetCo\Offer;
use Acme\WidgetCo\Catalog\Product;

interface OfferInterface {
    /**
     * Warning: this function modifies the products in the basket
     * @param array<Product> $products Products passed in from the basket.
     */
    public function applyDiscount(array $products): void;
}
