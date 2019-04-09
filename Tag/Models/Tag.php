<?php

namespace Modules\Tag\Models;

use Modules\Cms\Models\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Tag extends Model implements HasMedia
{
    use \Modules\Cms\Traits\ModelTrait;
    use \Modules\Cms\Traits\SortableTrait;
    use \Modules\Tag\Traits\TagTrait;
    use \Spatie\MediaLibrary\HasMedia\HasMediaTrait;

    protected $table = 'tag';

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
}
