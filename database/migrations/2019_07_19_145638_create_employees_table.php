<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->bigInteger('person_id')->unsigned()->nullable();
            $table->foreign('person_id')->references('id')->on('people');

            $table->bigInteger('sector_id')->unsigned()->nullable();
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->bigInteger('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles');

            $table->bigInteger('registered_by')->unsigned()->nullable();
            $table->foreign('registered_by')->references('id')->on('users');

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
        Schema::dropIfExists('employees');
    }
}
