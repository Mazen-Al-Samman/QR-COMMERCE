<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToInvoiceOtherProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_other_products', function (Blueprint $table) {
            $table->integer("category_id")->unsigned()->after('invoice_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_other_products', function (Blueprint $table) {
            $table->dropForeign('invoice_other_products_category_id_foreign');
            $table->dropColumn("category_id");
        });
    }
}
