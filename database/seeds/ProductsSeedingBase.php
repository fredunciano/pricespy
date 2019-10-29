<?php

use Illuminate\Database\Seeder;

class ProductsSeedingBase extends Seeder
{
    public function getProducts()
    {
        return [
            [
                'category_id' => 1,
                'brand' => 'Samsung',
                'products' => [
                    [
                        'name' => 'Galaxy S6',
                        'price' => 500,
                    ],
                    [
                        'name' => 'Galaxy S7',
                        'price' => 600,
                    ],
                    [
                        'name' => 'Galaxy S8',
                        'price' => 700,
                    ],
                    [
                        'name' => 'Galaxy S9',
                        'price' => 800,
                    ],
                    [
                        'name' => 'Galaxy Note 6',
                        'price' => 600,
                    ],
                    [
                        'name' => 'Galaxy Note 7',
                        'price' => 700,
                    ],
                    [
                        'name' => 'Galaxy Note 8',
                        'price' => 800,
                    ],
                    [
                        'name' => 'Galaxy Note 9',
                        'price' => 900,
                    ],
                ]
            ],
            [
                'category_id' => 1,
                'brand' => 'iPhone',
                'products' => [
                    [
                        'name' => '6',
                        'price' => 600,
                    ],
                    [
                        'name' => '7',
                        'price' => 700,
                    ],
                    [
                        'name' => '8',
                        'price' => 800,
                    ],
                    [
                        'name' => 'X',
                        'price' => 1000,
                    ],
                    [
                        'name' => 'XS',
                        'price' => 1100,
                    ],
                    [
                        'name' => 'XS MAX',
                        'price' => 1300,
                    ],
                ]
            ],
            [
                'category_id' => 1,
                'brand' => 'Huawei',
                'products' => [
                    [
                        'name' => 'Honor 8',
                        'price' => 300,
                    ],
                    [
                        'name' => 'Honor 8 Pro',
                        'price' => 400,
                    ],
                    [
                        'name' => 'Honor 9',
                        'price' => 450,
                    ],
                    [
                        'name' => 'Honor 10',
                        'price' => 650,
                    ],
                    [
                        'name' => 'P10',
                        'price' => 400,
                    ],
                    [
                        'name' => 'P10 Pro',
                        'price' => 450,
                    ],
                    [
                        'name' => 'P20',
                        'price' => 600,
                    ],
                    [
                        'name' => 'P20 Pro',
                        'price' => 750,
                    ],
                ]
            ],
            [
                'category_id' => 2,
                'brand' => 'Acer',
                'products' => [
                    [
                        'name' => 'Predator Helios 300 Special Edition',
                        'price' => 1200,
                    ],
                    [
                        'name' => 'Predator 15 Gaming Laptop',
                        'price' => 1300,
                    ],
                    [
                        'name' => 'Predator Helios 300',
                        'price' => 1300,
                    ],
                    [
                        'name' => 'Predator Triton 300 Gaming',
                        'price' => 1600,
                    ],
                    [
                        'name' => 'Predator Helios 500 Gaming',
                        'price' => 1700,
                    ],
                    [
                        'name' => 'Predator Triton 700',
                        'price' => 2300,
                    ],
                    [
                        'name' => 'Predator Triton 700 Gaming',
                        'price' => 2400,
                    ],
                    [
                        'name' => 'Predator 17 X Gaming Laptop',
                        'price' => 2500,
                    ],
                ]
            ],
        ];
    }


    public function getRandomOffset()
    {
        return 1.10 - rand(0, 20) / 100;
    }
}
