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
        Schema::create(config('cms.db-prefix', '').'plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price');
            $table->string('interval');
            $table->string('name');
            $table->string('uuid');
            $table->string('currency');
            $table->string('descriptor')->nullable();
            $table->integer('trial_days')->default(0);
            $table->string('stripe_name');
            $table->string('subscription_name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('cms.db-prefix', '').'plans');
    }
}
