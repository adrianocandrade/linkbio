<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Shop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->integer('status')->default(1);
                $table->integer('price_type')->default(1);
                $table->float('price', 16, 2)->nullable();
                $table->longText('price_pwyw')->nullable();
                $table->string('comparePrice')->nullable();
                $table->integer('enableOptions')->default(0);
                $table->integer('isDeal')->default(0);
                $table->string('dealPrice')->nullable();
                $table->dateTime('dealEnds')->nullable();
                $table->integer('enableBid')->default(0);
                $table->integer('stock')->nullable();
                $table->longText('stock_settings')->nullable();
                $table->integer('productType')->default(0);
                $table->longText('banner')->nullable();
                $table->longText('media')->nullable();
                $table->longText('description')->nullable();
                $table->longText('ribbon')->nullable();
                $table->longText('seo')->nullable();
                $table->longText('api')->nullable();
                $table->longText('files')->nullable();
                $table->longText('extra')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_options')) {
            Schema::create('product_options', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('product_id');
                $table->string('name')->nullable();
                $table->float('price', 16, 2)->nullable();
                $table->integer('stock')->nullable();
                $table->longText('description')->nullable();
                $table->longText('files')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_shipping')) {
            Schema::create('product_shipping', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('country_iso')->nullable();
                $table->string('country')->nullable();
                $table->longText('locations')->nullable();
                $table->longText('extra')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_shipping_locations')) {
            Schema::create('product_shipping_locations', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('shipping_id')->nullable();
                $table->string('name')->nullable();
                $table->longText('description')->nullable();
                $table->float('price', 16, 2)->nullable();
                $table->longText('extra')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_order_timeline')) {
            Schema::create('product_order_timeline', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('tid');
                $table->string('type')->nullable();
                $table->longText('data')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_order_note')) {
            Schema::create('product_order_note', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('tid');
                $table->longText('note')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_order')) {
            Schema::create('product_order', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('payee_user_id')->nullable();
                $table->longText('details')->nullable();
                $table->string('currency')->nullable();
                $table->string('email')->nullable();
                $table->string('ref')->nullable();
                $table->float('price', 16, 2)->nullable();
                $table->integer('is_deal')->default(0);
                $table->integer('deal_discount')->nullable();
                $table->longText('products')->nullable();
                $table->longText('extra')->nullable();
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('product_reviews')) {
            Schema::create('product_reviews', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('reviewer_id')->nullable();
                $table->integer('product_id')->nullable();
                $table->string('rating')->nullable();
                $table->longText('review')->nullable();
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_options');
        Schema::dropIfExists('product_shipping');
        Schema::dropIfExists('product_shipping_locations');
        Schema::dropIfExists('product_order_timeline');
        Schema::dropIfExists('product_order_note');
        Schema::dropIfExists('product_order');
        Schema::dropIfExists('product_reviews');
    }
}
