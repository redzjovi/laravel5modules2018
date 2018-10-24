<?php

namespace Modules\User\Repositories;

use Modules\User\Models\User;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\Contracts\UserCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace Modules\UserRepositories;
 */
class UserRepositoryEloquent extends BaseRepository implements CacheableInterface, UserRepository
{
    use CacheableRepository;

    protected $fieldSearchable = [
        'name' => 'like',
        'email' => 'like',
    ];

    public function getModel()
    {
        return new User;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //
    }
}
