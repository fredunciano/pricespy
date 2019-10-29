<?php

use Illuminate\Database\Seeder;
use App\Product;
use Carbon\Carbon;
use App\ProductPriceEntry;

class ProductPriceEntriesSeeder extends Seeder
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
        })->where('is_watched', 1)->get()->each(function($product) {
            $this->createHistory($product);
            $product->bindings()->with('product')->get()->each(function($binding) {
                $this->createHistory($binding->product);
            });
        });
    }
    
    protected function createHistory($product)
    {
        $daysOffsets = [];
        $daysOffset = 0;
        for ($i = 0; $i < rand(10, 20); $i++) {
            $daysOffset += rand(1, 3); // 1, 2, 4, 7, 8 .. etc
            $daysOffsets[] = $daysOffset; // [1, 2, 4, 7, 8] etc
        }
        $daysOffsets = array_reverse($daysOffsets); // create older entries first
        foreach ($daysOffsets as $days) {
            $price = $product->price * getRandomMultiplier();
            factory(ProductPriceEntry::class)->create([
                'product_id' => $product->id,
                'price' => $price,
                'vat_price' => $price * $product->source->getVatAmplifier(),
                'fetched_at' => Carbon::now()->subDays($days)
            ]);
        }
        // the actual value
        factory(ProductPriceEntry::class)->create([
            'product_id' => $product->id,
            'price' => $product->price,
            'vat_price' => $product->vat_price,
            'fetched_at' => Carbon::now()
        ]);
    }
}
