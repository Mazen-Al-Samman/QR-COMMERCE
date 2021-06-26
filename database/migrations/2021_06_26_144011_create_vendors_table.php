<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->integerIncrements("id")->unsigned();
            $table->string('name',255)->nullable(false);
            $table->string('country',255)->nullable(false);
            $table->string('city',255)->nullable(false);
            $table->integer('subscribe')->nullable(false);
            $table->date('start_subscription')->nullable(false);
            $table->date('end_subscription')->nullable(false);
            $table->string('phone',15)->nullable(false)->unique();
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
        Schema::dropIfExists('vendors');
    }
}
