<?php

namespace Modules\Role\Repositories\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class RoleCriteria implements CriteriaInterface
{
    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (isset($this->role['name'])) { $model = $model->where('name', 'like', '%'.$this->role['name'].'%'); }
        if (isset($this->role['guard_name'])) { $model = $model->where('email', $this->role['guard_name']); }

        return $model;
    }
}
