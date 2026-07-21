<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('comptes_clients')->truncate();
        
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
                'status' => 'actif'
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
                'status' => 'actif'
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
                'status' => 'actif'
            ],
        ];

        foreach ($clients as $client) {
            $client['created_at'] = date('Y-m-d H:i:s');
            $client['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('comptes_clients')->insert($client);
        }
        
        echo "✅ " . count($clients) . " clients créés avec succès !\n";
    }
}