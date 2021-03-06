<?php

namespace Modules\Page\Traits;

use Modules\Tag\Models\Tag;

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
                $query = $query->where('slug_'.$locale, $parameters['slug_'.$locale]);
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
        if (isset($parameters['redirect_to'])) {
            $query = $query->where('redirect_to', 'like', '%'.$parameters['redirect_to'].'%');
        }
        if (isset($parameters['category_id']) && is_array($parameters['category_id'])) {
            $query = $query->whereHas('categories', function ($queryTag) use ($parameters) {
                $queryTag->whereIn('id', $parameters['category_id']);
            });
        }
        if (isset($parameters['tag_id']) && is_array($parameters['tag_id'])) {
            $query = $query->whereHas('tags', function ($queryTag) use ($parameters) {
                $queryTag->whereIn('id', $parameters['tag_id']);
            });
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
            $parameters['with'] = collect($parameters['with'])->filter(function ($with) use ($query) {
                if (isset($query->{$with})) {
                    return true;
                }
                return false;
            })->toArray();

            $query = $query->with($parameters['with']);
        }

        return $query;
    }

    public static function createPage(array $attributes = [])
    {
        $page = self::createModel($attributes);
        $page = self::updatePageById($attributes, $page->id);

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

    public static function updatePageById(array $attributes = [], int $id)
    {
        // 1. Model, update
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($attributes['title_'.$locale])) {
                $attributes['slug_'.$locale] = str_slug($attributes['title_'.$locale]).'-'.$id;
            }
        }
        $page = self::updateModelById($attributes, $id);

        // 2. Category, sync
        $categoryIds = [];
        if (isset($attributes['category_id']) && is_array($attributes['category_id'])) {
            $categoryIds = $attributes['category_id'];
        }
        $page->categories()->sync($categoryIds);

        // 3. Medium, image, delete
        $media = $page->getMedia('page_image');
        if (isset($attributes['image_id'])) {
            $media = $media->whereNotIn('id', $attributes['image_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });

        // 4. Medium, image, add
        if (isset($attributes['image'])) {
            collect($attributes['image'])->each(function ($image) use ($page) {
                $page->addMedia($image)->toMediaCollection('page_image', 'media');
            });
        }

        // 5. Medium, gallery, delete
        $media = $page->getMedia('page_gallery');
        if (isset($attributes['gallery_id'])) {
            $media = $media->whereNotIn('id', $attributes['gallery_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });

        // 6. Medium, gallery, add
        if (isset($attributes['gallery'])) {
            collect($attributes['gallery'])->each(function ($gallery) use ($page) {
                $page->addMedia($gallery)->toMediaCollection('page_gallery', 'media');
            });
        }

        // 7. Tag, sync
        $tagIds = [];
        if (isset($attributes['tag_id']) && is_array($attributes['tag_id'])) {
            $tagIds = $attributes['tag_id'];
        }
        $page->tags()->sync($tagIds);

        return $page;
    }
}
