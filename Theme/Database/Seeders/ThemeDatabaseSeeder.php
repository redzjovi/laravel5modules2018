<?php

namespace Modules\Theme\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Theme\Models\Theme;

class ThemeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $themes = [
            [
                'group' => 'laravel5skeleton2018',
                'section' => 'backend__menu',
                'type' => 'menu',
            ],
            [
                'group' => 'liputan6',
                'section' => 'left_menu',
                'type' => 'menu',
            ],
            [
                'group' => 'liputan6',
                'section' => 'left_menu__category',
                'type' => 'menu',
            ],
        ];

        foreach ($themes as $theme) {
            $exist = Theme::where('group', $theme['group'])->where('section', $theme['section'])->exists();

            if (! $exist) {
                Theme::createModel($theme);
            }
        }
    }
}
