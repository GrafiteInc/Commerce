<?php

use Illuminate\Database\Migrations\Migration;

class CreateCustomerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table(config('cms.db-prefix', '').'user_meta', function ($table) {
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Schema::table(config('cms.db-prefix', '').'user_meta', function ($table) {
        //     $table->dropColumn('stripe_id');
        //     $table->dropColumn('card_brand');
        //     $table->dropColumn('card_last_four');
        //     $table->dropColumn('shipping_address');
        //     $table->dropColumn('billing_address');
        // });
    }
}
