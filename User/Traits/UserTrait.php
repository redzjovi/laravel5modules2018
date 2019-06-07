<?php

namespace Modules\User\Traits;

trait UserTrait
{
    public function scopeSearch($query, $parameters)
    {
        if (isset($parameters['id'])) {
            $query = $query->where('id', $parameters['id']);
        }
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


        if (isset($parameters['sort'])) {
            $sorts = explode(',', $parameters['sort']);
            collect($sorts)->map(function ($sort) use ($query) {
                if ($sort == 'name') {
                    $query = $query->orderBy('name');
                }
                if ($sort == '-name') {
                    $query = $query->orderBy('name', 'desc');
                }
                if ($sort == 'email') {
                    $query = $query->orderBy('email');
                }
                if ($sort == '-email') {
                    $query = $query->orderBy('email', 'desc');
                }
                if ($sort == 'updated_at') {
                    $query = $query->orderBy('updated_at');
                }
                if ($sort == '-updated_at') {
                    $query = $query->orderBy('updated_at', 'desc');
                }
            });
        }


        if (isset($parameters['with'])) {
            $query = $query->with($parameters['with']);
        }

        return $query;
    }

    public static function getUserByEmail(string $email)
    {
        return self::where('email', $email)->first();
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

        if (isset($parameters['per_page'])) {
            $query = $query->paginate((int) $parameters['per_page'])->appends($parameters);
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public static function updatePasswordAndVerificationCodeById(string $password, int $id)
    {
        $attributes['password'] = $password;
        $attributes['verification_code'] = rand(111111, 999999);
        return self::updateModelById($attributes, $id);
    }

    public static function createUser(array $parameters)
    {
        $user = self::createModel($parameters);

        if (isset($parameters['role_name'])) {
            if (auth()->user()->can('api.user.role.*, modules.user.backend.v1.user.role.*')) {
                $user->syncRoles($parameters['role_name']);
            }
        }

        return $user;
    }

    public static function updateUserById(array $parameters, int $id)
    {
        $user = self::updateModelById($parameters, $id);

        if (isset($parameters['role_name'])) {
            if (auth()->user()->can('modules.user.backend.v1.user.role.*')) {
                $user->syncRoles($parameters['role_name']);
            }
        }

        return $user;
    }

    public static function updateVerificationCodeById(int $id)
    {
        $attributes['verification_code'] = rand(111111, 999999);
        return self::updateModelById($attributes, $id);
    }
}
