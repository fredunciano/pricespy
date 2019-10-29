<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionBindingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_bindings', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('main_option_id');
            $table->foreign('main_option_id')->references('id')->on('options')->onDelete('cascade');
            $table->unsignedInteger('bound_option_id');
            $table->foreign('bound_option_id')->references('id')->on('options')->onDelete('cascade');
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
        Schema::drop('option_bindings');
    }
}
