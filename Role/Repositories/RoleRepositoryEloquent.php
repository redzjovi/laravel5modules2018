<?php

namespace Modules\Role\Repositories;

use Modules\Role\Models\Role;
use Modules\Role\Repositories\RoleRepository;
use Modules\Role\Repositories\Contracts\RoleCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace Modules\RoleRepositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements CacheableInterface, RoleRepository
{
    use CacheableRepository;

    protected $fieldSearchable = [
        'name' => 'like',
        'guard_name' => 'like',
    ];

    public function getModel()
    {
        return new Role;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //
    }
}
