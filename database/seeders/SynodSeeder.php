<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Synod;

class SynodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Synod::exists()) {
            return;
        }

        Synod::create([
            'corporate_name' => 'Sinodo Teste',
            'fantasy_name' => 'Teste',
            'cnpj' => '12345678000190',
            'phone' => '1112345678',
            'mobile' => '11912345678',
            'cep' => '01042001',
            'street' => 'Rua Principal',
            'number' => '100',
            'complement' => 'Bloco !, Cj. 123',
            'neighborhood' => 'Centro',
            'city' => 'São Paulo',
            'state' => 'SP',
            'email' => 'contato@sinodoteste.org',
            'website' => 'http://www.sinodoteste.org',
            'logo' => null,
        ]);
    }
}
