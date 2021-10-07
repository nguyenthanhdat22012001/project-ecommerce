<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->integer('cate_id');
            $table->integer('brand_id');
            $table->integer('discount_id');
            $table->string('name', 200);
            $table->string('slug', 100)->nullable();
            $table->string('img');
            $table->text('listimg')->nullable();    
            $table->longtext('description')->nullable();
            $table->longtext('shortdescription')->nullable();
            $table->integer('quantity');
            $table->float('price',15,3);
            $table->boolean('hide')->nullable();
            $table->integer('sort')->nullable();
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
        Schema::dropIfExists('product');
    }
}
