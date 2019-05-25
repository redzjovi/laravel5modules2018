<?php

namespace Modules\Menu\Models;

use Modules\Cms\Models\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Menu extends Model implements HasMedia
{
    use \Modules\Cms\Traits\ModelTrait;
    use \Modules\Cms\Traits\SortableTrait;
    use \Modules\Menu\Traits\MenuTrait;
    use \Spatie\MediaLibrary\HasMedia\HasMediaTrait;

    protected $table = 'menu';

    public function getExcerptAttribute()
    {
        return $this->{'excerpt_'.config('app.locale')};
    }

    public function getTitleAttribute()
    {
        return $this->{'title_'.config('app.locale')};
    }
}
