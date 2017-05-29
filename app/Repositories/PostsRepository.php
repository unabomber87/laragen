<?php

namespace App\Repositories;

use App\Models\Posts;
use InfyOm\Generator\Common\BaseRepository;

class PostsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'content',
        'user_id',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Posts::class;
    }
}
