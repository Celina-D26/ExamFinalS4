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
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = null;

    /**
     * Enregistre une transaction
     */
    public function enregistrerTransaction(array $data): bool
    {
        return $this->insert($data);
    }

    /**
     * Récupère les transactions d'un client
     */
    public function getTransactionsClient(string $clientId, int $limit = 10, int $offset = 0): array
    {
        return $this->where('client_id', $clientId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    /**
     * Récupère les transactions par type
     */
    public function getTransactionsByType(string $type, int $limit = 10): array
    {
        return $this->where('type_operation', $type)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    /**
     * Récupère les statistiques des transactions
     */
    public function getStats(): array
    {
        $stats = $this->select('
            COUNT(*) as total_transactions,
            SUM(montant) as total_montant,
            SUM(frais_appliques) as total_frais,
            SUM(montant_net) as total_net
        ')->first();

        return $stats ?? [
            'total_transactions' => 0,
            'total_montant' => 0,
            'total_frais' => 0,
            'total_net' => 0
        ];
    }
}