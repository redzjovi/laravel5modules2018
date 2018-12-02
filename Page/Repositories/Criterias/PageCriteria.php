<?php

namespace Modules\Page\Repositories\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class PageCriteria implements CriteriaInterface
{
    protected $page;

    public function __construct($page)
    {
        $this->page = $page;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (isset($this->page['title'])) { $model = $model->where('title', 'like', '%'.$this->page['title'].'%'); }
        if (isset($this->page['slug'])) { $model = $model->where('slug', $this->page['slug']); }
        if (isset($this->page['excerpt'])) { $model = $model->where('excerpt', $this->page['excerpt']); }
        if (isset($this->page['content'])) { $model = $model->where('content', $this->page['content']); }

        return $model;
    }
}
