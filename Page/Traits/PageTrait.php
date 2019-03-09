<?php

namespace Modules\Page\Traits;

trait PageTrait
{
    public function scopeSearch($query, $parameters)
    {
        if (isset($parameters['title'])) {
            $query = $query->where('title_'.config('app.locale'), 'like', '%'.$parameters['title'].'%');
        }
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($parameters['title_'.$locale])) {
                $query = $query->where('title_'.$locale, 'like', '%'.$parameters['title_'.$locale].'%');
            }
        }
        if (isset($parameters['slug'])) {
            $query = $query->where('slug_'.config('app.locale'), $parameters['slug']);
        }
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($parameters['slug_'.$locale])) {
                $query = $query->where('slug_'.$locale, 'like', '%'.$parameters['slug_'.$locale].'%');
            }
        }
        if (isset($parameters['excerpt'])) {
            $query = $query->where('excerpt_'.config('app.locale'), 'like', '%'.$parameters['excerpt'].'%');
        }
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($parameters['excerpt_'.$locale])) {
                $query = $query->where('excerpt_'.$locale, 'like', '%'.$parameters['excerpt_'.$locale].'%');
            }
        }
        if (isset($parameters['content'])) {
            $query = $query->where('content_'.config('app.locale'), 'like', '%'.$parameters['content'].'%');
        }
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($parameters['content_'.$locale])) {
                $query = $query->where('content_'.$locale, 'like', '%'.$parameters['content_'.$locale].'%');
            }
        }


        if (isset($parameters['sort'])) {
            $sorts = explode(',', $parameters['sort']);
            collect($sorts)->map(function ($sort) use ($query) {
                if ($sort == 'title') {
                    $query = $query->orderBy('title_'.config('app.locale'));
                }
                if ($sort == '-title') {
                    $query = $query->orderBy('title_'.config('app.locale'), 'desc');
                }
                foreach (config('cms.locales') as $locale => $localeName) {
                    if ($sort == 'title_'.$locale) {
                        $query = $query->orderBy('title_'.$locale);
                    }
                    if ($sort == '-title_'.$locale) {
                        $query = $query->orderBy('title_'.$locale, 'desc');
                    }
                }
                if ($sort == 'slug') {
                    $query = $query->orderBy('slug_'.config('app.locale'));
                }
                if ($sort == '-slug') {
                    $query = $query->orderBy('slug_'.config('app.locale'), 'desc');
                }
                foreach (config('cms.locales') as $locale => $localeName) {
                    if ($sort == 'slug_'.$locale) {
                        $query = $query->orderBy('slug_'.$locale);
                    }
                    if ($sort == '-slug_'.$locale) {
                        $query = $query->orderBy('slug_'.$locale, 'desc');
                    }
                }
                if ($sort == 'excerpt') {
                    $query = $query->orderBy('excerpt_'.config('app.locale'));
                }
                if ($sort == '-excerpt') {
                    $query = $query->orderBy('excerpt_'.config('app.locale'), 'desc');
                }
                foreach (config('cms.locales') as $locale => $localeName) {
                    if ($sort == 'excerpt_'.$locale) {
                        $query = $query->orderBy('excerpt_'.$locale);
                    }
                    if ($sort == '-excerpt_'.$locale) {
                        $query = $query->orderBy('excerpt_'.$locale, 'desc');
                    }
                }
                if ($sort == 'content') {
                    $query = $query->orderBy('content_'.config('app.locale'));
                }
                if ($sort == '-content') {
                    $query = $query->orderBy('content_'.config('app.locale'), 'desc');
                }
                foreach (config('cms.locales') as $locale => $localeName) {
                    if ($sort == 'content_'.$locale) {
                        $query = $query->orderBy('content_'.$locale);
                    }
                    if ($sort == '-content_'.$locale) {
                        $query = $query->orderBy('content_'.$locale, 'desc');
                    }
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
        $page = self::createModel($attributes);

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
        foreach (config('cms.locales') as $locale => $localeName) {
            $attributes['slug_'.$locale] = str_slug($attributes['title_'.$locale]).'-'.$id;
        }
        $page = self::updateModelById($attributes, $id);

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
