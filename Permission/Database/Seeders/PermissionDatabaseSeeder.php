<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

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
            ['name' => 'modules.permission.backend.v1.permission.*', 'guard_name' => 'web'],
            ['name' => 'modules.user.backend.v1.user.*', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            if (! $exist = Permission::where('name', $permission['name'])->first()) {
                Permission::create($permission);
            }
        }
    }
}
