<?php

namespace Modules\User\Repositories;

use Modules\User\Models\User;

class UserRepository extends User
{
    use \Modules\Cms\Traits\ModelRepositoryTrait;
    use \Modules\Cms\Traits\SortableTrait;

    public function scopeSearch($query, $parameters)
    {
        if (isset($parameters['name'])) {
            $query = $query->where('name', 'like', '%'.$parameters['name'].'%');
        }

        if (isset($parameters['email'])) {
            $query = $query->where('email', 'like', '%'.$parameters['email'].'%');
        }

        if (isset($parameters['role_id'])) {
            $roleId = $parameters['role_id'];
            $query = $query->whereHas('roles', function ($roles) use ($roleId) {
                if (is_array($roleId)) {
                    $roles->whereIn('id', $roleId);
                }
            });
        }

        if (isset($parameters['orderBy']) && isset($parameters['sortedBy'])) {
            $orderBys = explode(',', $parameters['orderBy']);
            $sortedBys = explode(',', $parameters['sortedBy']);

            foreach ($orderBys as $i => $orderBy) {
                $query = $query->orderBy($orderBy, $sortedBys[$i]);
            }
        }

        if (isset($parameters['with'])) {
            $query = $query->with($parameters['with']);
        }

        return $query;
    }

    public static function getUserByEmailAndPasswordAndVerificationCode(string $email, string $password, int $verificationCode)
    {
        return self::where('email', $email)
            ->where('password', $password)
            ->where('verification_code', $verificationCode)
            ->first();
    }

    public static function getUserByEmailAndVerificationCode(string $email, int $verificationCode)
    {
        return self::where('email', $email)
            ->where('verification_code', $verificationCode)
            ->first();
    }

    public static function getUsers($parameters)
    {
        $query = self::query()->search($parameters);

        if (isset($parameters['paginate']) && $parameters['paginate'] == 1) {
            $users = $query->paginate();
        } else {
            $users = $query->get();
        }

        return $users;
    }

    public static function updatePasswordAndVerificationCodeById(string $password, int $id)
    {
        $attributes['password'] = $password;
        $attributes['verification_code'] = rand(111111, 999999);
        return self::updateById($attributes, $id);
    }

    public static function updateVerificationCodeById(int $id)
    {
        $attributes['verification_code'] = rand(111111, 999999);
        return self::updateById($attributes, $id);
    }
}
