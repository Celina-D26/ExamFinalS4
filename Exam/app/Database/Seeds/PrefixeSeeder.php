<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PrefixeSeeder extends Seeder
{
    public function run()
    {
        // Vider la table
        $this->db->table('prefixes')->truncate();
        
        $prefixes = [
            [
                'prefixe' => '032',
                'operateur' => 'Orange',
                'pays' => 'Madagascar',
                'commission' => 2.5,
                'est_actif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'prefixe' => '033',
                'operateur' => 'Telma',
                'pays' => 'Madagascar',
                'commission' => 1.5,
                'est_actif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'prefixe' => '034',
                'operateur' => 'Orange',
                'pays' => 'Madagascar',
                'commission' => 2.5,
                'est_actif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'prefixe' => '036',
                'operateur' => 'Telma',
                'pays' => 'Madagascar',
                'commission' => 1.5,
                'est_actif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'prefixe' => '038',
                'operateur' => 'Airtel',
                'pays' => 'Madagascar',
                'commission' => 2.0,
                'est_actif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'prefixe' => '039',
                'operateur' => 'Airtel',
                'pays' => 'Madagascar',
                'commission' => 2.0,
                'est_actif' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($prefixes as $p) {
            $this->db->table('prefixes')->insert($p);
        }
        
        echo "✅ " . count($prefixes) . " préfixes créés avec succès !\n";
        
        // Vérification
        $count = $this->db->table('prefixes')->countAll();
        echo "📊 Total préfixes: " . $count . "\n";
    }
}