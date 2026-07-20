<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OperateurSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('operateurs')->truncate();
        
        $operateurs = [
            [
                'nom' => 'Opérateur Principal',
                'prefixes' => json_encode(['033', '037']),
                'commission_pourcentage' => 0,
                'is_other' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nom' => 'Orange Money',
                'prefixes' => json_encode(['032', '034']),
                'commission_pourcentage' => 1.5,
                'is_other' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nom' => 'Airtel Money',
                'prefixes' => json_encode(['031', '038']),
                'commission_pourcentage' => 1.2,
                'is_other' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nom' => 'Telma Money',
                'prefixes' => json_encode(['036', '039']),
                'commission_pourcentage' => 1.0,
                'is_other' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($operateurs as $op) {
            $this->db->table('operateurs')->insert($op);
        }
        
        echo "✅ " . count($operateurs) . " opérateurs créés avec succès !\n";
    }
}