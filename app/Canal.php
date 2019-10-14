<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    /**
     * @var string Table name
     */
    public $table = 'canais';

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
        'uuid', 'titulo', 'descricao', 'tecnicas', 'criado_por', 'infos',
    ];

    protected $casts = [
        'infos' => 'array',
    ];

    public function getListCanais()
    {
        $c = $this->join('users', 'canais.criado_por', '=', 'users.uuid')
                    ->selectRaw('canais.uuid as uuidC, canais.titulo as tituloC, canais.descricao as descricaoC, canais.tecnicas as tecnicasC, canais.created_at as created_at, users.uuid as uuidU, users.nome as nomeU')
                    ->get();

        return (!empty($c))?$c->toArray():[];
    }
}
