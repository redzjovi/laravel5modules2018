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
                'name' => 'Admin', 'email' => 'admin@mailinator.com',
                'roles' => 'Admin',
            ],
            [
                'name' => 'Super Admin', 'email' => 'superadmin@mailinator.com',
                'roles' => 'Super Admin',
            ],
        ];

        foreach ($users as $user) {
            if (! $exist = User::where('email', $user['email'])->first()) {
                $model = new User;
                $model->fill($user);
                $model->password = $user['email'];
                $model->save();

                $model->assignRole($user['roles']);
            }
        }
    }
}
