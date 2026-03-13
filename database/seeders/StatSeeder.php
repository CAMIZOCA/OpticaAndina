<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;

class StatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stats = [
            [
                'label' => 'Exámenes Visuales Realizados',
                'value' => '6,520',
                'icon' => 'fas fa-eye',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'label' => 'Pacientes Satisfechos',
                'value' => '2,310',
                'icon' => 'fas fa-users',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'label' => 'Especialistas Certificados',
                'value' => '25',
                'icon' => 'fas fa-user-md',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'label' => 'Años de Experiencia',
                'value' => '15+',
                'icon' => 'fas fa-award',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            Stat::firstOrCreate(['label' => $stat['label']], $stat);
        }
    }
}
