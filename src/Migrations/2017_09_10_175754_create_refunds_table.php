<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('cms.db-prefix', '').'refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->default(0);
            $table->string('provider_id');
            $table->string('uuid');
            $table->string('provider')->default('stripe');
            $table->decimal('amount')->default(0);
            $table->string('charge');
            $table->string('currency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('cms.db-prefix', '').'refunds');
    }
}
