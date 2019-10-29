<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_sources', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_id');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->string('url')->default('');
            $table->string('name')->nullable();
            $table->boolean('dot_price')->default(0);
            $table->boolean('netto')->default(0);
            $table->timestamps();
        });
        Schema::create('option_source_selectors', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('option_source_id');
            $table->foreign('option_source_id')->references('id')->on('option_sources')->onDelete('cascade');
            $table->string('selector')->default('');
            $table->string('name')->nullable();
            $table->string('name_prefix')->nullable();
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
        Schema::drop('option_source_selectors');
        Schema::drop('option_sources');
    }
}
