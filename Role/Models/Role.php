<?php

namespace Modules\Role\Models;

class Role extends \Spatie\Permission\Models\Role
{
    use \Modules\Cms\Traits\SortableTrait;
    use \Modules\Role\Traits\RoleTrait;

    protected $fillable = [
        'name',
    ];

    protected $sortable = [
        'id',
        'name',
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
