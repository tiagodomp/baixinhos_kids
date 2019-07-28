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
            'autorizacao_audiovisual'   => $request->has('autorizacaoR')?true:false,
            'ficha_cadastro'            =>($request->has('fichaCadastro'))?$this->imagensJson($request->fichaCadastro):null,
            'criado_por'                => auth()->user()->uuid,
            'imagens'                   => ($request->has('imagensB'))?$this->imagensJson($request->imagensB):null,
            'historico'                 => $request->historico,
            'infos'                     => $request->infos,
            'created_at'                => now()->toDateTimeString(),
            'updated_at'                => null,
            'deleted_at'                => null,
        ]);

        $r[1]  = Responsavel::create([
            'uuid'                      => Str::uuid()->toString(),
            'nome'                      => $request->nomeR,
            'contatos'                  => $request->contatosR,
            'canais_id'                 => $request->canais,
            'criado_por'                => auth()->user()->uuid,
            'imagens'                   => ($request->has('imagensR'))?$this->imagensJson($request->imagensR):null,
            'infos'                     => $request->infos,
            'created_at'                => now()->toDateTimeString(),
            'updated_at'                => null,
            'deleted_at'                => null,
        ]);
    }

    protected function imagensJson(array $imagens)
    {
        $imagem = [];
        if(count($imagens) >= 1)
            foreach($imagens as $imagem){
                $imagem[] = [
                'link_original' => (string) $imagem['original'],
                'link_miniatura'=> (string) $imagem['miniatura'],
                'mime_type'     => (string) $imagem['mimeType'],
                'criado_por'    => auth()->user()->uuid,
                'created_at'    => now()->toDateTimeString(),
                'updated_at'    => null,
                'deleted_at'    => null,
                ];
            }
        return $imagem;
    }

    protected function infosJson(array $info)
    {
        $datetime = (isset($info['created_at']))?$info['created_at']:now()->toDateTimeString();
        return [
            (isset($info['tipo']))?$info['tipo']:'default'=>[
                $datetime => $info['body'],
            ]
        ];
    }

}
