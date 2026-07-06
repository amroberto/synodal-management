<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leadership;
use App\Models\Community;
use App\Enums\GenderEnum;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Helpers\BrazilianFormatter;

class LeadershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        // Busca IDs reais de comunidades (se não existir nenhuma, cria algumas básicas)
        $communityIds = Community::pluck('id')->toArray();

        if (empty($communityIds)) {
            // Cria 5 comunidades básicas se não existir nenhuma
            $communityIds = [];
            for ($i = 1; $i <= 5; $i++) {
                $community = Community::create([
                    'corporate_name' => "Comunidade Teste $i",
                    'fantasy_name'   => "Comunidade $i",
                    'cnpj'           => $faker->cnpj(false),
                    'cep'            => $faker->postcode,
                    'street'         => $faker->streetName,
                    'number'         => $faker->buildingNumber,
                    'city'           => $faker->city,
                    'state'          => $faker->stateAbbr,
                ]);
                $communityIds[] = $community->id;
            }
        }

        // Gera 200 lideranças
        for ($i = 0; $i < 200; $i++) {
            $gender = $faker->randomElement(GenderEnum::values()); // 'Male', 'Female', 'Other'
            $isActive = $faker->boolean(90); // 90% chance de estar ativo

            Leadership::create([
                'name'          => $faker->name(),
                'cpf'           => $faker->cpf(false), // sem pontos e traço (11 dígitos)
                'rg'            => $faker->rg(false),
                'community_id'  => $faker->randomElement($communityIds),
                'gender'        => $gender,
                'birthdate'     => $faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
                'cep'           => str_replace('-', '', $faker->postcode), // 8 dígitos limpos
                'street'        => $faker->streetName,
                'number'        => $faker->buildingNumber,
                'complement'    => $faker->optional(0.4)->secondaryAddress,
                'neighborhood'  => $faker->streetSuffix,
                'city'          => $faker->city,
                'state'         => $faker->stateAbbr,
                'phone'         => $this->generateFormattedPhone($faker),
                'mobile'        => $this->generateFormattedMobile($faker),
                'business_phone'=> $faker->boolean(30) ? $this->generateFormattedPhone($faker) : null,
                'email'         => $faker->unique()->safeEmail,
                'is_active'     => $isActive,
            ]);
        }

        $this->command->info('200 lideranças criadas com sucesso!');
    }

    /**
     * Gera telefone fixo brasileiro com DDD
     */
    private function generateFormattedPhone($faker)
    {
        // Lista de DDDs comuns (SP, RJ, MG, RS, PR, etc.)
        $ddds = ['11', '12', '13', '14', '15', '16', '17', '18', '19', '21', '22', '24', '27', '31', '32', '33', '34', '35', '37', '38', '41', '42', '43', '44', '45', '47', '48', '51', '53', '54', '55', '61', '62', '63', '64', '65', '66', '67', '68', '69', '71', '73', '74', '75', '77', '79', '81', '82', '83', '84', '85', '86', '87', '88', '89', '91', '92', '93', '94', '95', '96', '97', '98', '99'];

        $ddd = $faker->randomElement($ddds);
        $numero = $faker->numerify('####-####'); // 8 dígitos
        $numeroLimpo = $ddd . str_replace('-', '', $numero); // ex: 1124567899

        return BrazilianFormatter::formatPhone($numeroLimpo);
    }

    /**
     * Gera celular brasileiro com DDD + 9
     */
    private function generateFormattedMobile($faker)
    {
        $ddds = ['11', '12', '13', '14', '15', '16', '17', '18', '19', '21', '22', '24', '27', '31', '32', '33', '34', '35', '37', '38', '41', '42', '43', '44', '45', '47', '48', '51', '53', '54', '55', '61', '62', '63', '64', '65', '66', '67', '68', '69', '71', '73', '74', '75', '77', '79', '81', '82', '83', '84', '85', '86', '87', '88', '89', '91', '92', '93', '94', '95', '96', '97', '98', '99'];

        $ddd = $faker->randomElement($ddds);
        $numero = $faker->numerify('####-####'); // 9 dígitos
        $numeroLimpo = $ddd . '9' . str_replace('-', '', $numero); // ex: 11981814522

        return BrazilianFormatter::formatMobile($numeroLimpo);
    }
}
