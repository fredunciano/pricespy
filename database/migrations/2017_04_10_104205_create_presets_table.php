<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presets', function(Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_variant_table')->default(0);
            $table->string('title');
            $table->string('element');
            $table->string('name');
            $table->string('link')->nullable();
            $table->string('price');
            $table->string('description')->nullable();
            $table->text('variant_table_data')->nullable();
            $table->string('sp', 255)->nullable();
            $table->string('brand')->nullable();
            $table->string('pagination')->nullable();
            $table->string('fake_pagination')->nullable();
            $table->integer('multiplier')->nullable();
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
        Schema::dropIfExists('presets');
    }
}
