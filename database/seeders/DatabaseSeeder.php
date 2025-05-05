<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            BadgeSeeder::class,
            TagSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CommunitySeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            PollSeeder::class,
            ReportTypeSeeder::class,
            ReportSeeder::class,
            ThreadSeeder::class,
            SavePostSeeder::class
        ]);
    }
}
