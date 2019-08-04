<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Baixinho;
use App\Canal;
use App\Responsavel;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Traits\CrudJsonTrait;

trait FichaCadastroTrait
{
    use CrudJsonTrait;

    public function novaFichaCadastro(Request $request)
    {
        $uuidCanal  = ($request->has('uuidCanal'))
                        ?$request->uuidCanal
                        :$this->inserirCanal($request)[1];

        $uuidR      = ($request->has('uuidR') && !empty($uuidCanal))
                        ?$request->uuidR
                        :$this->inserirResponsavel($request, $uuidCanal)[1];

        return (!empty($uuidR))??$this->inserirBaixinho($request, $uuidR);
    }

    public function inserirBaixinho(Request $request, string $uuidR = '')
    {
        $uuid = Str::uuid()->toString();
        $b = Baixinho::create([
            'uuid'                      => $uuid,
            'responsavel_uuid'          => ($request->has('uuidR'))?$request->uuidR:$uuidR,
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

        return ($b == 1 || $b == true)?[true, $uuid]:[false, ''];
    }

    public function inserirResponsavel(Request $request, string $uuidCanal = '')
    {
        $uuid = Str::uuid()->toString();
        $r = Responsavel::create([
            'uuid'                      => $uuid,
            'nome'                      => $request->nomeR,
            'contatos'                  => $request->contatosR,
            'canais_id'                 => ($request->has('UuidCanal'))?$request->UuidCanal:$uuidCanal,
            'criado_por'                => auth()->user()->uuid,
            'imagens'                   => ($request->has('imagensR'))?$this->imagensJson($request->imagensR):null,
            'infos'                     => ($request->has('infosR'))?$this->infosJson($request->infosR):null,
            'created_at'                => now()->toDateTimeString(),
            'updated_at'                => null,
            'deleted_at'                => null,
        ]);

        return ($r == 1 || $r == true)?[true, $uuid]:[false, ''];
    }

    public function inserirCanal(Request $request, string $uuidCanal = '')
    {
        if($request->has('uuidCanal')){
            $uuid = $request->uuidCanal;
        }elseif(!empty($uuidCanal)){
            $uuid = $uuidCanal;
        }else{
            $uuid = Str::uuid()->toString();
        }

        $c = Canal::create([
            'uuid'                      => $uuid,
            'titulo'                    => $request->tituloCanal,
            'descricao'                 => $request->descricaoCanal,
            'tecnicas'                  => $request->tecnicasCanal,
            'criado_por'                => auth()->user()->uuid,
            'infos'                     => ($request->has('infosCanal'))?$this->infosJson($request->infosCanal):null,
            'created_at'                => now()->toDateTimeString(),
            'updated_at'                => null,
            'deleted_at'                => null,
        ]);

        return ($c == 1 || $c == true)?[true, $uuid]:[false, ''];
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
