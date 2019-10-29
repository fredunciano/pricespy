<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPriceEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('vat_price')->default(0);
            $table->unsignedBigInteger('vat')->default(0);
            $table->unsignedBigInteger('rate')->default(0);
            $table->bigInteger('range_min_price')->nullable();
            $table->bigInteger('range_max_price')->nullable();
            $table->text('amount_with_prices')->nullable();
            $table->timestamp('fetched_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_price_entries');
    }
}
