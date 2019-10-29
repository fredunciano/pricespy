<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_id');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('category_id');
            $table->string('origin');
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->string('brand')->nullable();
            $table->string('left_in_stock')->nullable();
            $table->bigInteger('price')->default(0);
            $table->bigInteger('vat_price')->default(0);
            $table->bigInteger('min_price')->nullable();
            $table->bigInteger('max_price')->nullable();
            $table->bigInteger('range_min_price')->nullable();
            $table->bigInteger('range_max_price')->nullable();
            $table->text('amount_with_prices')->nullable();
            $table->bigInteger('shipping_cost')->nullable();
            $table->bigInteger('purchase_price')->nullable();
            $table->bigInteger('vat_max_price')->nullable();
            $table->string('original_price_string')->nullable();
            $table->float('vat', 10, 2)->nullable();
            $table->float('rate', 10, 2)->nullable();
            $table->text('link')->nullable();
            $table->boolean('is_watched')->default(1);
            $table->boolean('is_actual')->default(0);
            $table->boolean('is_manual')->default(0);
            $table->string('image')->nullable();
            $table->text('sp_data')->nullable();
            $table->boolean('manual_override')->default(0);
            $table->timestamp('fetched_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
