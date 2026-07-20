<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PrefixesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['prefix' => '032', 'operateur' => 'Telma', 'pays' => 'Madagascar', 'commission' => 2.5],
            ['prefix' => '033', 'operateur' => 'Orange', 'pays' => 'Madagascar', 'commission' => 3.0],
            ['prefix' => '034', 'operateur' => 'Airtel', 'pays' => 'Madagascar', 'commission' => 2.0],
            ['prefix' => '038', 'operateur' => 'Airtel', 'pays' => 'Madagascar', 'commission' => 2.0],
            ['prefix' => '039', 'operateur' => 'Orange', 'pays' => 'Madagascar', 'commission' => 3.0],
            ['prefix' => '031', 'operateur' => 'Telma', 'pays' => 'Madagascar', 'commission' => 2.5],
            ['prefix' => '041', 'operateur' => 'Orange', 'pays' => 'France', 'commission' => 5.0],
            ['prefix' => '077', 'operateur' => 'Orange', 'pays' => 'Côte d\'Ivoire', 'commission' => 4.0],
        ];

        $this->db->table('prefixes')->insertBatch($data);
        echo "✅ " . count($data) . " préfixes insérés avec succès !\n";
    }
}