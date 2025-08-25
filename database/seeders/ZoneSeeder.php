<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'ville' => 'Abidjan',
                'pays' => "Côte d’Ivoire",
                'techniciens' => 12,
                'delai_moyen' => '≤ 4h',
            ],
            [
                'ville' => 'Yamoussoukro',
                'pays' => "Côte d’Ivoire",
                'techniciens' => 5,
                'delai_moyen' => '≤ 8h',
            ],
            [
                'ville' => 'Lomé',
                'pays' => "Togo",
                'techniciens' => 6,
                'delai_moyen' => '≤ 8h',
            ],
            [
                'ville' => 'Cotonou',
                'pays' => "Bénin",
                'techniciens' => 4,
                'delai_moyen' => '≤ 12h',
            ],
        ];

        foreach ($zones as $zone) {
            Zone::create($zone);
        }
    }
}
