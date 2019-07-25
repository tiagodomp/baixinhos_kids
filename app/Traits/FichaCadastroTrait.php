<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Baixinho;
use App\Canal;
use App\Responsavel;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

trait FichaCadastroTrait
{
    public function fichaCompleta(Request $request)
    {
        $r[0] = Baixinho::create([
            'uuid'                      => Str::uuid()->toString(),
            'responsavel_uuid'          => $request->uuidR,
            'nome'                      => $request->nomeB,
            'nascimento'                => $request->nascimentoB,
            'primeiro_corte'            => $request->primeiroCorteB,
            'autorizacao_audiovisual'   => $request->autorizacaoR,
            'ficha_cadastro'            =>($request->has('fichaCadastro'))?[
                                            'link_original' => $request->fichaCadastroOriginal,
                                            'link_miniatura'=> $request->fichaCadastroMiniatura,
                                            'mime_type'     => $request->mimeType,
                                            'criado_por' => auth()->user()->uuid,
                                            'created_at' => now()->toDateTimeString(),
                                            'updated_at' => null,
                                            'deleted_at' => null,
                                        ]:null,
            'criado_por'                => auth()->user()->uuid,
            'imagens'                   => $request->nomeBaixinho,
            'infos'                     => $request->nomeBaixinho,
            'created_at'                => now()->toDateTimeString(),
            'updated_at'                => null,
            'deleted_at'                => null,
        ]);
    }

}
