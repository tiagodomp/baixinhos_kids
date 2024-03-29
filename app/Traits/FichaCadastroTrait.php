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
        $data = $b->where('nome', 'LIKE', $request->nomeB)
                    ->where('responsavel_uuid', $uuidR)
                    ->selectRaw('uuid as uuid, nome as nome, responsavel_uuid as responsavel_uuid')
                    ->first();

        if(empty($data)){
            $data = $b->create([
                'responsavel_uuid'          => $uuidR,
                'nome'                      => $request->nomeB,
                'nascimento'                => $request->nascimentoB,
                'sexo'                      => ($request->sexoB == 'menina')?true:false,
                'primeiro_corte'            => $request->primeiroCorteB,
                'autorizacao_audiovisual'   => $request->has('fichaCadastro'),
                'ficha_cadastro'            => null,
                'criado_por'                => auth()->user()->uuid,
                'imagens'                   => null,
                'historico'                 => $request->historico,
                'infos'                     => ($request->has('infosB'))?$this->infosJson($request->infosB):null,
                'created_at'                => now()->toDateTimeString(),
                'updated_at'                => null,
                'deleted_at'                => null,
            ]);

            $baix = $b->find($data->uuid);
            $baix->ficha_cadastro = ($request->hasfile('fichaCadastro'))?$this->imagensJson($request->fichaCadastro, $data->uuid):null;
            $baix->imagens = ($request->hasfile('imagensB'))?$this->imagensJson($request->imagensB, $data->uuid):null;
            $baix->save();
        }
        $path = '$.familia';
        return ($data->exists)
                    ?[
                        true, //$this->atualizarJsonTb('responsaveis', 'infos', ['uuid' => $data->responsavel_uuid], $path, [$data->nome, $data->uuid]),
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
                'imagens'                   => null,
                'infos'                     => ($request->has('infosR'))?$this->infosJson($request->infosR):null,
                'created_at'                => now()->toDateTimeString(),
                'updated_at'                => null,
                'deleted_at'                => null,
            ]);

            $resp = $r->find($data->uuid);
            $resp->imagens = ($request->hasFile('imagensR'))?$this->imagensJson($request->imagensR, $data->uuid):null;
            $resp->save();
        }

        return ($data->exists)?[true, $data->uuid]:[false, ''];
    }

    public function inserirCanal(Request $request, string $uuidCanal = '')
    {
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


    public function imagensJson(array $imagens, string $path)
    {
        $imagem = [];
        if(!empty($imagens))
            foreach($imagens as $img){
                $img->store($path);
                $imagem[] = [
                    'path'          => $path.'/'.$img->hashName(),
                    'size'          => $img->getClientSize(),
                    'mime_type'     => $img->getMimeType(),
                    'criado_por'    => [auth()->user()->nome, auth()->user()->uuid],
                    'created_at'    => now()->toDateTimeString(),
                    'updated_at'    => null,
                    'deleted_at'    => null,
                ];
            }

        return $imagem;
    }

    public function inserirImagens(string $Tb, string $uuid, $data, string $collumn = 'imagens',  string $path = '$')
    {
        $where = ['uuid' => $uuid];
        $return = $this->arrayInsertJsonTb($Tb, $collumn, $where, $data, $path);

        return $return;
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

    public function getResponsaveis()
    {
        $r = new Responsavel();
        $responsaveis = $r->getDataResponsaveis();
        foreach($responsaveis as $key => &$value){
            $responsaveis[$key]['contatos'] = [
                $value['contatos']['cell'],
                $value['contatos']['tell'],
                $value['contatos']['email']
            ];
            $responsaveis[$key]['filhos'] = $this->getFilhosResponsaveis($value['uuid'])['nomes'];
        }
        return $responsaveis;
    }

    public function getBaixinhos()
    {
        $r = new Baixinho();
        return $r->getDataBaixinhos();
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

    public function getCanais(int $quant = 0){
        $c = new Canal();
        $data = $c->selectRaw('titulo, uuid')
                    ->get();

        return $data->toArray();
    }


    public function searchResponsaveis(string $search)
    {
        $r = new Responsavel();
        return $r->searchResponsaveis($search);
    }

    public function searchBaixinhos(string $search)
    {
        $b = new Baixinho();
        return $b->searchBaixinhos($search);
    }

    public function searchCanais(string $search)
    {
        $c = new Canal();
        return $c->searchCanais($search);
    }

    public function searchUsers(string $search)
    {
        $u = new User();
        return $u->searchUsers($search);
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
