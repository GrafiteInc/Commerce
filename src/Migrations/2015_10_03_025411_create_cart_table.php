<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('cart')) {
            Schema::create('cart', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('entity_id');
                $table->integer('entity_type');
                $table->text('product_variants')->nullable();
                $table->text('address')->nullable();
                $table->integer('quantity');
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
        Schema::drop('cart');
    }

}
