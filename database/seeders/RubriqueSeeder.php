<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rubrique;

class RubriqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rubriques = [
            [
                'titre' => 'Essentiel',
                'plage_support' => 'Jours ouvrés',
                'tti_ttr' => '4h / 48h',
                'preventif' => 'Trimestriel',
                'pieces_conso' => 'À la demande',
                'reporting' => 'Incidents',
            ],
            [
                'titre' => 'Pro',
                'plage_support' => '6j/7 – 8h-20h',
                'tti_ttr' => '4h / 24–48h',
                'preventif' => 'Bimestriel',
                'pieces_conso' => 'Stock tampon',
                'reporting' => 'Mensuel (SLA, MTBF/MTTR)',
            ],
            [
                'titre' => 'Premium 24/7',
                'plage_support' => '24/7',
                'tti_ttr' => '2h / ≤8–24h',
                'preventif' => 'Mensuel',
                'pieces_conso' => 'Stock + machine de courtoisie',
                'reporting' => 'Hebdo + mensuel',
            ],
        ];

        foreach ($rubriques as $data) {
            Rubrique::create($data);
        }
    }
}
