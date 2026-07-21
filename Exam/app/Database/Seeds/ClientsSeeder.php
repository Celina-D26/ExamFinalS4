<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('comptes_clients')) {
            echo "❌ La table 'comptes_clients' n'existe pas !\n";
            return;
        }
        
        $db->table('comptes_clients')->truncate();
        echo "🗑️ Table 'comptes_clients' vidée\n";
        
        $data = [
            [
                'client_id' => 'CLT001',
                'nom' => 'Rakoto',
                'prenom' => 'Jean',
                'phone_number' => '321234567',
                'email' => 'jean.rakoto@email.com',
                'solde' => 150000,
                'total_depots' => 250000,
                'total_retraits' => 80000,
                'total_transferts' => 20000,
                'total_frais_payes' => 3500,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT002',
                'nom' => 'Razafy',
                'prenom' => 'Marie',
                'phone_number' => '332345678',
                'email' => 'marie.razafy@email.com',
                'solde' => 75000,
                'total_depots' => 150000,
                'total_retraits' => 50000,
                'total_transferts' => 25000,
                'total_frais_payes' => 2000,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT003',
                'nom' => 'Andrian',
                'prenom' => 'Tiana',
                'phone_number' => '343456789',
                'email' => 'tiana.andrian@email.com',
                'solde' => 250000,
                'total_depots' => 400000,
                'total_retraits' => 120000,
                'total_transferts' => 30000,
                'total_frais_payes' => 5000,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT004',
                'nom' => 'Ralaimihoatra',
                'prenom' => 'Fano',
                'phone_number' => '354567890',
                'email' => 'fano.ralaimihoatra@email.com',
                'solde' => 45000,
                'total_depots' => 80000,
                'total_retraits' => 30000,
                'total_transferts' => 5000,
                'total_frais_payes' => 1200,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT005',
                'nom' => 'Randrianarisoa',
                'prenom' => 'Lala',
                'phone_number' => '365678901',
                'email' => 'lala.randrianarisoa@email.com',
                'solde' => 120000,
                'total_depots' => 200000,
                'total_retraits' => 60000,
                'total_transferts' => 20000,
                'total_frais_payes' => 2800,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT006',
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'phone_number' => '340000001',
                'email' => 'jean.dupont@email.com',
                'solde' => 166000,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT007',
                'nom' => 'Rabe',
                'prenom' => 'Pierre',
                'phone_number' => '340000003',
                'email' => 'pierre.rabe@email.com',
                'solde' => 50000,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT008',
                'nom' => 'Rakotomalala',
                'prenom' => 'Fidy',
                'phone_number' => '340000004',
                'email' => 'fidy.rakotomalala@email.com',
                'solde' => 30000,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT009',
                'nom' => 'Rasoa',
                'prenom' => 'Mamy',
                'phone_number' => '340000005',
                'email' => 'mamy.rasoa@email.com',
                'solde' => 50000,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT010',
                'nom' => 'Randria',
                'prenom' => 'Tovo',
                'phone_number' => '340000006',
                'email' => 'tovo.randria@email.com',
                'solde' => 60000,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0,
                'status' => 'actif'
            ],
        ];

        try {
            $this->db->table('comptes_clients')->insertBatch($data);
            echo "✅ " . count($data) . " clients insérés avec succès !\n";
            
            $count = $this->db->table('comptes_clients')->countAll();
            echo "📊 Total clients : " . $count . "\n";
            
        } catch (\Exception $e) {
            echo "❌ Erreur : " . $e->getMessage() . "\n";
        }
    }
}