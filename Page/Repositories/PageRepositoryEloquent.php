<?php

namespace Modules\Page\Repositories;

use Modules\Page\Models\Page;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Repositories\Contracts\PageCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class PageRepositoryEloquent.
 *
 * @package namespace Modules\PageRepositories;
 */
class PageRepositoryEloquent extends BaseRepository implements CacheableInterface, PageRepository
{
    use CacheableRepository;

    protected $fieldSearchable = [
        'title' => 'like',
        'slug' => 'like',
        'excerpt' => 'like',
        'content' => 'like',
    ];

    public function getModel()
    {
        return new Page;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Page::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //
    }

    public function create(array $attributes)
    {
        $attributes['slug'] = str_slug($attributes['title']);
        $model = parent::create($attributes);

        $model = $this->update($attributes, $model->id);

        return $model;
    }

    public function update(array $attributes, $id)
    {
        $attributes['slug'] = str_slug($attributes['title']).'-'.$id;
        $model = parent::update($attributes, $id);

        return $model;
    }
}
