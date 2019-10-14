<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CrudJsonTrait;
use Illuminate\Support\Facades\DB;

class Responsavel extends Model
{

    use CrudJsonTrait;
     /**
     * @var string Table name
     */
    public $table = 'responsaveis';

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
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    protected $fillable = [
        'uuid', 'nome', 'contatos', 'canal_id', 'criado_por', 'imagens', 'ficha_cadastro', 'infos',
    ];

    protected $casts = [
        'contatos' => 'array',
        'imagens' => 'array',
        'ficha_cadastro' => 'array',
        'infos' => 'array',
    ];

    public function getDataResponsaveis(){
        $data = $this->join('baixinhos', 'responsaveis.uuid', '=', 'baixinhos.responsavel_uuid')
                        ->selectRaw('responsaveis.uuid as uuid, responsaveis.nome as nome, responsaveis.contatos->>"$[0]" as contatos, baixinhos.nome as filhos, baixinhos.uuid as uuidfilhos')
                        ->get();

        return $data->toArray();
    }

    public function searchResponsaveis(array $where){
        $whereString = $this->geradorWhereString($where);
        $data = $this->whereRaw($whereString)
                        ->join('baixinhos', 'responsaveis.uuid', '=', 'baixinhos.responsavel_uuid')
                        ->selectRaw('responsaveis.uuid as uuid, responsaveis.nome as nome, responsaveis.contatos->>"$[0]" as contatos, baixinhos.nome as filhos, baixinhos.uuid as uuidfilhos')
                        ->get();

        return $data->toArray();
    }

    public function getRankingCanais()
    {
        $data = $this->join('canais', 'responsaveis.canal_id', '=', 'canais.uuid')
                        ->selectRaw('responsaveis.canal_id as uuid, canais.titulo as titulo, COUNT(*) as totalMembros')
                        ->groupBy('responsaveis.canal_id')
                        ->orderBy('totalMembros','DESC')
                        ->get();

        $data->toArray();
        return (!empty($data))?$data->toArray():[['totalMembros' => 0, 'titulo'=>'', 'uuid' => '']];
    }

    public function getListResponsaveis()
    {
        $data = $this->join('canais', 'responsaveis.canal_id', '=', 'canais.uuid')
                        ->join('users', 'responsaveis.criado_por', '=', 'users.uuid')
                        ->selectRaw('responsaveis.uuid as uuidR, responsaveis.nome as nomeR, responsaveis.contatos as contatosR, responsaveis.created_at as created_at, canais.uuid as uuidC, canais.titulo as tituloC, users.uuid as uuidU, users.nome as nomeU')
                        ->get();

        return $data->toArray();
    }
}
