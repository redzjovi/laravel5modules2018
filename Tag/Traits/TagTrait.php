<?php

namespace Modules\Tag\Traits;

trait TagTrait
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

    public static function createTag(array $attributes = [])
    {
        $tag = self::createModel($attributes);
        $tag = self::updateTagById($attributes, $tag->id);

        return $tag;
    }

    public static function getTags($parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['per_page'])) {
            $query = $query->paginate((int) $parameters['per_page'])->appends($parameters);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    /**
     * @param array $titles
     * @return array $tagIds
     */
    public static function getTagIdsOrCreateTagsByTitles(array $titles)
    {
        $tags = collect($titles)->map(function ($title) {
            $tag = self::where('title_'.config('app.locale'), $title)->first();

            if (! $tag) {
                $attributes = [];

                foreach (config('cms.locales') as $locale => $localeName) {
                    $attributes['title_'.$locale] = $title;
                }

                $tag = self::createTag($attributes);
            }

            return $tag;
        });

        $tagIds = $tags->pluck('id', 'id')->values()->toArray();

        return $tagIds;
    }

    public static function updateTagById(array $attributes = [], int $id)
    {
        // 1. Model update
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($attributes['title_'.$locale])) {
                $attributes['slug_'.$locale] = str_slug($attributes['title_'.$locale]).'-'.$id;
            }
        }
        $tag = self::updateModelById($attributes, $id);

        // 2. Medium, image, delete
        $media = $tag->getMedia('tag_image');
        if (isset($attributes['image_id'])) {
            $media = $media->whereNotIn('id', $attributes['image_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });

        // 3. Medium, image, add
        if (isset($attributes['image'])) {
            collect($attributes['image'])->each(function ($image) use ($tag) {
                $tag->addMedia($image)->toMediaCollection('tag_image', 'media');
            });
        }

        // 4. Medium, gallery, delete
        $media = $tag->getMedia('tag_gallery');
        if (isset($attributes['gallery_id'])) {
            $media = $media->whereNotIn('id', $attributes['gallery_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });

        // 5. Medium, gallery, add
        if (isset($attributes['gallery'])) {
            collect($attributes['gallery'])->each(function ($gallery) use ($tag) {
                $tag->addMedia($gallery)->toMediaCollection('tag_gallery', 'media');
            });
        }

        return $tag;
    }
}
