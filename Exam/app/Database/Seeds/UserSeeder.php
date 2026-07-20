<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
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

        $this->db->table('users')->insertBatch($data);
        
        echo "✅ " . count($data) . " utilisateurs créés avec succès !\n";
    }
}