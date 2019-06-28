<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('cnpj', 18)->unique();
            $table->text('codigo_descricao')->nullable();
            $table->string('grau_risco', 2)->nullable();
            $table->string('grupo_risco', 5)->nullable();
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
        Schema::dropIfExists('companies');
    }
}
