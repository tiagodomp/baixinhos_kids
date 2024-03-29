<?php
    /**
     * @author  Tiago Pereira
     * @email   tiagodominguespereira@gmail.com
     * @contato
     */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canais', function (Blueprint $table) {
            $table->uuid('uuid')->primary();

            $table->string('titulo', 120)->unique();        // nome do canal que o responsavel conheceu o baixinho kids
            $table->string('descricao')->nullable();                    // uma breve descricao sobre o canal
            $table->text('tecnicas')->nullable();                       // observações técnicas, e estratégias para lidar com o público desse canal
            $table->uuid('criado_por');                     // informações sobre o funcionário que criou, data, e etc.
            $table->json('infos')->nullable();                          // informações adjacentes

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
        Schema::dropIfExists('marketing');
    }
}
