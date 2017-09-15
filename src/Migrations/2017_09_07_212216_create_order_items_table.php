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
        Schema::create(config('quarx.db-prefix', '').'order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('transaction_id');
            $table->float('quantity');
            $table->json('variants')->nullable();
            $table->decimal('subtotal');
            $table->boolean('was_refunded')->default(false);
            $table->decimal('tax');
            $table->decimal('total');
            $table->decimal('shipping');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('quarx.db-prefix', '').'order_items');
    }
}
