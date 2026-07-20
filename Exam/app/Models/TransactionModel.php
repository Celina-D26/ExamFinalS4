<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'client_id', 'type_operation', 'montant', 'frais_appliques',
        'montant_net', 'solde_apres', 'reference', 'description', 'status'
    ];
    // Désactiver les timestamps pour éviter l'erreur
    protected $useTimestamps    = false;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Génère une référence unique
     */
    public function generateReference(): string
    {
        return 'TXN' . date('Ymd') . rand(100000, 999999);
    }

    /**
     * Enregistre une transaction
     */
    public function enregistrerTransaction(array $data): bool
    {
        try {
            // Générer une référence si non fournie
            if (!isset($data['reference']) || empty($data['reference'])) {
                $data['reference'] = $this->generateReference();
            }
            
            // Définir le statut par défaut
            if (!isset($data['status'])) {
                $data['status'] = 'completed';
            }
            
            // Ajouter la date de création manuellement
            $data['created_at'] = date('Y-m-d H:i:s');
            
            // Vérifier que client_id existe
            if (!isset($data['client_id']) || empty($data['client_id'])) {
                log_message('error', 'Client ID manquant pour la transaction');
                return false;
            }
            
            // Insérer la transaction
            $result = $this->insert($data);
            
            if ($result) {
                log_message('debug', 'Transaction enregistrée: ' . json_encode($data));
                return true;
            }
            
            log_message('error', 'Échec de l\'insertion de la transaction: ' . json_encode($data));
            return false;
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de l\'enregistrement de la transaction: ' . $e->getMessage());
            log_message('error', 'Data: ' . json_encode($data));
            return false;
        }
    }

    /**
     * Récupère les transactions d'un client
     */
    public function getTransactionsClient(string $clientId, int $limit = 50): array
    {
        try {
            $transactions = $this->where('client_id', $clientId)
                                 ->orderBy('created_at', 'DESC')
                                 ->findAll($limit);
            
            return $transactions;
        } catch (\Exception $e) {
            log_message('error', 'Erreur getTransactionsClient: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les transactions par type
     */
    public function getTransactionsByType(string $clientId, string $type, int $limit = 50): array
    {
        try {
            return $this->where('client_id', $clientId)
                        ->where('type_operation', $type)
                        ->orderBy('created_at', 'DESC')
                        ->findAll($limit);
        } catch (\Exception $e) {
            log_message('error', 'Erreur getTransactionsByType: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère toutes les transactions
     */
    public function getAllTransactions(int $limit = 100): array
    {
        try {
            return $this->orderBy('created_at', 'DESC')
                        ->findAll($limit);
        } catch (\Exception $e) {
            log_message('error', 'Erreur getAllTransactions: ' . $e->getMessage());
            return [];
        }
    }
}