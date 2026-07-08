<?php

namespace Database\Seeders;

use App\Models\AccountPlan;
use App\Traits\ImportsCsv;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountPlanSeeder extends Seeder
{
    use ImportsCsv;

    public function run(): void
    {
        $path = database_path('data/account_plans.csv');

        $rows = $this->importCsv($path);

        AccountPlan::truncate();

        foreach ($rows as $row) {

            AccountPlan::create([
                'code'        => $row['code'],
                'description' => $row['description'],
                'level'       => (int) $row['level'],
                'parent_code' => $row['parent_code'] ?: null,
                'active'      => true,
            ]);
        }

        $this->command->info('Plano de contas importado com sucesso!');
    }
}