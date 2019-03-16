<?php

namespace Modules\Permission\Traits;

trait PermissionTrait
{
    public function scopeSearch($query, array $parameters)
    {
        if (isset($parameters['id'])) {
            $query = $query->where('id', $parameters['id']);
        }
        if (isset($parameters['name'])) {
            $query = $query->where('name', 'like', '%'.$parameters['name'].'%');
        }


        if (isset($parameters['sort'])) {
            $sorts = explode(',', $parameters['sort']);
            collect($sorts)->map(function ($sort) use ($query) {
                if ($sort == 'name') {
                    $query = $query->orderBy('name');
                }
                if ($sort == '-name') {
                    $query = $query->orderBy('name', 'desc');
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

    public static function getPermissionByName(string $name)
    {
        return self::where('name', $name)->first();
    }

    public static function getPermissionsByParameters(array $parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['per_page'])) {
            $query = $query->paginate((int) $parameters['per_page'])->appends($parameters);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public static function getPermissionsOrderByName()
    {
        return self::orderBy('name')->get();
    }
}
