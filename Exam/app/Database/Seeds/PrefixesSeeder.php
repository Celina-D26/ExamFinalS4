<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PrefixesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['prefixe' => '033'],
            ['prefixe' => '037'],
            ['prefixe' => '034'],
            ['prefixe' => '038'],
            ['prefixe' => '032'],
        ];

        // Insère les données dans la table 'prefixes'
        $this->db->table('prefixes')->insertBatch($data);
    }
}