<?php

namespace Modules\User\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class UserCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('name', 'like', '%'.request()->query('name').'%');
        $model = $model->where('email', 'like', '%'.request()->query('email').'%');

        return $model;
    }
}
