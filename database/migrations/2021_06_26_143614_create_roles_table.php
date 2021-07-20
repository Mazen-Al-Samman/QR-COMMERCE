<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->integerIncrements("id")->unsigned();
            $table->string('role_title','255')->unique()->nullable(false);
            $table->string('role_description',255)->nullable(false);
            $table->timestamps();
        });

        \App\Models\Role::insert([
            [
                'role_title' => 'super admin',
                'role_description' => 'Can make everything in system'
            ],
            [
                'role_title' => 'admin',
                'role_description' => 'can make many things in system'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
