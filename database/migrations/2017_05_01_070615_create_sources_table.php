<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('preset_id');
            $table->foreign('preset_id')->references('id')->on('presets')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('vat_rate_id')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->string('name')->default('');
            $table->string('url')->default('');
            $table->float('vat', 10, 1)->nullable();
            $table->boolean('netto')->default(1);
            $table->string('price_remove_prefix')->nullable();
            $table->string('name_prefix')->nullable();
            $table->boolean('is_main')->default(0);
            $table->boolean('is_disabled')->default(0);
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
        Schema::drop('sources');
    }
}
