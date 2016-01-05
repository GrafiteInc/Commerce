<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionPlansTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('subscription_plans')) {
            Schema::create('subscription_plans', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->string('url');
                $table->integer('price');
                $table->string('provider_id');
                $table->string('interval');
                $table->integer('trial');
                $table->string('statement_desc');
                $table->text('description')->nullable();
                $table->integer('is_published')->default(0);
                $table->integer('is_featured')->default(0);
                $table->string('hero_image')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subscription_plans');
    }

}
