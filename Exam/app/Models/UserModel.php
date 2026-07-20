<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'phone_number', 'email', 'last_login', 'login_count'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';

    public function findUser($username, $phoneNumber)
    {
        try {
            return $this->where('username', $username)
                        ->where('phone_number', $phoneNumber)
                        ->first();
        } catch (\Exception $e) {
            log_message('error', 'Erreur findUser: ' . $e->getMessage());
            return null;
        }
    }

    public function createUser($username, $phoneNumber)
    {
        try {
            $data = [
                'username' => $username,
                'phone_number' => $phoneNumber,
                'login_count' => 1,
                'last_login' => date('Y-m-d H:i:s')
            ];
            
            $this->insert($data);
            return $this->where('phone_number', $phoneNumber)->first();
        } catch (\Exception $e) {
            log_message('error', 'Erreur createUser: ' . $e->getMessage());
            return null;
        }
    }

    public function updateLoginInfo($userId)
    {
        try {
            $user = $this->find($userId);
            if ($user) {
                $newCount = ($user['login_count'] ?? 0) + 1;
                return $this->update($userId, [
                    'login_count' => $newCount,
                    'last_login' => date('Y-m-d H:i:s')
                ]);
            }
            return false;
        } catch (\Exception $e) {
            log_message('error', 'Erreur updateLoginInfo: ' . $e->getMessage());
            return false;
        }
    }
}