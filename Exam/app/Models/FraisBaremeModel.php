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
        try {
            log_message('debug', 'Recherche frais pour ' . $typeOperation . ' - ' . $montant);
            
            $rule = $this->where('type_operation', $typeOperation)
                         ->where('montant_min <=', $montant)
                         ->where('montant_max >=', $montant)
                         ->first();

            log_message('debug', 'Règle trouvée: ' . json_encode($rule));
            
            return $rule ? (float)$rule['frais'] : 0.0;
        } catch (\Exception $e) {
            log_message('error', 'Erreur getFrais: ' . $e->getMessage());
            return 0.0;
        }
    }

    /**
     * Calcule le gain total généré par les frais (Retraits + Transferts)
     */
    public function getGainsTotaux(): float
    {
        try {
            $db = \Config\Database::connect();

            // Vérifie si la table transactions existe
            if (!$db->tableExists('transactions')) {
                return 0.0;
            }

            $builder = $db->table('transactions');
            $builder->selectSum('frais_appliques', 'total_gains');
            $builder->whereIn('type_operation', ['retrait', 'transfert']);
            
            $query = $builder->get()->getRow();
            return $query && isset($query->total_gains) ? (float)$query->total_gains : 0.0;
        } catch (\Exception $e) {
            log_message('error', 'Erreur getGainsTotaux: ' . $e->getMessage());
            return 0.0;
        }
    }

    /**
     * Récupère tous les barèmes par type d'opération
     */
    public function getBaremesByType(string $typeOperation): array
    {
        try {
            return $this->where('type_operation', $typeOperation)
                        ->orderBy('montant_min', 'ASC')
                        ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Erreur getBaremesByType: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère tous les barèmes
     */
    public function getAllBaremes(): array
    {
        try {
            return $this->orderBy('type_operation', 'ASC')
                        ->orderBy('montant_min', 'ASC')
                        ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Erreur getAllBaremes: ' . $e->getMessage());
            return [];
        }
    }
}