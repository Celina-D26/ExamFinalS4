<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Vérifier si la table existe
        if (!$db->tableExists('comptes_clients')) {
            echo "❌ La table 'comptes_clients' n'existe pas !\n";
            echo "Exécutez d'abord : php spark migrate\n";
            return;
        }
        
        // Vider la table
        $db->table('comptes_clients')->truncate();
        echo "🗑️ Table 'comptes_clients' vidée\n";
        
        $data = [
            [
                'client_id' => 'CLT001',
                'nom' => 'Rakoto',
                'prenom' => 'Jean',
                'phone_number' => '+261321234567',
                'email' => 'jean.rakoto@email.com',
                'solde' => 150000.00,
                'total_depots' => 250000.00,
                'total_retraits' => 80000.00,
                'total_transferts' => 20000.00,
                'total_frais_payes' => 3500.00,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT002',
                'nom' => 'Razafy',
                'prenom' => 'Marie',
                'phone_number' => '+261332345678',
                'email' => 'marie.razafy@email.com',
                'solde' => 75000.00,
                'total_depots' => 150000.00,
                'total_retraits' => 50000.00,
                'total_transferts' => 25000.00,
                'total_frais_payes' => 2000.00,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT003',
                'nom' => 'Andrian',
                'prenom' => 'Tiana',
                'phone_number' => '+261343456789',
                'email' => 'tiana.andrian@email.com',
                'solde' => 250000.00,
                'total_depots' => 400000.00,
                'total_retraits' => 120000.00,
                'total_transferts' => 30000.00,
                'total_frais_payes' => 5000.00,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT004',
                'nom' => 'Ralaimihoatra',
                'prenom' => 'Fano',
                'phone_number' => '+261354567890',
                'email' => 'fano.ralaimihoatra@email.com',
                'solde' => 45000.00,
                'total_depots' => 80000.00,
                'total_retraits' => 30000.00,
                'total_transferts' => 5000.00,
                'total_frais_payes' => 1200.00,
                'status' => 'actif'
            ],
            [
                'client_id' => 'CLT005',
                'nom' => 'Randrianarisoa',
                'prenom' => 'Lala',
                'phone_number' => '+261365678901',
                'email' => 'lala.randrianarisoa@email.com',
                'solde' => 120000.00,
                'total_depots' => 200000.00,
                'total_retraits' => 60000.00,
                'total_transferts' => 20000.00,
                'total_frais_payes' => 2800.00,
                'status' => 'actif'
            ],
        ];

        try {
            $this->db->table('comptes_clients')->insertBatch($data);
            echo "✅ " . count($data) . " clients insérés avec succès !\n";
            
            // Vérifier l'insertion
            $count = $this->db->table('comptes_clients')->countAll();
            echo "📊 Total clients dans la base : " . $count . "\n";
            
        } catch (\Exception $e) {
            echo "❌ Erreur lors de l'insertion : " . $e->getMessage() . "\n";
        }
    }
}