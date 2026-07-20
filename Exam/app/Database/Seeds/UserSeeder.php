<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Vider la table
        $this->db->table('users')->truncate();
        
        // Données de test
        $users = [
            [
                'username'     => 'Jean Dupont',
                'phone_number' => '340000001',
                'email'        => 'jean.dupont@example.com',
                'login_count'  => 0,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'username'     => 'Marie Martin',
                'phone_number' => '340000002',
                'email'        => 'marie.martin@example.com',
                'login_count'  => 0,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'username'     => 'Pierre Ravel',
                'phone_number' => '340000003',
                'email'        => 'pierre.ravel@example.com',
                'login_count'  => 0,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'username'     => 'Sophie Raja',
                'phone_number' => '340000004',
                'email'        => 'sophie.raja@example.com',
                'login_count'  => 0,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'username'     => 'David Ran',
                'phone_number' => '340000005',
                'email'        => 'david.ran@example.com',
                'login_count'  => 0,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        // Insertion une par une pour éviter les problèmes
        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
        }
        
        echo "✅ " . count($users) . " utilisateurs créés avec succès !\n";
        
        // Vérification
        $count = $this->db->table('users')->countAll();
        echo "📊 Total d'utilisateurs : " . $count . "\n";
    }
}