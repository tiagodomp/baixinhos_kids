<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var string Table name
     */
    public $table = 'users';

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
        'uuid', 'nome', 'email', 'password', 'apelido', 'descricao', 'imagens',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'imagens' => 'array',
    ];
}
