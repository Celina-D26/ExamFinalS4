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
     * Récupère un client par son ID
     */
    public function getClient(string $clientId)
    {
        return $this->where('client_id', $clientId)->first();
    }
}