<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsMainAccountColumnToAdminVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_vendors', function (Blueprint $table) {
            $table->smallInteger('is_main_vendor')->default(0)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_vendors', function (Blueprint $table) {
            $table->dropColumn('is_main_vendor');
        });
    }
}
