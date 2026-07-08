<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\PositionSeeder;
use Database\Seeders\CommunitySeeder;
use Database\Seeders\LeadershipSeeder;
use Database\Seeders\SectorSeeder;
use Database\Seeders\AccountPlanSeeder;
use Database\Seeders\RevenueCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            PositionSeeder::class,
            SectorSeeder::class,
            CommunitySeeder::class,
            LeadershipSeeder::class,
            RevenueCategorySeeder::class,
            AccountPlanSeeder::class,
        ]);
    }
}