<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('cms.db-prefix', '').'transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->integer('user_id');
            $table->string('provider');
            $table->string('provider_id');
            $table->string('provider_date');
            $table->text('provider_dispute')->nullable();
            $table->string('state');
            $table->text('coupon')->nullable();
            $table->integer('subtotal');
            $table->integer('tax');
            $table->integer('total');
            $table->integer('shipping');
            $table->datetime('refund_date')->nullable();
            $table->boolean('refund_requested')->default(0);
            $table->text('cart');
            $table->text('response');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('cms.db-prefix', '').'transactions');
    }
}
