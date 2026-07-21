<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table            = 'epargne';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'client_id', 
        'solde_epargne', 
        'total_epargne', 
        'total_retraits_epargne',
        'pourcentage_defaut',
        'epargne_active'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Récupère le compte épargne d'un client
     */
    public function getEpargneByClient(string $clientId)
    {
        return $this->where('client_id', $clientId)->first();
    }

    /**
     * Crée un compte épargne pour un nouveau client
     */
    public function createEpargne(string $clientId, float $pourcentageDefaut = 0)
    {
        $data = [
            'client_id' => $clientId,
            'solde_epargne' => 0,
            'total_epargne' => 0,
            'total_retraits_epargne' => 0,
            'pourcentage_defaut' => $pourcentageDefaut,
            'epargne_active' => 1
        ];

        $this->insert($data);
        return $this->getEpargneByClient($clientId);
    }

    /**
     * Ajoute un montant à l'épargne
     */
    public function ajouterEpargne(string $clientId, float $montant): bool
    {
        $epargne = $this->getEpargneByClient($clientId);
        if (!$epargne) {
            return false;
        }

        $nouveauSolde = $epargne['solde_epargne'] + $montant;
        $nouveauTotal = $epargne['total_epargne'] + $montant;

        return $this->update($epargne['id'], [
            'solde_epargne' => $nouveauSolde,
            'total_epargne' => $nouveauTotal
        ]);
    }

    /**
     * Retire un montant de l'épargne
     */
    public function retirerEpargne(string $clientId, float $montant): bool
    {
        $epargne = $this->getEpargneByClient($clientId);
        if (!$epargne || $epargne['solde_epargne'] < $montant) {
            return false;
        }

        $nouveauSolde = $epargne['solde_epargne'] - $montant;
        $nouveauTotalRetraits = $epargne['total_retraits_epargne'] + $montant;

        return $this->update($epargne['id'], [
            'solde_epargne' => $nouveauSolde,
            'total_retraits_epargne' => $nouveauTotalRetraits
        ]);
    }

    /**
     * Met à jour le pourcentage d'épargne par défaut
     */
    public function updatePourcentage(string $clientId, float $pourcentage): bool
    {
        $epargne = $this->getEpargneByClient($clientId);
        if (!$epargne) {
            return false;
        }

        return $this->update($epargne['id'], [
            'pourcentage_defaut' => $pourcentage
        ]);
    }

    /**
     * Active ou désactive l'épargne
     */
    public function toggleEpargne(string $clientId, bool $active): bool
    {
        $epargne = $this->getEpargneByClient($clientId);
        if (!$epargne) {
            return false;
        }

        return $this->update($epargne['id'], [
            'epargne_active' => $active ? 1 : 0
        ]);
    }

    /**
     * Calcule le montant à épargner
     */
    public function calculerMontantEpargne(float $montant, float $pourcentage): float
    {
        if ($pourcentage <= 0 || $pourcentage > 100) {
            return 0;
        }
        return ($montant * $pourcentage) / 100;
    }

    /**
     * Récupère les statistiques d'épargne d'un client
     */
    public function getStatsEpargne(string $clientId): array
    {
        $epargne = $this->getEpargneByClient($clientId);
        
        if (!$epargne) {
            return [
                'solde_epargne' => 0,
                'total_epargne' => 0,
                'total_retraits_epargne' => 0,
                'pourcentage_defaut' => 0,
                'epargne_active' => false
            ];
        }

        return [
            'solde_epargne' => $epargne['solde_epargne'],
            'total_epargne' => $epargne['total_epargne'],
            'total_retraits_epargne' => $epargne['total_retraits_epargne'],
            'pourcentage_defaut' => $epargne['pourcentage_defaut'],
            'epargne_active' => $epargne['epargne_active'] == 1
        ];
    }

    /**
     * Récupère tous les comptes épargne avec les infos clients
     */
    public function getAllEpargneWithClients(): array
    {
        $db = \Config\Database::connect();
        
        return $db->table('epargne')
            ->select('epargne.*, comptes_clients.nom, comptes_clients.prenom, comptes_clients.phone_number')
            ->join('comptes_clients', 'comptes_clients.client_id = epargne.client_id', 'left')
            ->orderBy('solde_epargne', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère le total des épargnes
     */
    public function getTotalEpargneGlobal(): float
    {
        $result = $this->selectSum('solde_epargne')->first();
        return $result ? (float)$result['solde_epargne'] : 0;
    }
}