<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Vider la table
        $this->db->table('comptes_clients')->truncate();
        
        // Données des clients (correspondant aux users existants)
        $clients = [
            [
                'client_id' => 'CLT0001',
                'nom' => 'Jean',
                'prenom' => 'Dupont',
                'phone_number' => '340000001',
                'email' => 'jean.dupont@example.com',
                'solde' => 150000,
                'total_depots' => 250000,
                'total_retraits' => 80000,
                'total_transferts' => 20000,
                'total_frais_payes' => 3500,
                'status' => 'actif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'client_id' => 'CLT0002',
                'nom' => 'Marie',
                'prenom' => 'Martin',
                'phone_number' => '340000002',
                'email' => 'marie.martin@example.com',
                'solde' => 75000,
                'total_depots' => 150000,
                'total_retraits' => 50000,
                'total_transferts' => 25000,
                'total_frais_payes' => 2000,
                'status' => 'actif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'client_id' => 'CLT0003',
                'nom' => 'Pierre',
                'prenom' => 'Ravel',
                'phone_number' => '340000003',
                'email' => 'pierre.ravel@example.com',
                'solde' => 250000,
                'total_depots' => 400000,
                'total_retraits' => 120000,
                'total_transferts' => 30000,
                'total_frais_payes' => 5000,
                'status' => 'actif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'client_id' => 'CLT0004',
                'nom' => 'Sophie',
                'prenom' => 'Raja',
                'phone_number' => '340000004',
                'email' => 'sophie.raja@example.com',
                'solde' => 120000,
                'total_depots' => 200000,
                'total_retraits' => 60000,
                'total_transferts' => 20000,
                'total_frais_payes' => 2800,
                'status' => 'actif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'client_id' => 'CLT0005',
                'nom' => 'David',
                'prenom' => 'Ran',
                'phone_number' => '340000005',
                'email' => 'david.ran@example.com',
                'solde' => 180000,
                'total_depots' => 300000,
                'total_retraits' => 100000,
                'total_transferts' => 20000,
                'total_frais_payes' => 4200,
                'status' => 'actif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($clients as $client) {
            $this->db->table('comptes_clients')->insert($client);
        }
        
        echo "✅ " . count($clients) . " clients créés avec succès !\n";
        
        // Vérification
        $count = $this->db->table('comptes_clients')->countAll();
        echo "📊 Total clients: " . $count . "\n";
    }
}