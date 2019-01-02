<?php

namespace Modules\Cms\Traits;

trait ModelRepositoryTrait
{
    public static function create(array $attributes = [])
    {
        $model = new parent;
        $model->fill($attributes)->save();
        return $model;
    }

    public static function deleteById(int $id)
    {
        return parent::destroy($id);
    }

    public static function findById(int $id, array $columns = ['*'])
    {
        return parent::find($id, $columns);
    }

    public static function findByField(string $field, $value)
    {
        return parent::where($field, $value)->first();
    }

    public static function updateById(array $attributes, int $id)
    {
        $model = parent::find($id);
        $model->fill($attributes)->save();
        return $model;
    }
}
