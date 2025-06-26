<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        $ListLinkCode = [
            [
                'url' => 'https://github.com/MasFana/',
                'code' => 'masfana',
                'click_count' => 696969,
            ],
            [
                'url' => 'https://www.instagram.com/ukmlaos/',
                'code' => 'lawos',
                'click_count' => 303030,
            ],
            [
                'url' => 'https://github.com/MasFana/laravel-shortlink',
                'code' => 'repoini',
                'click_count' => 141414,
            ],
        ];

        foreach ($ListLinkCode as $link) {
            \App\Models\ShortLink::create($link);
        }
        
    }
}
