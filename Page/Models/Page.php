<?php

namespace Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Page extends Model implements HasMedia
{
    use \Modules\Cms\Traits\ModelTrait;
    use \Modules\Cms\Traits\SortableTrait;
    use \Modules\Page\Traits\PageTrait;
    use \Spatie\MediaLibrary\HasMedia\HasMediaTrait;

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
