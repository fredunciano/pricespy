<?php

use Illuminate\Database\Seeder;
use App\Source;
use App\Product;

class ProductBindingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::whereHas('source', function($q) {
            return $q->where('is_main', 1);
        })->get()->each(function($product) {
            Product::where('name', $product->name)->whereHas('source', function($q) {
                return $q->where('is_main', 0);
            })->get()->each(function($competingProduct) use ($product) {
                $product->bindings()->create([
                    'bound_product_id' => $competingProduct->id,
                ]);
            });

        });
    }
}
