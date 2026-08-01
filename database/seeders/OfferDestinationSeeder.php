<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferDestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [

            'Missão na Metrópole',

            'Fundo para o Trabalho com Música e Liturgia',

            'Consulte sua Comunidade / Paróquia',

            'Comunidades Criativas',

            'Fundo para implementação de Capelanias de Saúde',

            'Juventude Evangélica',

            'Programa de Acompanhamento a Ministras e Ministros',

            'OASE e Trabalho com Mulheres',

            'Fundo para o Trabalho Diaconal',

            'Conferências Ministeriais',

            'Vocação e sustentabilidade da ADL – Associação Diacônica Luterana',

            'Assembleia Sinodal',

            'Fundo de Financiamento e Auxílio para Formação Teológica – FFAFT',

            'Apoio à Missão entre e com Povos Indígenas',

            'Casa Matriz de Diaconisas: Vocação, acolhimento, cuidado',

            'Sempre oferta local (CI 2010)',

            'Fundo de Missão no País – P. Homero Severo Pinto',

            'Missão no Sínodo da Amazônia',

            'Missão no Sínodo Brasil Central',

            'Fundo para o Trabalho com Jovens',

            'Trabalho de Inclusão e Acessibilidade – Pessoas com deficiência',

            'Missão no Sínodo Mato Grosso',

            'Missão com Literatura Evangelística',

            'Trabalho com Mulheres e Coordenação de Gênero',

            'Programa de Acompanhamento a Candidatas e Candidatos ao Ministério com Ordenação',

            'Rede de Diaconia',

            'Fundo para Educação Cristã Contínua',

            'Apoio a Comunidades Necessitadas e Novas – OGA',

            'Fundo para Divulgação da Bíblia e Publicações',

            'Fundo de Missão no Exterior / Promoção do Ecumenismo',

            'Programa de Acompanhamento a Estudantes de Teologia da IECLB',
        ];


        foreach ($destinations as $destination) {

            DB::table('offer_destinations')->insert([
                'name' => $destination,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}