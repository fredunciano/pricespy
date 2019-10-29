<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('user_id');
            $table->boolean('add_product')->default(0);
            $table->boolean('edit_product')->default(0);
            $table->boolean('delete_product')->default(0);
            $table->boolean('add_new_sub_user')->default(0);
            $table->boolean('add_competitor')->default(0);
            $table->boolean('edit_competitor')->default(0);
            $table->boolean('delete_competitor')->default(0);
            $table->boolean('view_invoice_and_payment_system')->default(0);
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
        Schema::dropIfExists('permissions');
    }
}
