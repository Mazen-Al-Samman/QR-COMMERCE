<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->date('guarantee')->nullable(false);
            $table->date('payment_date')->nullable(false);
            $table->smallInteger('reminder')->default(2);
            $table->string('image',500)->nullable(true);
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('my_reports');
    }
}
