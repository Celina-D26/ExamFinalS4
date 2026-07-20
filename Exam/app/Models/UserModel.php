<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['phone_number', 'name', 'email', 'last_login', 'login_count'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function findOrCreateByPhone($phoneNumber)
    {
        $user = $this->where('phone_number', $phoneNumber)->first();
        
        if (!$user) {
            // Créer un nouvel utilisateur automatiquement
            $data = [
                'phone_number' => $phoneNumber,
                'name' => 'Utilisateur ' . substr($phoneNumber, -4),
                'login_count' => 1,
                'last_login' => date('Y-m-d H:i:s')
            ];
            
            $this->insert($data);
            return $this->where('phone_number', $phoneNumber)->first();
        }
        
        // Mettre à jour les informations de connexion
        $this->update($user['id'], [
            'login_count' => $user['login_count'] + 1,
            'last_login' => date('Y-m-d H:i:s')
        ]);
        
        return $user;
    }
}