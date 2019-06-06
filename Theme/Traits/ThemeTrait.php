<?php

namespace Modules\Theme\Traits;

trait ThemeTrait
{
    public function scopeSearch($query, $parameters)
    {
        if (isset($parameters['group'])) {
            $query = $query->where('group', $parameters['group']);
        }
        if (isset($parameters['section'])) {
            $query = $query->where('section', $parameters['section']);
        }
        if (isset($parameters['type'])) {
            $query = $query->where('type', $parameters['type']);
        }
        if (isset($parameters['value'])) {
            $query = $query->where('value', 'like', '%'.$parameters['value'].'%');
        }
        if (isset($parameters['title'])) {
            $query = $query->where('title_'.config('app.locale'), 'like', '%'.$parameters['title'].'%');
        }
        foreach (config('cms.locales') as $locale => $localeName) {
            if (isset($parameters['title_'.$locale])) {
                $query = $query->where('title_'.$locale, 'like', '%'.$parameters['title_'.$locale].'%');
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
                if ($sort == 'id') {
                    $query = $query->orderBy('id');
                }
                if ($sort == '-id') {
                    $query = $query->orderBy('id', 'desc');
                }
                if ($sort == 'group') {
                    $query = $query->orderBy('group');
                }
                if ($sort == '-group') {
                    $query = $query->orderBy('group', 'desc');
                }
                if ($sort == 'section') {
                    $query = $query->orderBy('section');
                }
                if ($sort == '-section') {
                    $query = $query->orderBy('section', 'desc');
                }
                if ($sort == 'type') {
                    $query = $query->orderBy('type');
                }
                if ($sort == '-type') {
                    $query = $query->orderBy('type', 'desc');
                }
                if ($sort == 'value') {
                    $query = $query->orderBy('value');
                }
                if ($sort == '-value') {
                    $query = $query->orderBy('value', 'desc');
                }
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
                if ($sort == 'created_at') {
                    $query = $query->orderBy('created_at');
                }
                if ($sort == '-created_at') {
                    $query = $query->orderBy('created_at', 'desc');
                }
                if ($sort == 'updated_at') {
                    $query = $query->orderBy('updated_at');
                }
                if ($sort == '-updated_at') {
                    $query = $query->orderBy('updated_at', 'desc');
                }
            });
        }


        return $query;
    }

    public static function createTheme(array $attributes = [])
    {
        $theme = self::createModel($attributes);

        return $theme;
    }

    public static function getThemes($parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['per_page'])) {
            $query = $query->paginate((int) $parameters['per_page'])->appends($parameters);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public static function updateThemeById(array $attributes = [], int $id)
    {
        // 1. Model, update
        $theme = self::updateModelById($attributes, $id);

        return $theme;
    }
}
