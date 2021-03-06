<?php

namespace Modules\Permission\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    use \Modules\Cms\Traits\ModelTrait;
    use \Modules\Cms\Traits\SortableTrait;
    use \Modules\Permission\Traits\PermissionTrait;

    protected $fillable = [
        'name',
    ];

    protected $sortable = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $table = 'permissions';

    public function getGuardNameOptions()
    {
        return [
            'api' => trans('cms::cms.api'),
            'web' => trans('cms::cms.web'),
        ];
    }
}
