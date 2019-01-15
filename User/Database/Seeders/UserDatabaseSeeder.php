<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::reguard();

        $users = [
            [
                'name' => 'Admin', 'email' => 'admin@mailinator.com', 'password' => 'admin@mailinator.com',
                'roles' => 'Admin',
            ],
            [
                'name' => 'Super Admin', 'email' => 'superadmin@mailinator.com', 'password' => 'superadmin@mailinator.com',
                'roles' => 'Super Admin',
            ],
        ];

        foreach ($users as $user) {
            if (! $exist = User::getUserByEmail($user['email'])) {
                $model = User::create($user);
                $model->assignRole($user['roles']);
            }
        }
    }
}
