<?php

namespace Modules\Permission\Repositories\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class PermissionCriteria implements CriteriaInterface
{
    protected $permission;

    public function __construct($permission)
    {
        $this->permission = $permission;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (isset($this->permission['name'])) { $model = $model->where('name', 'like', '%'.$this->permission['name'].'%'); }
        if (isset($this->permission['guard_name'])) { $model = $model->where('guard_name', $this->permission['guard_name']); }

        return $model;
    }
}
