<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CrudJsonTrait;

class Baixinho extends Model
{
    use CrudJsonTrait;

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
    protected $dates = ['nascimento', 'primeiro_corte', 'created_at', 'updated_at', 'deleted_at'];


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
        $historico = [
            date('\TYmdHis') => [
                'cabeleleiro'       => '',
                'responsavel'       => '',
                'tipo_corte'        => '',
                'obs'               => '',
                'metodo_pagamento'  => '',
                'agendado_para'     => '',
                'tag'               => false,
                'author'            => auth()->user()->uuid,
                'created_at'        => now()->toDateTimeString(),
            ]
        ];

        if(!empty($data))
            $historico = array_merge($historico, $data);

        return $historico;
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

}
