<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FraisBaremeSeeder extends Seeder
{
    public function run()
    {
        // Vider la table avant d'insérer
        $this->db->table('frais_baremes')->truncate();

        $data = [
            // Retraits
            ['type_operation' => 'retrait', 'montant_min' => 100,     'montant_max' => 1000,    'frais' => 50],
            ['type_operation' => 'retrait', 'montant_min' => 1001,    'montant_max' => 5000,    'frais' => 50],
            ['type_operation' => 'retrait', 'montant_min' => 5001,    'montant_max' => 10000,   'frais' => 100],
            ['type_operation' => 'retrait', 'montant_min' => 10001,   'montant_max' => 25000,   'frais' => 200],
            ['type_operation' => 'retrait', 'montant_min' => 25001,   'montant_max' => 50000,   'frais' => 400],
            ['type_operation' => 'retrait', 'montant_min' => 50001,   'montant_max' => 100000,  'frais' => 800],
            ['type_operation' => 'retrait', 'montant_min' => 100001,  'montant_max' => 250000,  'frais' => 1500],
            ['type_operation' => 'retrait', 'montant_min' => 250001,  'montant_max' => 500000,  'frais' => 1500],
            ['type_operation' => 'retrait', 'montant_min' => 500001,  'montant_max' => 1000000, 'frais' => 2500],
            ['type_operation' => 'retrait', 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000],
            
            // Transferts (mêmes barèmes)
            ['type_operation' => 'transfert', 'montant_min' => 100,     'montant_max' => 1000,    'frais' => 50],
            ['type_operation' => 'transfert', 'montant_min' => 1001,    'montant_max' => 5000,    'frais' => 50],
            ['type_operation' => 'transfert', 'montant_min' => 5001,    'montant_max' => 10000,   'frais' => 100],
            ['type_operation' => 'transfert', 'montant_min' => 10001,   'montant_max' => 25000,   'frais' => 200],
            ['type_operation' => 'transfert', 'montant_min' => 25001,   'montant_max' => 50000,   'frais' => 400],
            ['type_operation' => 'transfert', 'montant_min' => 50001,   'montant_max' => 100000,  'frais' => 800],
            ['type_operation' => 'transfert', 'montant_min' => 100001,  'montant_max' => 250000,  'frais' => 1500],
            ['type_operation' => 'transfert', 'montant_min' => 250001,  'montant_max' => 500000,  'frais' => 1500],
            ['type_operation' => 'transfert', 'montant_min' => 500001,  'montant_max' => 1000000, 'frais' => 2500],
            ['type_operation' => 'transfert', 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000],
        ];

        $this->db->table('frais_baremes')->insertBatch($data);
        
        echo "✅ " . count($data) . " barèmes de frais insérés avec succès !\n";
    }
}