<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_id', 
        'type_operation', 
        'montant', 
        'frais_appliques',
        'commission_inter_operateur',  // Changé de 'commission' à 'commission_inter_operateur'
        'montant_net', 
        'solde_apres', 
        'reference', 
        'description', 
        'status',
        'operateur_destinataire',      // Ajouté pour les transferts inter-opérateurs
        'created_at'
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
                $data['status'] = 'complete';
            }
            
            // Définir les valeurs par défaut
            if (!isset($data['commission_inter_operateur'])) {
                $data['commission_inter_operateur'] = 0;
            }
            if (!isset($data['operateur_destinataire'])) {
                $data['operateur_destinataire'] = null;
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

    // Ajouter cette méthode pour compter par type
    public function countByType(string $clientId, string $type): int
    {
        try {
            return $this->where('client_id', $clientId)
                        ->where('type_operation', $type)
                        ->countAllResults();
        } catch (\Exception $e) {
            return 0;
        }
    }
}