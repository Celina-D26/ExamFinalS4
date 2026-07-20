<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteClientModel extends Model
{
    protected $table            = 'comptes_clients';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'client_id', 'nom', 'prenom', 'phone_number', 'email',
        'solde', 'total_depots', 'total_retraits', 'total_transferts',
        'total_frais_payes', 'status'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Récupère un client par son numéro de téléphone
     */
    public function getClientByPhone(string $phoneNumber)
    {
        try {
            return $this->where('phone_number', $phoneNumber)->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Récupère un client par son ID
     */
    public function getClient(string $clientId)
    {
        try {
            return $this->where('client_id', $clientId)->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Met à jour le solde d'un client
     */
    public function updateSolde(string $clientId, float $montant): bool
    {
        try {
            $client = $this->getClient($clientId);
            if (!$client) {
                return false;
            }
            
            $nouveauSolde = $client['solde'] + $montant;
            return $this->update($client['id'], ['solde' => $nouveauSolde]);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Récupère tous les clients actifs
     */
    public function getClientsActifs()
    {
        try {
            return $this->where('status', 'actif')->findAll();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Met à jour les statistiques d'un client
     */
    public function updateStats(string $clientId, string $type, float $montant, float $frais): bool
    {
        try {
            $client = $this->getClient($clientId);
            if (!$client) {
                return false;
            }

            $data = [];
            switch ($type) {
                case 'depot':
                    $data['total_depots'] = ($client['total_depots'] ?? 0) + $montant;
                    break;
                case 'retrait':
                    $data['total_retraits'] = ($client['total_retraits'] ?? 0) + $montant;
                    break;
                case 'transfert':
                    $data['total_transferts'] = ($client['total_transferts'] ?? 0) + $montant;
                    break;
                default:
                    return false;
            }
            
            $data['total_frais_payes'] = ($client['total_frais_payes'] ?? 0) + $frais;
            
            return $this->update($client['id'], $data);
        } catch (\Exception $e) {
            return false;
        }
    }
}