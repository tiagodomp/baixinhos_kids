<?php
    /**
     * @author  Tiago Pereira
     * @email   tiagodominguespereira@gmail.com
     * @contato
     */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaixinhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baixinhos', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->uuid('responsavel_uuid');

            $table->string('nome', 120);                // Nome do(a) Baixinho(a)
            $table->date('nascimento');                 // Data de nascimento da criança
            $table->date('primeiro_corte');             // Data do primeiro corte
            $table->boolean('autorizacao_audiovisual'); // o responsável autorizou o compartilhamento publico de imagens e/ou audio
            $table->json('ficha_cadastro')->nullable(); // scaneamento da ficha de cadastro, para certificar a autorização do responsável
            $table->json('criado_por');                 // informações sobre o funcionário que criou, data, e etc.
            $table->json('imagens')->nullable();        // lista de fotos da criança
            $table->json('infos')->nullable();          // informações adjacentes

            $table->foreign('responsavel_uuid')->references('uuid')->on('responsaveis');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baixinhos');
    }
}
