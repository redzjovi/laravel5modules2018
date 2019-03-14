<?php

namespace Modules\User\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends \Illuminate\Foundation\Auth\User implements JWTSubject
{
    use \Illuminate\Notifications\Notifiable;
    use \Modules\Cms\Traits\ModelTrait;
    use \Modules\Cms\Traits\SortableTrait;
    use \Modules\User\Traits\UserTrait;
    use \Spatie\Permission\Traits\HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_code',
    ];

    protected $sortable = [
        'id',
        'name',
        'email',
        'password',
        'verification_code',

        'created_at',
        'updated_at',
    ];

    protected $table = 'users';

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getRoleNameAttribute()
    {
        $roleName = $this->roles->pluck('name', 'name')->toArray();
        $roleName = old('role_name') ? old('role_name') : $roleName;
        return $roleName;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }
}
