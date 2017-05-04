<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('quarx.db-prefix', '').'orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->integer('user_id');
            $table->integer('transaction_id');
            $table->text('details');
            $table->text('shipping_address')->nullable();
            $table->boolean('is_shipped')->default(0);
            $table->string('tracking_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('quarx.db-prefix', '').'orders');
    }
}
