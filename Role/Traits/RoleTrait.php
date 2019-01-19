<?php

namespace Modules\Role\Traits;

trait RoleTrait
{
    public function scopeSearch($query, $parameters)
    {
        if (isset($parameters['name'])) {
            $query = $query->where('name', 'like', '%'.$parameters['name'].'%');
        }
        if (isset($parameters['guard_name'])) {
            $query = $query->where('guard_name', $parameters['guard_name']);
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
                if ($sort == 'guard_name') {
                    $query = $query->orderBy('guard_name');
                }
                if ($sort == '-guard_name') {
                    $query = $query->orderBy('guard_name', 'desc');
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

    public static function getRoles($parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['per_page'])) {
            $query = $query->paginate((int) $parameters['per_page'])->appends($parameters);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public static function getRolesOrderByName()
    {
        return self::orderBy('name')->get();
    }
}
