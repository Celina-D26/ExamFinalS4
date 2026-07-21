<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FraisBaremeSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('frais_baremes')) {
            echo "❌ La table 'frais_baremes' n'existe pas !\n";
            return;
        }
        
        $db->table('frais_baremes')->truncate();
        echo "🗑️ Table 'frais_baremes' vidée\n";
        
        $data = [
            // Retraits
            ['type_operation' => 'retrait', 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 200, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 400, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 800, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 1500, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 1500, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 2500, 'commission_inter_operateur' => 0],
            ['type_operation' => 'retrait', 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000, 'commission_inter_operateur' => 0],
            // Transferts
            ['type_operation' => 'transfert', 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50, 'commission_inter_operateur' => 2.5],
            ['type_operation' => 'transfert', 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50, 'commission_inter_operateur' => 2.5],
            ['type_operation' => 'transfert', 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100, 'commission_inter_operateur' => 3.0],
            ['type_operation' => 'transfert', 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 200, 'commission_inter_operateur' => 3.0],
            ['type_operation' => 'transfert', 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 400, 'commission_inter_operateur' => 4.0],
            ['type_operation' => 'transfert', 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 800, 'commission_inter_operateur' => 4.0],
            ['type_operation' => 'transfert', 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 1500, 'commission_inter_operateur' => 5.0],
            ['type_operation' => 'transfert', 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 1500, 'commission_inter_operateur' => 5.0],
            ['type_operation' => 'transfert', 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 2500, 'commission_inter_operateur' => 5.0],
            ['type_operation' => 'transfert', 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000, 'commission_inter_operateur' => 5.0],
        ];

        try {
            $this->db->table('frais_baremes')->insertBatch($data);
            echo "✅ " . count($data) . " barèmes de frais insérés avec succès !\n";
            
            $count = $this->db->table('frais_baremes')->countAll();
            echo "📊 Total barèmes : " . $count . "\n";
            
        } catch (\Exception $e) {
            echo "❌ Erreur : " . $e->getMessage() . "\n";
        }
    }
}