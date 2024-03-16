<?php

namespace Acme\WidgetCo\Catalog;

use Acme\WidgetCo\Catalog\Product;

class Catalog {
    /**
     * 
     * productsData = 
     * [
     *      [
     *          'code' => 'R01',
     *          'name' => 'Red Widget',
     *          'price' => 32.95,
     *      ],
     *      [ 
     *          'code' => 'G01',
     *          'name' => 'Green Widget',
     *          'price' => 24.95',
     *      ],
     *      [ 
     *          'code' => 'B01',
     *          'name' => 'Blue Widget',
     *          'price' => 7.95',
     *      ],
     * ]
     */

     /**
     * @var array<Product> $products
    */
    private array $products = [];

    /**
     * @param array<array{'name': string, 'code': string, 'price': float}> $productsData An array of arrays with product data (like a db table)
     */
    public function __construct($productsData) {
        foreach ($productsData as $product) {
            $this->products[$product['code']] = new Product($product['name'], $product['code'], $product['price']);
        }
    }

    /**
     * @return Product
     */
    public function getProductByCode(string $code): Product {
        return $this->products[$code] ?? null;
    }

    /**
     * @return array<Product>
     */
    public function getProducts(): array {
        return $this->products;
    }

    public function addProduct(Product $product): void {
        $this->products[$product->getCode()] = $product;
    }
}
