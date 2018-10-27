<?php

namespace Modules\Permission\Repositories;

use Modules\Permission\Models\Permission;
use Modules\Permission\Repositories\PermissionRepository;
use Modules\Permission\Repositories\Contracts\PermissionCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class PermissionRepositoryEloquent.
 *
 * @package namespace Modules\PermissionRepositories;
 */
class PermissionRepositoryEloquent extends BaseRepository implements CacheableInterface, PermissionRepository
{
    use CacheableRepository;

    protected $fieldSearchable = [
        'name' => 'like',
        'guard_name' => 'like',
    ];

    public function getModel()
    {
        return new Permission;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //
    }
}
