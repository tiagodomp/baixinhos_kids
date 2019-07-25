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
        'uuid', 'titulo', 'descricao', 'tecnicas', 'infos',
    ]
}
