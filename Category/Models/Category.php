<?php

namespace Modules\Category\Models;

use Modules\Cms\Models\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Category extends Model implements HasMedia
{
    use \Modules\Category\Traits\CategoryTrait;
    use \Modules\Cms\Traits\ModelTrait;
    use \Modules\Cms\Traits\SortableTrait;
    use \Spatie\MediaLibrary\HasMedia\HasMediaTrait;

    protected $table = 'category';

    public function getContentAttribute()
    {
        return $this->{'content_'.config('app.locale')};
    }

    public function getExcerptAttribute()
    {
        return $this->{'excerpt_'.config('app.locale')};
    }

    public function getSlugAttribute()
    {
        return $this->{'slug_'.config('app.locale')};
    }

    public function getTitleAttribute()
    {
        return $this->{'title_'.config('app.locale')};
    }

    public function pages()
    {
        return $this->morphedByMany(\Modules\Page\Models\Page::class, 'categorizable');
    }
}
