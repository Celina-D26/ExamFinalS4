<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OperationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'type_operation' => 'retrait',
                'montant' => 50000,
                'frais_appliques' => 1000,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'type_operation' => 'transfert',
                'montant' => 100000,
                'frais_appliques' => 2000,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'type_operation' => 'depot',
                'montant' => 20000,
                'frais_appliques' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('operations')->insertBatch($data);
    }
}