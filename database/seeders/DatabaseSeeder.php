<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PositionSeeder;
use Database\Seeders\CommunitySeeder;
use Database\Seeders\LeadershipSeeder;
use Database\Seeders\SectorSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);

        $this->call([
            PositionSeeder::class,
            SectorSeeder::class,
            CommunitySeeder::class,
            LeadershipSeeder::class,
        ]);
    }
}
