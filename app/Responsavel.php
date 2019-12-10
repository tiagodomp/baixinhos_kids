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
        $data = $this->leftJoin('baixinhos', 'responsaveis.uuid', '=', 'baixinhos.responsavel_uuid')
                        ->selectRaw('responsaveis.uuid as uuid, responsaveis.nome as nome, responsaveis.contatos->>"$[0]" as contatos, baixinhos.nome as filhos, baixinhos.uuid as uuidfilhos')
                        ->get();

        return (!empty($data))?$data->toArray():[];
    }


    public function searchResponsaveis(string $search){
        //->whereRaw("responsaveis.nome LIKE '%?%' OR responsaveis.contatos->>'$[0].cell' LIKE '%?%' OR responsaveis.contatos->>'$[0].tell' LIKE '%?%' OR responsaveis.contatos->>'$[0].email' LIKE '%?%'", [$search, $search, $search, $search])
        $r = $this->leftJoin('baixinhos', 'responsaveis.uuid', '=', 'baixinhos.responsavel_uuid')
                    ->selectRaw('responsaveis.uuid as uuidR, responsaveis.nome as nomeR, responsaveis.contatos->>"$[0]" as contatosR, baixinhos.nome as nomeB, baixinhos.uuid as uuidB')
                    ->where('responsaveis.nome', 'LIKE', '%'.$search.'%')
                    ->orWhere("responsaveis.contatos->>'$[0].cell'", '%'.$search.'%')
                    ->orWhere("responsaveis.contatos->>'$[0].tell'", '%'.$search.'%')
                    ->orWhere("responsaveis.contatos->>'$[0].email'", '%'.$search.'%')
                    ->limit(30)
                    ->get();
        
        if(!empty($r) && !empty($r->toArray())){
            $retornos = (array) $r->toArray();
            if(empty($retornos))
                return [];

            foreach($retornos as $key => $resp){
                $data[$key] = [
                    'uuidR'         => $resp['uuidR'],
                    'nomeR'         => $resp['nomeR'],
                    'contatosR'     => json_decode($resp['contatosR'], true),
                    'filhos'        => ['uuidB' => $resp['uuidB'], 'nomeB' => $resp['nomeB']]
                ];
            }
        }
        return (!empty($data))?$data:[];
    }

    public function getRankingCanais()
    {
        $data = $this->join('canais', 'responsaveis.canal_id', '=', 'canais.uuid')
                        ->selectRaw('responsaveis.canal_id as uuid, canais.titulo as titulo, COUNT(*) as totalMembros')
                        ->groupBy('responsaveis.canal_id')
                        ->orderBy('totalMembros','DESC')
                        ->get();

        return (!empty($data))?$data->toArray():[['totalMembros' => 0, 'titulo'=>'', 'uuid' => '']];
    }

    public function getListResponsaveis()
    {
        $data = $this->leftJoin('canais', 'responsaveis.canal_id', '=', 'canais.uuid')
                        ->leftJoin('users', 'responsaveis.criado_por', '=', 'users.uuid')
                        ->selectRaw('responsaveis.uuid as uuidR, responsaveis.nome as nomeR, responsaveis.contatos as contatosR, responsaveis.created_at as created_at, canais.uuid as uuidC, canais.titulo as tituloC, users.uuid as uuidU, users.nome as nomeU')
                        ->get();

        return $data->toArray();
    }

    public function viewResponsavel(string $uuid)
    {
        $r = $this->where('responsaveis.uuid', $uuid)
                        ->leftJoin('baixinhos', 'responsaveis.uuid', '=', 'baixinhos.responsavel_uuid')
                        ->leftJoin('canais', 'responsaveis.canal_id', '=', 'canais.uuid')
                        ->leftJoin('users', 'responsaveis.criado_por', '=', 'users.uuid')
                        ->selectRaw('responsaveis.nome as nomeR,
                                    responsaveis.uuid as uuidR,
                                    responsaveis.contatos as contatosR,
                                    responsaveis.imagens as imagensR,
                                    responsaveis.infos as infosR,
                                    responsaveis.created_at as created_atR,
                                    responsaveis.updated_at as updated_atR,
                                    baixinhos.uuid as uuidB,
                                    baixinhos.nome as nomeB,
                                    baixinhos.nascimento as nascimentoB,
                                    baixinhos.autorizacao_audiovisual as autorizacao_audiovisualB,
                                    baixinhos.ficha_cadastro as ficha_cadastroB,
                                    baixinhos.imagens as imagensB,
                                    canais.uuid as uuidC,
                                    canais.titulo as tituloC,
                                    users.uuid as uuidU,
                                    users.nome as nomeU')
                        ->get();
        if(!empty($r) && !empty($r->toArray())){
            $retornos = $r->toArray();
            if(!isset($retornos[0]))
                return [];
            $data = [
                'nomeR'         => $retornos[0]['nomeR'],
                'uuidR'         => $retornos[0]['uuidR'],
                'contatosR'     => json_decode($retornos[0]['contatosR'], true),
                'imagensR'      => $retornos[0]['imagensR'],
                'infosR'        => $retornos[0]['infosR'],
                'created_atR'   => $retornos[0]['created_atR'],
                'updated_atR'   => $retornos[0]['updated_atR'],
                'uuidC'         => $retornos[0]['uuidC'],
                'tituloC'       => $retornos[0]['tituloC'],
                'uuidU'         => $retornos[0]['uuidU'],
                'nomeU'         => $retornos[0]['nomeU'],
            ];
            foreach($retornos as $key => $ret){
                if(!empty($ret['uuidB'])){
                    $data['filhos'][$key]['uuidB']                      = $ret['uuidB'];
                    $data['filhos'][$key]['nomeB']                      = $ret['nomeB'];
                    $data['filhos'][$key]['nascimentoB']                = $ret['nascimentoB'];
                    $data['filhos'][$key]['autorizacao_audiovisualB']   = $ret['autorizacao_audiovisualB'];
                    $data['filhos'][$key]['ficha_cadastroB']            = json_decode($ret['ficha_cadastroB'], true);
                    $data['filhos'][$key]['imagensB']                   = json_decode($ret['imagensB'], true);
                }else{
                    $data['filhos'] = [];
                }
            }
        }
        return !empty($data)?$data:[];
    }
}
