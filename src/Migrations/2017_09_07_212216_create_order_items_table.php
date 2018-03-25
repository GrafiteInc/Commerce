<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('cms.db-prefix', '').'order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('transaction_id');
            $table->integer('refund_id');
            $table->float('quantity');
            $table->json('variants')->nullable();
            $table->integer('subtotal');
            $table->boolean('was_refunded')->default(false);
            $table->integer('tax');
            $table->integer('total');
            $table->integer('shipping');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('cms.db-prefix', '').'order_items');
    }
}
