<?php

namespace Modules\Menu\Traits;

use Modules\Tag\Models\Tag;

trait MenuTrait
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
        if (isset($parameters['excerpt'])) {
            $query = $query->where('excerpt_'.config('app.locale'), 'like', '%'.$parameters['excerpt'].'%');
        }
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($parameters['excerpt_'.$locale])) {
                $query = $query->where('excerpt_'.$locale, 'like', '%'.$parameters['excerpt_'.$locale].'%');
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

    public static function createMenu(array $attributes = [])
    {
        $menu = self::createModel($attributes);
        $menu = self::updateMenuById($attributes, $menu->id);

        return $menu;
    }

    public static function getMenus($parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['per_page'])) {
            $query = $query->paginate((int) $parameters['per_page'])->appends($parameters);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public static function updateMenuById(array $attributes = [], int $id)
    {
        // 1. Model update
        $menu = self::updateModelById($attributes, $id);

        // 2. Medium, image, delete
        $media = $menu->getMedia('menu_image');
        if (isset($attributes['image_id'])) {
            $media = $media->whereNotIn('id', $attributes['image_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });

        // 3. Medium, image, add
        if (isset($attributes['image'])) {
            collect($attributes['image'])->each(function ($image) use ($menu) {
                $menu->addMedia($image)->toMediaCollection('menu_image', 'media');
            });
        }

        // 4. Medium, gallery, delete
        $media = $menu->getMedia('menu_gallery');
        if (isset($attributes['gallery_id'])) {
            $media = $media->whereNotIn('id', $attributes['gallery_id']);
        }
        $media->each(function ($medium) {
            $medium->delete();
        });

        // 5. Medium, gallery, add
        if (isset($attributes['gallery'])) {
            collect($attributes['gallery'])->each(function ($gallery) use ($menu) {
                $menu->addMedia($gallery)->toMediaCollection('menu_gallery', 'media');
            });
        }

        return $menu;
    }
}
