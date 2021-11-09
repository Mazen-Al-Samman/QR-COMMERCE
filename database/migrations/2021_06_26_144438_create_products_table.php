<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integerIncrements("id")->unsigned();
            $table->string("name")->nullable(false);
            $table->string("description", 500)->nullable(false);
            $table->double("price")->nullable(false);
            $table->double("old_price")->nullable(true);
            $table->string("barcode")->nullable(false);
            $table->string("main_image",'500')->nullable(false);
            $table->integer("category_id")->unsigned()->nullable(false);
            $table->integer("vendor_id")->unsigned()->nullable(false);
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['vendor_id', 'barcode']);
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
        Schema::dropIfExists('products');
    }
}
