<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('quarx.db-prefix', '').'cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('entity_id');
            $table->string('entity_type');
            $table->text('product_variants')->nullable();
            $table->text('address')->nullable();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('quarx.db-prefix', '').'cart');
    }
}
