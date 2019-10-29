<?php

use Illuminate\Database\Seeder;
use App\Source;
use App\Option;

class OptionsSeeder extends ProductsSeedingBase
{
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
                    for ($i = 0; $i < rand(1, 2); $i++) {
                        factory(Option::class)->create([
                            'source_id' => $source->id,
                            'name' => $group['brand'] . ' ' . $product['name'] . ' ' . $this->getCategorisedOption($group['category_id'], $i),
                            'price' => $product['price'] * $this->getRandomOffset() * rand(5, 10),
                        ]);
                    }
                }
            }
        });
    }

    protected function getCategorisedOption($category, $i)
    {
        switch ($category) {
            default:
                return ['protection glass', 'case'][$i];
            case 'Laptop':
                return ['case', 'charger'][$i];
        }
    }
}
