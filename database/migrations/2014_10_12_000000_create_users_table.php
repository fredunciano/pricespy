<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_sub')->default(0);
            $table->unsignedSmallInteger('main_user_id')->nullable();
            $table->boolean('after_tax_prices')->default(0);
            $table->double('equality_percent', 8, 2)->default(3);
            $table->string('avatar')->nullable();
            $table->string('place')->nullable();
            $table->string('address')->nullable();
            $table->string('locale')->default('en');
            $table->unsignedSmallInteger('country_id')->nullable();
            $table->string('town')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
