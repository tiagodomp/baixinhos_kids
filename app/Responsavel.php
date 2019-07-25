<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
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
        'uuid', 'nome', 'contatos', 'criado_por', 'imagens', 'ficha_cadastro', 'infos',
    ];

    protected $casts = [
        'contatos' => 'array',
        'criado_por' => 'array',
        'imagens' => 'array',
        'ficha_cadastro' => 'array',
        'infos' => 'array',
    ];
}
