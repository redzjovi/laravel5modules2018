<?php

namespace Modules\Category\Traits;

trait CategoryTrait
{
    public function scopeSearch($query, $parameters)
    {
        if (isset($parameters['id']) && is_array($parameters['id'])) {
            $query = $query->whereIn('id', $parameters['id']);
        }
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

    public static function createCategory(array $attributes = [])
    {
        $category = self::createModel($attributes);
        $category = self::updateCategoryById($attributes, $category->id);

        return $category;
    }

    public static function getCategories($parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['per_page'])) {
            $query = $query->paginate((int) $parameters['per_page'])->appends($parameters);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public static function updateCategoryById(array $attributes = [], int $id)
    {
        // 1. Model update
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($attributes['title_'.$locale])) {
                $attributes['slug_'.$locale] = str_slug($attributes['title_'.$locale]).'-'.$id;
            }
        }
        $category = self::updateModelById($attributes, $id);

        // 2. Medium, image, delete
        $media = $category->getMedia('category_image');
        if (isset($attributes['image_id'])) {
            $media = $media->whereNotIn('id', $attributes['image_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });

        // 3. Medium, image, add
        if (isset($attributes['image'])) {
            collect($attributes['image'])->each(function ($image) use ($category) {
                $category->addMedia($image)->toMediaCollection('category_image', 'media');
            });
        }

        // 4. Medium, gallery, delete
        $media = $category->getMedia('category_gallery');
        if (isset($attributes['gallery_id'])) {
            $media = $media->whereNotIn('id', $attributes['gallery_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });

        // 5. Medium, gallery, add
        if (isset($attributes['gallery'])) {
            collect($attributes['gallery'])->each(function ($gallery) use ($category) {
                $category->addMedia($gallery)->toMediaCollection('category_gallery', 'media');
            });
        }

        return $category;
    }
}
