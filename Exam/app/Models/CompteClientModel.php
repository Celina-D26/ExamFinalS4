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
    // Désactiver les timestamps pour éviter l'erreur
    protected $useTimestamps    = false;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Récupère un client par son numéro de téléphone
     */
    public function getClientByPhone(string $phoneNumber)
    {
        try {
            // Nettoyer le numéro de téléphone
            $phoneNumber = $this->cleanPhoneNumber($phoneNumber);
            return $this->where('phone_number', $phoneNumber)->first();
        } catch (\Exception $e) {
            log_message('error', 'Erreur getClientByPhone: ' . $e->getMessage());
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
            log_message('error', 'Erreur getClient: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Crée un nouveau client
     */
    public function createClient($phoneNumber, $username, $email = '')
    {
        try {
            $phoneNumber = $this->cleanPhoneNumber($phoneNumber);
            
            $existing = $this->getClientByPhone($phoneNumber);
            if ($existing) {
                return $existing;
            }

            $clientId = 'CLT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            
            $data = [
                'client_id' => $clientId,
                'nom' => $username ?? 'Utilisateur',
                'prenom' => '',
                'phone_number' => $phoneNumber,
                'email' => $email,
                'solde' => 100000,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0,
                'status' => 'actif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->insert($data);
            return $this->getClientByPhone($phoneNumber);
        } catch (\Exception $e) {
            log_message('error', 'Erreur createClient: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Nettoie un numéro de téléphone
     */
    private function cleanPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        return $phone;
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
            
            $nouveauSolde = ($client['solde'] ?? 0) + $montant;
            return $this->update($client['id'], [
                'solde' => $nouveauSolde,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur updateSolde: ' . $e->getMessage());
            return false;
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

            $data = ['updated_at' => date('Y-m-d H:i:s')];
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
            log_message('error', 'Erreur updateStats: ' . $e->getMessage());
            return false;
        }
    }
}