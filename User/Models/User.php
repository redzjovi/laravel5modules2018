<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use \Modules\Cms\Traits\SortableTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $sortable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    protected $table = 'users';

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }
}
