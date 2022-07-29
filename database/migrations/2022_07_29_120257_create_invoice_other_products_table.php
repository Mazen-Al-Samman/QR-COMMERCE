<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceOtherProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_other_products', function (Blueprint $table) {
            $table->id();
            $table->integer("invoice_id")->unsigned()->nullable();
            $table->string('name');
            $table->string('description', 800)->nullable();
            $table->double('price');
            $table->integer('quantity');
            $table->double('total_price');
            $table->timestamps();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_other_products');
    }
}
