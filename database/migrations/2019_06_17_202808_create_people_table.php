<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->date('data_nascimento');
            $table->enum('sexo', ['M', 'F', 'T', 'O']);
            $table->string('rg');
            $table->string('cpf', 11)->nullable();
            $table->string('rg_orgao_uf_emissao')->nullable();
            $table->string('rg_data_expedicao')->nullable();
            $table->string('cnh')->nullable();
            $table->string('cnh_categoria')->nullable();
            $table->string('nis')->nullable();
            $table->string('raca_cor')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('grau_instrucao')->nullable();
            $table->string('nome_social')->nullable();
            $table->string('minicipio')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('ctps_numero')->nullable();
            $table->string('ctps_serie')->nullable();
            $table->string('codigo_pais_nascimento')->nullable();
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
        Schema::dropIfExists('people');
    }
}
