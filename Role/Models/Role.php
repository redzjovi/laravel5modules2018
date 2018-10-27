<?php

namespace Modules\Role\Models;

class Role extends \Spatie\Permission\Models\Role
{
    use \Modules\Cms\Traits\SortableTrait;

    protected $fillable = [
        'name',
        'guard_name',
    ];

    protected $sortable = [
        'id',
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];

    protected $table = 'roles';

    public function getGuardNameOptions()
    {
        return [
            'api' => trans('cms::cms.api'),
            'web' => trans('cms::cms.web'),
        ];
    }
}
