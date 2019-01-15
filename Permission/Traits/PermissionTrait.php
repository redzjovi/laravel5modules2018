<?php

namespace Modules\Permission\Traits;

trait PermissionTrait
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

    public static function getPermissionByName(string $name)
    {
        return self::where('name', $name)->first();
    }

    public static function getPermissionsOrderByName()
    {
        return self::orderBy('name')->get();
    }
}
