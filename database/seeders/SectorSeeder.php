<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            [1, 'UP São Paulo'],
            [2, 'UP Campinas'],
            [3, 'Minas Gerais'],
            [4, 'Rio de Janeiro']

        ];

        foreach ($sectors as $sector) {
            DB::table('sectors')->insert([
                'id' => $sector[0],
                'name' => $sector[1],
            ]);
        }
    }
}
