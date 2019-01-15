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

    public static function getRoles($parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['paginate']) && $parameters['paginate'] == 1) {
            $roles = $query->paginate();
        } else {
            $roles = $query->get();
        }

        return $roles;
    }

    public static function getRolesOrderByName()
    {
        return self::orderBy('name')->get();
    }
}
