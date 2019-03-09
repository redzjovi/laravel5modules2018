<?php

namespace Modules\Cms\Traits;

trait ModelTrait
{
    /**
     * @param array $attributes
     * @return object $model
     */
    public static function create(array $attributes = [])
    {
        $model = new self;
        $model->fill($attributes)->save();
        return $model;
    }

    /**
     * @param int $id
     * @return int count
     */
    public static function deleteModelById(int $id)
    {
        return self::destroy($id);
    }

    public static function findById(int $id, array $columns = ['*'])
    {
        return self::find($id, $columns);
    }

    public static function findOrFailById(int $id, array $columns = ['*'])
    {
        return self::findOrFail($id, $columns);
    }

    public static function findByField(string $field, $value)
    {
        return self::where($field, $value)->first();
    }

    public static function updateById(array $attributes, int $id)
    {
        $model = self::find($id);
        $model->fill($attributes)->save();
        return $model;
    }
}
