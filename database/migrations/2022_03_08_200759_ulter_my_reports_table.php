<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UlterMyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_reports', function (Blueprint $table) {
            $table->date('guarantee')->nullable(true)->change();
            $table->date('payment_date')->nullable(true)->change();
            $table->smallInteger('reminder')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_reports', function (Blueprint $table) {
            $table->date('guarantee')->nullable(false)->change();
            $table->date('payment_date')->nullable(false)->change();
            $table->smallInteger('reminder')->default(2)->change();
        });
    }
}
