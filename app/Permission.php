<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
     /**
     * @var string Table name
     */
    public $table = 'permissions';

    /**
     * @var string UUID da tabela
     */
    public $primaryKey = 'id';

    /**
     * @var array Relations to load implicitly
     */
    public static $localWith = [];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];


    protected $fillable = ['name','guard_name', 'created_at', 'updated_at'];

}
