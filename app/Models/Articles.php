<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Articles
 * @package App\Models
 * @version May 23, 2017, 4:55 pm UTC
 */
class Articles extends Model
{
    use SoftDeletes;

    public $table = 'articles';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'nom'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nom' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nom' => 'required'
    ];

    
}
