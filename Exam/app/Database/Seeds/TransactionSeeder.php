<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Vider la table
        $this->db->table('transactions')->truncate();
        
        $transactions = [
            [
                'client_id' => 'CLT0001',
                'type_operation' => 'depot',
                'montant' => 50000,
                'frais_appliques' => 0,
                'commission_inter_operateur' => 0,
                'montant_net' => 50000,
                'solde_apres' => 150000,
                'reference' => 'TXN' . date('Ymd') . '000001',
                'description' => 'Dépôt initial',
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'client_id' => 'CLT0001',
                'type_operation' => 'retrait',
                'montant' => 20000,
                'frais_appliques' => 100,
                'commission_inter_operateur' => 0,
                'montant_net' => -20100,
                'solde_apres' => 129900,
                'reference' => 'TXN' . date('Ymd') . '000002',
                'description' => 'Retrait automatique',
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'client_id' => 'CLT0001',
                'type_operation' => 'transfert',
                'montant' => 10000,
                'frais_appliques' => 50,
                'commission_inter_operateur' => 0,
                'montant_net' => -10050,
                'solde_apres' => 119850,
                'reference' => 'TXN' . date('Ymd') . '000003',
                'description' => 'Transfert vers 340000002',
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 days'))
            ],
            [
                'client_id' => 'CLT0002',
                'type_operation' => 'depot',
                'montant' => 30000,
                'frais_appliques' => 0,
                'commission_inter_operateur' => 0,
                'montant_net' => 30000,
                'solde_apres' => 75000,
                'reference' => 'TXN' . date('Ymd') . '000004',
                'description' => 'Dépôt initial',
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 days'))
            ],
            [
                'client_id' => 'CLT0002',
                'type_operation' => 'retrait',
                'montant' => 15000,
                'frais_appliques' => 75,
                'commission_inter_operateur' => 0,
                'montant_net' => -15075,
                'solde_apres' => 59925,
                'reference' => 'TXN' . date('Ymd') . '000005',
                'description' => 'Retrait automatique',
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'client_id' => 'CLT0003',
                'type_operation' => 'depot',
                'montant' => 100000,
                'frais_appliques' => 0,
                'commission_inter_operateur' => 0,
                'montant_net' => 100000,
                'solde_apres' => 250000,
                'reference' => 'TXN' . date('Ymd') . '000006',
                'description' => 'Dépôt initial',
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 days'))
            ],
            [
                'client_id' => 'CLT0004',
                'type_operation' => 'depot',
                'montant' => 50000,
                'frais_appliques' => 0,
                'commission_inter_operateur' => 0,
                'montant_net' => 50000,
                'solde_apres' => 120000,
                'reference' => 'TXN' . date('Ymd') . '000007',
                'description' => 'Dépôt initial',
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'client_id' => 'CLT0005',
                'type_operation' => 'depot',
                'montant' => 60000,
                'frais_appliques' => 0,
                'commission_inter_operateur' => 0,
                'montant_net' => 60000,
                'solde_apres' => 180000,
                'reference' => 'TXN' . date('Ymd') . '000008',
                'description' => 'Dépôt initial',
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
        ];

        foreach ($transactions as $tx) {
            $this->db->table('transactions')->insert($tx);
        }
        
        echo "✅ " . count($transactions) . " transactions créées avec succès !\n";
        
        // Vérification
        $count = $this->db->table('transactions')->countAll();
        echo "📊 Total transactions: " . $count . "\n";
    }
}