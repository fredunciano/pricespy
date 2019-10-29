<?php

use App\Source;
use App\Product;

class ProductsSeeder extends ProductsSeedingBase
{
    protected $product;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsGroups = $this->getProducts();
        Source::all()->each(function($source) use ($productsGroups) {
            foreach ($productsGroups as $group) {
                $productsCount = count($group['products']);
                shuffle($group['products']);
                $products = array_slice($group['products'], 0, rand(1, $productsCount));
                foreach ($products as $product) {
                    $this->createProduct($product, $group, $source);
                }
            }
        });
    }

    public function createProduct($product, $group, $source)
    {
        $price = $product['price'] * $this->getRandomOffset();
        $this->product = factory(Product::class)->create([
            'source_id' => $source->id,
            'name' => $group['brand'] . ' ' . $product['name'],
            'category_id' => $group['category_id'],
            'price' => $price,
            'vat_price' => $price * $source->getVatAmplifier(),
            'is_watched' => $source->is_main ? rand(0, 1) : 0,
        ]);
        return $this;
    }

}
