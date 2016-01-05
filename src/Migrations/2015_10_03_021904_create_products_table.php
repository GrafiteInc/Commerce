<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('products')) {
            Schema::create('products', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->string('url');
                $table->string('code')->nullable();
                $table->integer('price');
                $table->string('weight')->nullable();
                $table->string('width')->nullable();
                $table->string('height')->nullable();
                $table->string('depth')->nullable();
                $table->integer('discount')->default(0);
                $table->string('hero_image')->nullable();
                $table->string('notification')->nullable();
                $table->string('discount_type')->nullable();
                $table->integer('stock')->default(0);
                $table->integer('is_available')->default(0);
                $table->integer('is_published')->default(0);
                $table->integer('is_download')->default(0);
                $table->integer('is_featured')->default(0);
                $table->integer('is_subscription')->default(0);
                $table->integer('has_iterations')->default(0);
                $table->string('file')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_keywords')->nullable();
                $table->text('details')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('product_variants')) {
            Schema::create('product_variants', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('product_id')->default(0);
                $table->string('key');
                $table->string('value');
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
        Schema::drop('products');
        Schema::drop('product_variables');
    }

}
