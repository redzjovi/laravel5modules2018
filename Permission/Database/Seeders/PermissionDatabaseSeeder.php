<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Permission\Models\Permission;

class PermissionDatabaseSeeder extends Seeder
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

        $permissions = [
            ['name' => 'modules.page.backend.v1.page.*', 'guard_name' => 'web'],
            ['name' => 'modules.permission.backend.v1.permission.*', 'guard_name' => 'web'],
            ['name' => 'modules.role.backend.v1.role.*', 'guard_name' => 'web'],
            ['name' => 'modules.role.backend.v1.role.permission.*', 'guard_name' => 'web'],
            ['name' => 'modules.user.backend.v1.user.*', 'guard_name' => 'web'],
            ['name' => 'modules.user.backend.v1.user.role.*', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            if (! $exist = Permission::getPermissionByName($permission['name'])) {
                Permission::create($permission);
            }
        }
    }
}
