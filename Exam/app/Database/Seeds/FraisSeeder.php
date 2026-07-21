<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FraisSeeder extends Seeder
{
    public function run()
    {
        // Vider la table
        $this->db->table('frais_baremes')->truncate();
        
        $frais = [
            // Frais de retrait
            ['type_operation' => 'retrait', 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50],
            ['type_operation' => 'retrait', 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 75],
            ['type_operation' => 'retrait', 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100],
            ['type_operation' => 'retrait', 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 150],
            ['type_operation' => 'retrait', 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 200],
            ['type_operation' => 'retrait', 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 300],
            ['type_operation' => 'retrait', 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 500],
            ['type_operation' => 'retrait', 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 800],
            ['type_operation' => 'retrait', 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 1200],
            ['type_operation' => 'retrait', 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 2000],
            
            // Frais de transfert
            ['type_operation' => 'transfert', 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 25],
            ['type_operation' => 'transfert', 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50],
            ['type_operation' => 'transfert', 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 75],
            ['type_operation' => 'transfert', 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 100],
            ['type_operation' => 'transfert', 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 150],
            ['type_operation' => 'transfert', 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 200],
            ['type_operation' => 'transfert', 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 300],
            ['type_operation' => 'transfert', 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 500],
            ['type_operation' => 'transfert', 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 800],
            ['type_operation' => 'transfert', 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 1200],
        ];

        foreach ($frais as $f) {
            $f['created_at'] = date('Y-m-d H:i:s');
            $f['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('frais_baremes')->insert($f);
        }
        
        echo "✅ " . count($frais) . " barèmes de frais créés avec succès !\n";
        
        // Vérification
        $count = $this->db->table('frais_baremes')->countAll();
        echo "📊 Total barèmes: " . $count . "\n";
    }
}