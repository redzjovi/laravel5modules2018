<?php

namespace Modules\Role\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class RoleCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('name', 'like', '%'.request()->query('name').'%');
        $model = $model->where('guard_name', 'like', '%'.request()->query('guard_name').'%');

        return $model;
    }
}
