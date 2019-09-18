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
        if(!empty($request->canalUuid)){
            $uuidCanal = $request->canalUuid;
        }else{
            $canal = $this->inserirCanal($request);
            $uuidCanal = ($canal[0])?$canal[1]:'';
        }

        if(!empty($request->responsavelUuid)){
            $uuidR = $request->responsavelUuid;
        }else{
           $responsavel = (!empty($uuidCanal))?$this->inserirResponsavel($request, $uuidCanal):[false, ''];
           $uuidR = ($responsavel[0])?$responsavel[1]:'';
        }

        return (!empty($uuidR))?$this->inserirBaixinho($request, $uuidR):[false, ''];
    }

    public function inserirBaixinho(Request $request, string $uuidR = '')
    {
        $b = new Baixinho();
        $uuidR = (!empty($request->responsavelUuid))?$request->responsavelUuid:$uuidR;
        $data = $b->where('nome', 'LIKE', $request->nomeR)
                    ->where('responsavel_uuid', $uuidR)
                    ->select('uuid as uuid, nome as nome, responsavel_uuid as responsavel_uuid')
                    ->first();

        if(empty($data)){
            $data = $b->create([
                'responsavel_uuid'          => $uuidR,
                'nome'                      => $request->nomeB,
                'nascimento'                => $request->nascimentoB,
                'primeiro_corte'            => $request->primeiroCorteB,
                'autorizacao_audiovisual'   => $request->has('autorizacaoR'),
                'ficha_cadastro'            => ($request->has('fichaCadastro'))?$this->imagensJson($request->fichaCadastro):null,
                'criado_por'                => auth()->user()->uuid,
                'imagens'                   => ($request->has('imagensB'))?$this->imagensJson($request->imagensB):null,
                'historico'                 => $request->historico,
                'infos'                     => ($request->has('infosB'))?$this->infosJson($request->infosB):null,
                'created_at'                => now()->toDateTimeString(),
                'updated_at'                => null,
                'deleted_at'                => null,
            ]);
        }

        $path = '$.familia.'.$data->nome;
        return ($data->exists)
                    ?[
                        true, //$this->atualizarJsonTb('responsaveis', 'infos', ['uuid' => $data->responsavel_uuid], $path, [$data->uuid]),
                        $data->uuid
                    ]
                    :[false, ''];
    }

    public function inserirResponsavel(Request $request, string $uuidCanal = '')
    {

        $r = new Responsavel();

        $data = $r->where('nome', 'LIKE', $request->nomeR)
                    ->select('uuid as uuid')
                    ->first();

        if(empty($data)){
            $data = $r->create([
                'nome'                      => $request->nomeR,
                'contatos'                  => $request->contatosR,
                'canal_id'                  => (!empty($request->canalUuid))?$request->canalUuid:$uuidCanal,
                'criado_por'                => auth()->user()->uuid,
                'imagens'                   => ($request->has('imagensR'))?$this->imagensJson($request->imagensR):null,
                'infos'                     => ($request->has('infosR'))?$this->infosJson($request->infosR):null,
                'created_at'                => now()->toDateTimeString(),
                'updated_at'                => null,
                'deleted_at'                => null,
            ]);
        }

        return ($data->exists)?[true, $data->uuid]:[false, ''];
    }

    public function inserirCanal(Request $request, string $uuidCanal = '')
    {
        // if(!empty($request->canalUuid)){
        //     $uuid = $request->canalUuid;
        // }elseif(!empty($uuidCanal)){
        //     $uuid = $uuidCanal;
        // }else{
        //     $uuid = Str::uuid()->toString();
        // }
            $c = new Canal();

            $data = $c->where('titulo', 'LIKE', $request->tituloCanal)
                    ->select('uuid as uuid')
                    ->first();

            if(empty($data)){
               $data = $c->create([
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
        return ($data->exists)?[true, $data->uuid]:[false, ''];
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
        return json_encode($imagem);
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


    public function getResponsaveis(int $quant, string $uuid = null)
    {
        $r = new Responsavel();
        return $r->getDataResponsaveis($quant, $uuid);
    }

    public function getFilhosResponsaveis(string $responsavelUuid)
    {
        $b = new Baixinho();
        $filhos = $b->getIrmaos($responsavelUuid);
        $data = [
            'nomes' => [],
            'uuids' => [],
        ];
        foreach($filhos as $key => $value){
            $data['nomes'][] = $value['nome'];
            $data['uuids'][] = $value['uuid'];
        }
        return $data;
    }

    public function getCanais(int $quant){
        $c = new Canal();
        $data = $c->selectRaw('titulo, uuid')
                    ->offset(0)
                    ->limit($quant)
                    ->get();

        return $data->toArray();
    }


    public function searchResponsaveis(string $search, string $uuid = null)
    {
        $r = new Responsavel;
        $where = ["nome LIKE %".$search."% OR contatos->>'$[0].cell' LIKE %".$search."% OR contatos->>'$[0].tell' LIKE %".$search."% OR contatos->>'$[0].email' LIKE %".$search."%"];
        return $r->searchResponsaveis($where);
    }

    public function getBaixinhosFrequentes()
    {
        $b = new Baixinho();
        return $b->getFrequenciaHistorica();
    }

    public function getFichasFaltando()
    {
        $b = new Baixinho();
        return $b->getFichasEmBranco();
    }

    public function getCanaisResponsaveis()
    {
        $r = new Responsavel();
        return $r->getRankingCanais();
    }
}
