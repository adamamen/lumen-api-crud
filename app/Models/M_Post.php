<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Post extends Model
{
    /**
     * @var string
     */
    protected $table = 'post';

    /**
     * @var array
     */
    protected $fillable = [
        'image', 'title', 'content',
    ];
}
