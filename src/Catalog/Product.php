<?php

namespace Acme\WidgetCo\Catalog;

class Product {
    // Using php8 constructor promotion
    // https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion
    public function __construct(private string $name, private string $code, private float $price) {}

    public function getCode(): string {
        return $this->code;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function updatePrice(float $price): void {
        $this->price = $price;
    }
}
