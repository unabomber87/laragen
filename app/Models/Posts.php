<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Posts
 * @package App\Models
 * @version May 29, 2017, 10:43 am UTC
 */
class Posts extends Model
{
    use SoftDeletes;

    public $table = 'posts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'content',
        'user_id',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'content' => 'string',
        'user_id' => 'integer',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    
}
