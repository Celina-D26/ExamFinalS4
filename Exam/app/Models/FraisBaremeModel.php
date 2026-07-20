<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisBaremeModel extends Model
{
    protected $table            = 'frais_baremes';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['type_operation', 'montant_min', 'montant_max', 'frais'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Récupère le montant des frais pour un type d'opération et un montant donné
     */
    public function getFrais(string $typeOperation, float $montant): float
    {
        $rule = $this->where('type_operation', $typeOperation)
                     ->where('montant_min <=', $montant)
                     ->where('montant_max >=', $montant)
                     ->first();

        return $rule ? (float)$rule['frais'] : 0.0;
    }

    /**
     * Calcule le gain total généré par les frais (Retraits + Transferts)
     */
    public function getGainsTotaux(): float
    {
        $db = \Config\Database::connect();

        // Vérifie si la table operations existe
        if (!$db->tableExists('operations')) {
            return 0.0;
        }

        $builder = $db->table('operations');
        $builder->selectSum('frais_appliques', 'total_gains');
        $builder->whereIn('type_operation', ['retrait', 'transfert']);
        
        $query = $builder->get()->getRow();
        return $query && $query->total_gains ? (float)$query->total_gains : 0.0;
    }

    /**
     * Récupère tous les barèmes par type d'opération
     */
    public function getBaremesByType(string $typeOperation): array
    {
        return $this->where('type_operation', $typeOperation)
                    ->orderBy('montant_min', 'ASC')
                    ->findAll();
    }
}