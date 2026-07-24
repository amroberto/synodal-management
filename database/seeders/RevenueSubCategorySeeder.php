<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RevenueSubCategory;

class RevenueSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [

            // 1 - Contribuições dos Membros
            [
                'revenue_category_id' => 1,
                'name' => 'Contribuições recebidas no mês',
                'description' => null,
                'active' => true,
            ],

            // 2 - Ofertas / Coletas
            [
                'revenue_category_id' => 2,
                'name' => 'Ofertas destinadas à Com./Paróq.',
                'description' => null,
                'active' => true,
            ],

            // 3 - Doações
            [
                'revenue_category_id' => 3,
                'name' => 'Doações por Ofícios',
                'description' => null,
                'active' => true,
            ],

            [
                'revenue_category_id' => 3,
                'name' => 'Doações espontâneas',
                'description' => null,
                'active' => true,
            ],

            // 4 - Promoções
            [
                'revenue_category_id' => 4,
                'name' => 'Almoços, jantares, ...',
                'description' => null,
                'active' => true,
            ],

            [
                'revenue_category_id' => 4,
                'name' => 'Festas',
                'description' => null,
                'active' => true,
            ],

            [
                'revenue_category_id' => 4,
                'name' => 'Rifas',
                'description' => null,
                'active' => true,
            ],

            [
                'revenue_category_id' => 4,
                'name' => 'Bazar',
                'description' => null,
                'active' => true,
            ],

            // 5 - Rendas Patrimoniais
            [
                'revenue_category_id' => 5,
                'name' => 'Aluguéis',
                'description' => null,
                'active' => true,
            ],

            [
                'revenue_category_id' => 5,
                'name' => 'Arrendamentos',
                'description' => null,
                'active' => true,
            ],

            // 6 - Outras Receitas
            [
                'revenue_category_id' => 6,
                'name' => 'Receitas financeiras',
                'description' => null,
                'active' => true,
            ],
        ];

        foreach ($subCategories as $subCategory) {
            RevenueSubCategory::updateOrCreate(
                [
                    'revenue_category_id' => $subCategory['revenue_category_id'],
                    'name' => $subCategory['name'],
                ],
                $subCategory
            );
        }
    }
}
