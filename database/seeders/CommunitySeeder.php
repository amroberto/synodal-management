<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $communities = [
            ['corporate_name' => 'Comunidade Morumbi', 'fantasy_name' => 'Morumbi', 'cnpj' => '12345678000199', 'unity_type' => 'community', 'cep' => '01001000', 'street' => 'Rua Exemplo', 'number' => '100', 'neighborhood' => 'Centro', 'city' => 'São Paulo', 'state' => 'SP', 'sector_id' => '1', 'phone' => '1133334444', 'mobile' => '1199998888', 'email' => 'morumbi@email.com', 'website' => 'www.exemplo1.com.br'],
            ['corporate_name' => 'Paróquia São João', 'fantasy_name' => 'São João', 'cnpj' => '98765432000188', 'unity_type' => 'parish', 'cep' => '02002000', 'street' => 'Avenida Exemplo', 'number' => '200', 'neighborhood' => 'Bairro Exemplo', 'city' => 'Rio de Janeiro', 'state' => 'RJ','sector_id' => '2', 'phone' => '2133335555', 'mobile' => '2199997777', 'email' => 'saojoao@email.com', 'website' => 'www.exemplo2.com.br'],
            ['corporate_name' => 'Comunidade Ipiranga', 'fantasy_name' => 'Ipiranga', 'cnpj' => '11223344000155', 'unity_type' => 'community', 'cep' => '03003000', 'street' => 'Travessa Exemplo', 'number' => '300', 'neighborhood' => 'Vila Exemplo', 'city' => 'Belo Horizonte', 'state' => 'MG','sector_id' => '3', 'phone' => '3133336666', 'mobile' => '3199996666', 'email' => 'ipiranga@email.com', 'website' => 'www.exemplo3.com.br'],
            ['corporate_name' => 'Comunidade Salvador', 'fantasy_name' => 'Salvador', 'cnpj' => '66778899000133', 'unity_type' => 'parish', 'cep' => '05005000', 'street' => 'Rua das Flores', 'number' => '500', 'neighborhood' => 'Vila Flores', 'city' => 'Salvador', 'state' => 'BA','sector_id' => '4', 'phone' => '7133338888', 'mobile' => '7199994444', 'email' => 'jundiai@email.com', 'website' => 'www.jundiai.com.br'],
        ];

        foreach ($communities as $community) {
            DB::table('communities')->insert(
                [
                    'corporate_name' => $community['corporate_name'],
                    'fantasy_name' => $community['fantasy_name'],
                    'cnpj' => $community['cnpj'],
                    'unity_type' => $community['unity_type'],
                    'cep' => $community['cep'],
                    'street' => $community['street'],
                    'number' => $community['number'],
                    'neighborhood' => $community['neighborhood'],
                    'city' => $community['city'],
                    'state' => $community['state'],
                    'sector_id' => $community['sector_id'],
                    'phone' => $community['phone'],
                    'mobile' => $community['mobile'],
                    'email' => $community['email'],
                    'website' => $community['website'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

    }
}
