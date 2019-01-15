<?php

namespace Modules\Page\Repositories;

use Modules\Page\Models\Page;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class PageRepository extends Page implements HasMedia
{
    use \Modules\Cms\Traits\ModelTrait;
    use \Modules\Cms\Traits\SortableTrait;
    use \Spatie\MediaLibrary\HasMedia\HasMediaTrait;

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
        $page = self::updateById($attributes, $id);

        // delete image
        $media = $page->getMedia('page_image');
        if (isset($attributes['image_id'])) {
            $media = $media->whereNotIn('id', $attributes['image_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });
        // image to media
        if (isset($attributes['image'])) {
            collect($attributes['image'])->each(function ($image) use ($page) {
                $page->addMedia($image)->toMediaCollection('page_image', 'media');
            });
        }
        // delete gallery
        $media = $page->getMedia('page_gallery');
        if (isset($attributes['gallery_id'])) {
            $media = $media->whereNotIn('id', $attributes['gallery_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });
        // gallery to media
        if (isset($attributes['gallery'])) {
            collect($attributes['gallery'])->each(function ($gallery) use ($page) {
                $page->addMedia($gallery)->toMediaCollection('page_gallery', 'media');
            });
        }

        return $page;
    }
}
