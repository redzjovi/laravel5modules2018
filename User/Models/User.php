<?php

namespace Modules\User\Models;

class User extends \Illuminate\Foundation\Auth\User
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

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }
}
