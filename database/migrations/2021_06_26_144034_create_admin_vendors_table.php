<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_vendors', function (Blueprint $table) {
            $table->integerIncrements("id")->unsigned();
            $table->string('name',255)->nullable();
            $table->string('email','255')->nullable(false)->unique();
            $table->string('password','255')->nullable(false);
            $table->string('phone','15')->nullable(false)->unique();
            $table->integer('vendor_id')->unsigned()->nullable(false);
            $table->integer('role_id')->unsigned()->nullable(false);
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('admin_vendors');
    }
}
