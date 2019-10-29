<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PresetsSeeder::class);
//        $this->call(CategoriesSeeder::class);
//        $this->call(SourcesSeeder::class);
//        $this->call(ProductsSeeder::class);
//        $this->call(ProductBindingsSeeder::class);
//        $this->call(ProductPriceEntriesSeeder::class);
//        $this->call(OptionsSeeder::class);
//        $this->call(PagesSeeder::class);
        $this->call(VatSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(CountriesSeeder::class);
    }
}
