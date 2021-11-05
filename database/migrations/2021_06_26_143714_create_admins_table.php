<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->integerIncrements("id")->unsigned();
            $table->string('username',255)->nullable(false)->unique();
            $table->string('phone',15)->nullable(false)->unique();
            $table->string('email',255)->nullable(false)->unique();
            $table->tinyInteger('active')->default(1)->nullable(false);
            $table->string('password',255)->nullable(false);
            $table->integer('role_id')->unsigned()->nullable(false);
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
        Schema::dropIfExists('admins');
    }
}
