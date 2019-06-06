<?php

namespace Modules\Theme\Models;

use Modules\Cms\Models\Model;

class Theme extends Model
{
    use \Modules\Cms\Traits\ModelTrait;
    use \Modules\Cms\Traits\SortableTrait;
    use \Modules\Theme\Traits\ThemeTrait;

    protected $table = 'theme';

    public function getContentAttribute()
    {
        return $this->{'content_'.config('app.locale')};
    }

    public function getTitleAttribute()
    {
        return $this->{'title_'.config('app.locale')};
    }
}
