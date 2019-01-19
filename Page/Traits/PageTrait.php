<?php

namespace Modules\Page\Traits;

trait PageTrait
{
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


        if (isset($parameters['sort'])) {
            $sorts = explode(',', $parameters['sort']);
            collect($sorts)->map(function ($sort) use ($query) {
                if ($sort == 'title') {
                    $query = $query->orderBy('title');
                }
                if ($sort == '-title') {
                    $query = $query->orderBy('title', 'desc');
                }
                if ($sort == 'slug') {
                    $query = $query->orderBy('slug');
                }
                if ($sort == '-slug') {
                    $query = $query->orderBy('slug', 'desc');
                }
                if ($sort == 'excerpt') {
                    $query = $query->orderBy('excerpt');
                }
                if ($sort == '-excerpt') {
                    $query = $query->orderBy('excerpt', 'desc');
                }
                if ($sort == 'content') {
                    $query = $query->orderBy('content');
                }
                if ($sort == '-content') {
                    $query = $query->orderBy('content', 'desc');
                }
                if ($sort == 'updated_at') {
                    $query = $query->orderBy('updated_at');
                }
                if ($sort == '-updated_at') {
                    $query = $query->orderBy('updated_at', 'desc');
                }
            });
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

        if (isset($parameters['per_page'])) {
            $query = $query->paginate((int) $parameters['per_page'])->appends($parameters);
        } else {
            $query = $query->get();
        }

        return $query;
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
