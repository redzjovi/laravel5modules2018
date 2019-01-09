<?php

namespace Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
    ];

    protected $sortable = [
        'id',
        'title',
        'slug',
        'excerpt',
        'content',

        'created_at',
        'updated_at',
    ];

    protected $table = 'page';
}
