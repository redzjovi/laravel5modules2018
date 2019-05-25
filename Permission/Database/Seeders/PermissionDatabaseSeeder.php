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
            ['name' => 'api.v1.category.*'],
            ['name' => 'api.v1.menu.*'],
            ['name' => 'api.v1.page.*'],
            ['name' => 'api.v1.permission.*'],
            ['name' => 'api.v1.role.*'],
            ['name' => 'api.v1.role.permission.*'],
            ['name' => 'api.v1.tag.*'],
            ['name' => 'api.v1.user.*'],
            ['name' => 'api.v1.user.role.*'],
            ['name' => 'modules.category.backend.v1.category.*'],
            ['name' => 'modules.menu.backend.v1.menu.*'],
            ['name' => 'modules.page.backend.v1.page.*'],
            ['name' => 'modules.permission.backend.v1.permission.*'],
            ['name' => 'modules.role.backend.v1.role.*'],
            ['name' => 'modules.role.backend.v1.role.permission.*'],
            ['name' => 'modules.tag.backend.v1.tag.*'],
            ['name' => 'modules.user.backend.v1.user.*'],
            ['name' => 'modules.user.backend.v1.user.role.*'],
        ];

        foreach ($permissions as $permission) {
            if (! $exist = Permission::getPermissionByName($permission['name'])) {
                Permission::create($permission);
            }
        }
    }
}
