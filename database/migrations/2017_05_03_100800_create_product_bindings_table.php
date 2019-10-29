<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBindingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_bindings', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('main_product_id');
            $table->foreign('main_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedInteger('bound_product_id');
            $table->foreign('bound_product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::drop('product_bindings');
    }
}
