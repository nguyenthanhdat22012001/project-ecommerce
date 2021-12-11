<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('product', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('store')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cate_id')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('brand_id')->references('id')->on('brand')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('collection_store', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('store')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('coupon', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('store')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('order', function (Blueprint $table) {
            $table->foreign('coupon_id')->references('id')->on('coupon');
            $table->foreign('payment_id')->references('id')->on('payment');
            $table->foreign('user_id')->references('id')->on('user');
        });
        Schema::table('order_detail', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('order');
            $table->foreign('product_id')->references('id')->on('product');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('comment_rating', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('parent_id')->references('id')->on('comment_rating');
        });
        Schema::table('comment_post', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('parent_id')->references('id')->on('comment_post');
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('store')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('message', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('attribute_product', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('thumbs_up_posts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('post_id')->references('id')->on('posts');
        });
        Schema::table('collection_coupons', function (Blueprint $table) {
            $table->foreign('coupon_id')->references('id')->on('coupon');
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}