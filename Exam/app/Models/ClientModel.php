<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'phone_number', 'balance', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType = 'array';

    public function getClientByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getClientByPhone($phoneNumber)
    {
        return $this->where('phone_number', $phoneNumber)->first();
    }

    public function createClient($userId, $phoneNumber)
    {
        $data = [
            'user_id' => $userId,
            'phone_number' => $phoneNumber,
            'balance' => 100000, // Solde initial pour test
            'is_active' => 1
        ];
        
        $this->insert($data);
        return $this->where('user_id', $userId)->first();
    }

    public function updateBalance($clientId, $amount)
    {
        $client = $this->find($clientId);
        if ($client) {
            $newBalance = $client['balance'] + $amount;
            return $this->update($clientId, ['balance' => $newBalance]);
        }
        return false;
    }

    public function getClientWithUser($clientId)
    {
        return $this->select('clients.*, users.username, users.email')
                    ->join('users', 'users.id = clients.user_id')
                    ->where('clients.id', $clientId)
                    ->first();
    }

    public function getAllClientsWithUsers()
    {
        return $this->select('clients.*, users.username, users.email')
                    ->join('users', 'users.id = clients.user_id')
                    ->findAll();
    }
}