<?php

namespace Modules\Page\Repositories;

use Modules\Page\Models\Page;

class PageRepository extends Page
{
    use \Modules\Cms\Traits\ModelRepositoryTrait;
    use \Modules\Cms\Traits\SortableTrait;

    public function scopeSearch($query, $parameters)
    {
        if (isset($parameters['title'])) {
            $query = $query->where('title', 'like', '%'.$parameters['title'].'%');
        }

        if (isset($parameters['slug'])) {
            $query = $query->where('slug', $parameters['slug']);
        }

        if (isset($parameters['excerpt'])) {
            $query = $query->where('excerpt', 'like', '%'.$parameters['excerpt'].'%');
        }

        if (isset($parameters['content'])) {
            $query = $query->where('content', 'like', '%'.$parameters['content'].'%');
        }

        if (isset($parameters['orderBy']) && isset($parameters['sortedBy'])) {
            $orderBys = explode(',', $parameters['orderBy']);
            $sortedBys = explode(',', $parameters['sortedBy']);

            foreach ($orderBys as $i => $orderBy) {
                $query = $query->orderBy($orderBy, $sortedBys[$i]);
            }
        }

        if (isset($parameters['with'])) {
            $query = $query->with($parameters['with']);
        }

        return $query;
    }

    public static function createAttributes(array $attributes = [])
    {
        $attributes['slug'] = str_slug($attributes['title']);
        $page = self::create($attributes);

        $page = self::updateAttributesById($attributes, $page->id);
        return $page;
    }

    public static function getPages($parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['paginate']) && $parameters['paginate'] == 1) {
            $pages = $query->paginate();
        } else {
            $pages = $query->get();
        }

        return $pages;
    }

    public static function updateAttributesById(array $attributes = [], int $id)
    {
        $attributes['slug'] = str_slug($attributes['title']).'-'.$id;
        return self::updateById($attributes, $id);
    }
}
