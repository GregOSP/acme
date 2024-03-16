<?php

use PHPUnit\Framework\TestCase;
use Acme\WidgetCo\Catalog\Product;
use Acme\WidgetCo\Basket;
use Acme\WidgetCo\Catalog\Catalog;
use Acme\WidgetCo\Offer\BuyOneGetOneHalfOffRed;

class BasketTest extends TestCase
{
    private Catalog $catalog;

    /**
     * @var array<array{'limit': float, 'charge': float}>
     */
    private $deliveryChargeRules = [];
    protected function setUp(): void
    {
        // All of these should be pulled from a database so that updates don't require code changes.
        $this->catalog = new Catalog([
            [
                'name' => 'Red Wiget',
                'code' => 'R01',
                'price' => 32.95
            ],
            [
                'name' => 'Green Wiget',
                'code' => 'G01',
                'price' => 24.95
            ],
            [
                'name' => 'Blue Wiget',
                'code' => 'B01',
                'price' => 7.95
            ],
        ]);
        $this->deliveryChargeRules = [
            ['limit' => 90, 'charge' => 0],
            ['limit' => 50, 'charge' => 2.95],
            ['limit' => 0, 'charge' => 4.95],
        ];
    }

    public function testBasketTotal(): void
    {
        $basket = new Basket($this->catalog, $this->deliveryChargeRules, [new BuyOneGetOneHalfOffRed()]);
        $basket->add('B01');
        $basket->add('G01');

        $this->assertEquals(37.85, $basket->total());

        $basket = new Basket($this->catalog, $this->deliveryChargeRules, [new BuyOneGetOneHalfOffRed()]);
        $basket->add('R01');
        $basket->add('G01');

        $this->assertEquals(60.85, $basket->total());

        $basket = new Basket($this->catalog, $this->deliveryChargeRules, [new BuyOneGetOneHalfOffRed()]);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');

        $this->assertEquals(98.27, $basket->total());

        $basket = new Basket($this->catalog, $this->deliveryChargeRules, [new BuyOneGetOneHalfOffRed()]);
        $basket->add('R01');
        $basket->add('R01');

        $this->assertEquals(54.37, $basket->total());
    }


    public function testBasketMultiOffer(): void
    {
        $basket = new Basket($this->catalog, $this->deliveryChargeRules, [new BuyOneGetOneHalfOffRed()]);
        $basket->addOffer(new BuyOneGetOneHalfOffRed());
        $basket->addOffer(new BuyOneGetOneHalfOffRed());
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');

        $this->assertEquals(98.27, $basket->total());
    }
}
