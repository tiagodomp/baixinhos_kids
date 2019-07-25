<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baixinho extends Model
{
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
        'uuid','responsavel_uuid', 'nome', 'nascimento', 'primeiro_corte', 'autorizacao_audiovisual', 'criado_por', 'imagens', 'infos'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'criado_por' => 'array',
        'imagens' => 'array',
        'infos' => 'array',
    ];
}
