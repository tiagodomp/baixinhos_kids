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
    public function novaFichaCadastro(Request $request)
    {
        if($this->inserirResponsavel($request))
            if($this->inserirBaixinho($request))

    }

    public function inserirBaixinho(Request $request)
    {
        $b = Baixinho::create([
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
            'infos'                     => ($request->has('infosB'))?$this->infosJson($request->infosB):null,
            'created_at'                => now()->toDateTimeString(),
            'updated_at'                => null,
            'deleted_at'                => null,
        ]);

        return ($b == 1 || $b == true)?true:false;
    }

    public function inserirResponsavel(Request $request)
    {
        $r = Responsavel::create([
            'uuid'                      => Str::uuid()->toString(),
            'nome'                      => $request->nomeR,
            'contatos'                  => $request->contatosR,
            'canais_id'                 => $request->canais,
            'criado_por'                => auth()->user()->uuid,
            'imagens'                   => ($request->has('imagensR'))?$this->imagensJson($request->imagensR):null,
            'infos'                     => ($request->has('infosR'))?$this->infosJson($request->infosR):null,
            'created_at'                => now()->toDateTimeString(),
            'updated_at'                => null,
            'deleted_at'                => null,
        ]);

        return ($r == 1 || $r == true)?true:false;
    }

    public function inserirCanal(Request $request)
    {
        $c = Canal::create([
            'uuid'                      => Str::uuid()->toString(),
            'titulo'                    => $request->tituloCanal,
            'descricao'                 => $request->descricaoCanal,
            'tecnicas'                  => $request->tecnicasCanal,
            'criado_por'                => auth()->user()->uuid,
            'infos'                     => ($request->has('infosCanal'))?$this->infosJson($request->infosCanal):null,
            'created_at'                => now()->toDateTimeString(),
            'updated_at'                => null,
            'deleted_at'                => null,
        ]);
    }


    protected function imagensJson(array $imagens)
    {
        $imagem = [];
        if(count($imagens) >= 1)
            foreach($imagens as $img){
                $imagem[] = [
                'link_original' => (string) $img['original'],
                'link_miniatura'=> (string) $img['miniatura'],
                'mime_type'     => (string) $img['mimeType'],
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
                (isset($info['tipo']))?$info['tipo']:'default'=> [
                    $datetime => [
                        'body'  => $info['body'],
                        'header'=> Request::header(),
                    ]
                ]
            ];
    }

}
