<?php

namespace Modules\Cms\Traits;

trait ModelTrait
{
    /**
     * @param array $attributes
     * @return object $model
     */
    public static function createModel(array $attributes = [])
    {
        $model = new self;
        $model->fill($attributes)->save();
        return $model;
    }

    /**
     * @param int $id
     * @return int count
     */
    public static function deleteModel(int $id)
    {
        return self::destroy($id);
    }

    /**
     * @param int $id
     * @param array $columns
     * @return object
     */
    public static function findModel(int $id, array $columns = ['*'])
    {
        return self::find($id, $columns);
    }

    /**
     * @param int $id
     * @param array $columns
     * @return object
     */
    public static function findOrFailModel(int $id, array $columns = ['*'])
    {
        return self::findOrFail($id, $columns);
    }

    /**
     * @param string $field
     * @param [type] $value [description]
     * @return object
     */
    public static function findModelByField(string $field, $value)
    {
        return self::where($field, $value)->first();
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return object $model
     */
    public static function updateModelById(array $attributes, int $id)
    {
        $model = self::find($id);
        $model->fill($attributes)->save();
        return $model;
    }
}
