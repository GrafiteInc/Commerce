<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPlansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->string('interval');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('currency');
            $table->string('descriptor')->nullable();
            $table->integer('trial_days')->default(0);
            $table->string('stripe_name');
            $table->string('subscription_name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('plans');
    }
}
