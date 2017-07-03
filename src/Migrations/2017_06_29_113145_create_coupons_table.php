<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('quarx.db-prefix', '').'coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('code');
            $table->string('currency');
            $table->string('discount_type')->default('dollar');
            $table->float('amount')->default(0);
            $table->integer('limit')->default(1);
            $table->string('stripe_id');
            $table->boolean('for_subscriptions')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('quarx.db-prefix', '').'coupons');
    }
}
