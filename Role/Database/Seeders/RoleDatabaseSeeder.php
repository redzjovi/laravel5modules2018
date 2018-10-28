<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Permission\Models\Permission;
use Modules\Role\Models\Role;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $permissions = Permission::all();
        $roles = [
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['name' => 'Super Admin', 'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            if (! $exist = Role::where('name', $role['name'])->first()) {
                $role = Role::create($role);
                $role->permissions()->sync($permissions);
            }
        }
    }
}
