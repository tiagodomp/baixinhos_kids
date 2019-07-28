<?php
    /**
     * @author  Tiago Pereira
     * @email   tiagodominguespereira@gmail.com
     * @contato
     */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsaveisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsaveis', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->string('nome', 120);                    // Nome completo do responsavel
            $table->json('contatos');                       // lista de contatos
            $table->json('canais_id');                      // Através de qual(is) canal(is) o responsável conheceu o estabelecimento
            $table->uuid('criado_por');                     // informações sobre o funcionário que criou, data, e etc.
            $table->json('imagens')->nullable();            // lista de imagens do ou com o responsável
            $table->json('infos')->nullable();              // informações adjacentes

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
        Schema::dropIfExists('responsaveis');
    }
}
