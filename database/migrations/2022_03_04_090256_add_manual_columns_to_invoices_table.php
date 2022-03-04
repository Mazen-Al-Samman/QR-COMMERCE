<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManualColumnsToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->smallInteger("is_manual")->default(0)->after('vendor_id');
            $table->string("title")->after('id')->nullable();
            $table->string("note")->after('is_manual')->nullable();
            $table->string("file", 1000)->after('note')->nullable();
            $table->date("manual_invoice_date")->after('file')->nullable();
            $table->integer("vendor_id")->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn("is_manual");
            $table->dropColumn("title");
            $table->dropColumn("note");
            $table->dropColumn("file");
            $table->dropColumn("manual_invoice_date");
            $table->integer("vendor_id")->unsigned()->nullable(false);
        });
    }
}
