<?php

namespace Modules\User\Models;

class User extends \App\User
{
    use \Spatie\Permission\Traits\HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_code',
    ];

    protected $guard_name = 'web';

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

    public function getRoleNameAttribute()
    {
        $roleName = $this->roles->pluck('name', 'name')->toArray();
        $roleName = old('role_name') ? old('role_name') : $roleName;
        return $roleName;
    }

    public function roles()
    {
        return $this->belongsToMany(\Modules\Role\Models\Role::class, 'model_has_roles', 'model_id', 'role_id')
            ->where('model_type', 'Modules\User\Models\User');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }
}
