<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_id', 'type_operation', 'montant', 'frais_appliques',
        'montant_net', 'solde_apres', 'reference', 'description', 'status',
        'commission', 'include_fees', 'is_multiple', 'destinations', 'operateur_id'
    ];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';

    public function generateReference(): string
    {
        return 'TXN' . date('Ymd') . rand(100000, 999999);
    }

    public function enregistrerTransaction(array $data): bool
    {
        try {
            if (!isset($data['reference']) || empty($data['reference'])) {
                $data['reference'] = $this->generateReference();
            }
            
            if (!isset($data['status'])) {
                $data['status'] = 'completed';
            }
            
            // Définir les valeurs par défaut
            if (!isset($data['commission'])) {
                $data['commission'] = 0;
            }
            if (!isset($data['include_fees'])) {
                $data['include_fees'] = 0;
            }
            if (!isset($data['is_multiple'])) {
                $data['is_multiple'] = 0;
            }
            if (!isset($data['destinations'])) {
                $data['destinations'] = null;
            }
            if (!isset($data['operateur_id'])) {
                $data['operateur_id'] = null;
            }
            
            $data['created_at'] = date('Y-m-d H:i:s');
            
            if (!isset($data['client_id']) || empty($data['client_id'])) {
                log_message('error', 'Client ID manquant pour la transaction');
                return false;
            }
            
            $result = $this->insert($data);
            
            if ($result) {
                log_message('debug', 'Transaction enregistrée: ' . json_encode($data));
                return true;
            }
            
            log_message('error', 'Échec de l\'insertion de la transaction: ' . json_encode($data));
            return false;
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
            return false;
        }
    }

    public function getTransactionsClient(string $clientId, int $limit = 50): array
    {
        try {
            return $this->where('client_id', $clientId)
                        ->orderBy('created_at', 'DESC')
                        ->findAll($limit);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getTransactionsByType(string $clientId, string $type, int $limit = 50): array
    {
        try {
            return $this->where('client_id', $clientId)
                        ->where('type_operation', $type)
                        ->orderBy('created_at', 'DESC')
                        ->findAll($limit);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getAllTransactions(int $limit = 100): array
    {
        try {
            return $this->orderBy('created_at', 'DESC')
                        ->findAll($limit);
        } catch (\Exception $e) {
            return [];
        }
    }
}