<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CrudJsonTrait;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Baixinho extends Model
{
    use CrudJsonTrait, SoftDeletes;

     /**
     * @var string Table name
     */
    public $table = 'baixinhos';

    /**
     * @var string UUID da tabela
     */
    public $primaryKey = 'uuid';

    /**
     * @var array Relations to load implicitly
     */
    public static $localWith = [];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['nascimento', 'created_at', 'updated_at', 'deleted_at'];


    protected $fillable = [
        'uuid','responsavel_uuid', 'nome', 'nascimento', 'primeiro_corte', 'autorizacao_audiovisual', 'ficha_cadastro', 'criado_por', 'historico', 'imagens', 'infos'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'ficha_cadastro' => 'array',
        'imagens' => 'array',
        'historico' => 'array',
        'infos' => 'array',
    ];

    /**
     * insere um novo dado no histórico do baixinho
     * @param string $baixinhoUuid
     * @param string $tipo
     * @param array $data
     * @return bool
     */
    public function setHistorico(string $baixinhoUuid, string $tipo, array $data){
        $return = [];
        switch($tipo){
            case "corte":
                $return = $this->historicoCorte($data);
            break;
            //abaixo acrecentar outros tipos de históricos
        }
        $pathJson = "$.".$tipo;

        return (!empty($return))?$this->atualizarJsonTb('baixinhos', 'historico', ['uuid' => $baixinhoUuid], $pathJson, $return):false;
    }

    /**
     * Modelo padrão para salvar o histórico de corte de cabelo do baixinho
     * @param array $data
     * @return array $historico
     */
    public function historicoCorte(array $data = []){
        if(!empty($data['stamp'])){
            $stamp = $data['stamp'];
        }else{
            $stamp = date('\TYmdHis');
            $data = [ $stamp => $data];
        }
        if(!empty($data)){
            $historico = [
                $stamp => [
                    'cabeleireiro'      => $data[$stamp]['cabeleireiro'], // 0=> nome, 1 => uuid
                    'responsavel'       => $data[$stamp]['responsavel'], // 0=> nome, 1 => uuid
                    'metodo_pagamento'  => $data[$stamp]['metodo_pagamento'],
                    'tipo_corte'        => $data[$stamp]['tipo_corte'],
                    'obs'               => $data[$stamp]['obs'],
                    'agendado_para'     => $data[$stamp]['agendado_para'],
                    'tag'               => $data[$stamp]['tag'],
                    'author'            => auth()->user()->uuid,
                    'created_at'        => now()->toDateTimeString(),
                ]
            ];
        }else{
            $historico = [
                $stamp => [
                    'cabeleireiro'      => [], // 0=> nome, 1 => uuid
                    'responsavel'       => [], // 0=> nome, 1 => uuid
                    'metodo_pagamento'  => [],
                    'tipo_corte'        => '',
                    'obs'               => '',
                    'agendado_para'     => '',
                    'tag'               => false,
                    'author'            => auth()->user()->uuid,
                    'created_at'        => now()->toDateTimeString(),
                ]
            ];
        }

        return $historico;
    }

    public function addHistorico(array $data, array $where)
    {
        $stamp = array_key_first($data);
        $path = '$.'.$stamp;
        return $this->atualizarJsonTb('baixinhos', 'historico', $where, $path, $data[$stamp]);
    }

    public function getIrmaos(string $responsavelUuid)
    {
        $data = $this->where('responsavel_uuid', $responsavelUuid)
                        ->selectRaw('nome, uuid')
                        ->get();

        return (!empty($data))?$data->toArray():[];
    }

    public function getFrequenciaHistorica(string $uuid = '')
    {
        $mesPassado = date('\TYm', strtotime('-1 Months'));

        if(!empty($uuid)){
            $data = $this->whereRaw("uuid = '".$uuid." AND 'JSON_SEARCH(JSON_KEYS(historico), 'all', '%".$mesPassado."%') IS NOT NULL")
                            ->selectRaw('nome, uuid')
                            ->get();
        }else{
            $data = $this->whereRaw("JSON_SEARCH(JSON_KEYS(historico), 'all', '%".$mesPassado."%') IS NOT NULL")
                            ->selectRaw('nome, uuid')
                            ->get();
        }
        return (!empty($data))?['total' => $data->count(), 'baixinhos' => $data->toArray()]:['total' => 0, 'baixinhos' => []];
    }

    public function getFichasEmBranco()
    {
        $data = $this->whereRaw("autorizacao_audiovisual = 0 AND ficha_cadastro IS NULL")
                            ->selectRaw('nome, uuid')
                            ->get();
        return (!empty($data))?['total' => $data->count(), 'baixinhos' => $data->toArray()]:['total' => 0, 'baixinhos' => []];
    }

    public function getPathUltimoHistorico(string $uuid)
    {

    }

    public function getListBaixinhos()
    {
        $data = $this->join('responsaveis', 'baixinhos.responsavel_uuid', '=', 'responsaveis.uuid')
                            ->selectRaw('baixinhos.uuid as uuidB, baixinhos.nome as nomeB, responsaveis.uuid as uuidR, responsaveis.nome as nomeR, baixinhos.primeiro_corte as primeiro_corte, JSON_KEYS(baixinhos.historico) as ultimo_corte')
                            ->get();
        $date = new Carbon();
        foreach($data as $key => &$value)
        {
            $data[$key]['primeiro_corte'] = $date->createFromFormat('Y-m-d',  $value['primeiro_corte'])->format('d/m/Y');
            $data[$key]['ultimo_corte'] = (!empty($value['ultimo_corte']))
                                            ?$date->createFromFormat('\TYmdHis',  Arr::last(json_decode($value['ultimo_corte'], true)))->format('d/m/Y')
                                            :$value['primeiro_corte'];
        }
        return (!empty($data))?$data->toArray():[];
    }

    public function getListHistoricaBaixinhos()
    {
        $data = $this->selectRaw('historico as historicoB, uuid as uuidB, nome as nomeB, sexo as sexoB')
                        ->get();
        $data = $data->toArray();
        foreach($data as $key => &$h){
            $data[$key]['historicoB'] = json_decode($h['historicoB'], true);
        }
        return $data;
    }

    public function viewBaixinho(string $uuid)
    {
        $data = $this->where('baixinhos.uuid', $uuid)
                        ->join('responsaveis', 'baixinhos.responsavel_uuid', '=', 'responsaveis.uuid')
                        ->join('canais', 'responsaveis.canal_id', '=', 'canais.uuid')
                        ->join('users', 'baixinhos.criado_por', '=', 'users.uuid')
                        ->selectRaw('baixinhos.nome as nomeB,
                                    baixinhos.uuid as uuidB,
                                    baixinhos.nascimento as nascimentoB,
                                    baixinhos.sexo as sexoB,
                                    baixinhos.primeiro_corte as primeiro_corteB,
                                    baixinhos.autorizacao_audiovisual as autorizacaoB,
                                    baixinhos.ficha_cadastro as fichaB,
                                    baixinhos.imagens as imagensB,
                                    baixinhos.historico as historicoB,
                                    baixinhos.created_at as createdB,
                                    responsaveis.uuid as uuidR,
                                    responsaveis.nome as nomeR,
                                    responsaveis.contatos contatosR,
                                    canais.uuid as uuidC,
                                    canais.titulo as tituloC,
                                    canais.descricao as descricaoC,
                                    canais.tecnicas tecnicasC,
                                    users.uuid as uuidU,
                                    users.nome as nomeU,
                                    users.email as emailU,
                                    users.apelido as apelidoU')
                        ->first();

        if(!empty($data)){
            $data = $data->toArray();
            $data['historicoB'] = json_decode($data['historicoB'], true);
            $data['contatosR']  = json_decode($data['contatosR'], true);
            $data['imagensB']   = json_decode($data['imagensB'], true);
            $data['fichaB']     = json_decode($data['fichaB'], true);
        }
        return $data;
    }

    public function editBaixinhos(array $data, string $uuid)
    {
        $b = new Baixinho();
        $b->find($uuid);
        $b->responsavel_uuid          = $data['uuidR'];
        $b->nome                      = $data['nomeB'];
        $b->nascimento                = $data['nascimentoB'];
        $b->sexo                      = ($data['sexoB'] == 'menina')?true:false;
        $b->primeiro_corte            = $data['primeiroCorteB'];
        $b->autorizacao_audiovisual   = $data['autorizacao_audiovisual'];
        $b->ficha_cadastro            = $data['ficha_cadastro'];
        $b->infos                     = $data['infos'];
        $b->updated_at                = now()->toDateTimeString();

        return $b->save();
    }

    public function getImgGaleria()
    {
        $imgs = $this->selectRaw("  uuid,
                                    nome as nomeB,
                                    imagens->>'$[*].path' as paths,
                                    imagens->>'$[*].deleted_at' as deleteds,
                                    imagens->>'$[*].criado_por' as criado_por,
                                    imagens->>'$[*].created_at' as createds")
                        ->get();

        $data = [];
        foreach($imgs as $key => $img){
            $deletados  = json_decode($img->deleteds, true);
            $paths      = json_decode($img->paths, true);
            $criado_por = json_decode($img->criado_por, true);
            $createds   = json_decode($img->createds, true);

            foreach($deletados as $count => $del){
                if(empty($del)){
                    $data[$key]['imagens'][] =[
                        'path'         => $paths[$count],          //string
                        'criado_por'   => $criado_por[$count],     //array [nomeUser, uuidUser]
                        'created_at'   => $createds[$count],       //string datetime
                    ];
                }
            }
            $data[$key]['uuidB']        = $img->uuid;
            $data[$key]['nomeB']        = $img->nomeB;
        }

        return $data;
    }

    public function getImgFichaCadastro()
    {
        $imgs = $this->selectRaw("  uuid,
                                    nome as nomeB,
                                    ficha_cadastro->>'$[0].path' as path,
                                    ficha_cadastro->>'$[0].deleted_at' as deleted,
                                    ficha_cadastro->>'$[0].criado_por' as criado_por,
                                    ficha_cadastro->>'$[0].created_at' as created")
                        ->get();

        $data = [];
        foreach($imgs as $key => $img){
            if(is_null($img->deleted) || $img->deleted == 'null'){
                $data[$key]['ficha'] =[
                    'path'         => $img->path,          //string
                    'criado_por'   => $img->criado_por,    //array [nomeUser, uuidUser]
                    'created_at'   => $img->created,       //string datetime
                ];

                $data[$key]['uuidB']        = $img->uuid;
                $data[$key]['nomeB']        = $img->nomeB;
            }
        }
        return $data;
    }

    public function delBaixinhos(string $uuid)
    {
        $b = $this->find($uuid);
        $b->deleted_at = now();
        return $b->save();
    }

    public function getDataBaixinhos()
    {
        $data = $this->join('responsaveis', 'baixinhos.responsavel_uuid', '=', 'responsaveis.uuid')
                        ->selectRaw('baixinhos.nome as nomeB, baixinhos.uuid as uuidB, responsaveis.uuid as uuidR, responsaveis.nome as nomeR')
                        ->get();

        return $data->toArray();
    }
}
