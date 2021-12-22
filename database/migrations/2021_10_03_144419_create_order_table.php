<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('coupon_sku',255)->nullable();
            $table->float('coupon_price',15,3)->nullable();
            $table->integer('payment_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('store_id')->unsigned()->nullable();
            $table->string('name',200)->nullable();
            $table->string('address')->nullable();
            $table->string('phone',10)->nullable();
            $table->text('note')->nullable();
            $table->tinyinteger('status')->default(1);
            $table->float('shippingprice',15,3)->nullable();
            $table->float('totalprice',15,3);
            $table->integer('totalQuantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
