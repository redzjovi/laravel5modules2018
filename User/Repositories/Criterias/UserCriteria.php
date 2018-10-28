<?php

namespace Modules\User\Repositories\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class UserCriteria implements CriteriaInterface
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (isset($this->user['name'])) { $model = $model->where('name', 'like', '%'.$this->user['name'].'%'); }
        if (isset($this->user['email'])) { $model = $model->where('email', 'like', '%'.$this->user['email'].'%'); }

        if (isset($this->user['role_id'])) {
            $roleId = $this->user['role_id'];
            $model = $model->whereHas('roles', function ($roles) use ($roleId) {
                if (is_array($roleId)) {
                    $roles->whereIn('id', $roleId);
                }
            });
        }

        return $model;
    }
}
