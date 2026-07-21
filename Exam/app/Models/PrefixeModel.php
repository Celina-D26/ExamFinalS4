<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prefixe', 'operateur', 'pays', 'commission', 'est_actif'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Récupère la commission pour un préfixe donné
     */
    public function getCommissionByPrefixe(string $prefixe): float
    {
        $result = $this->where('prefixe', $prefixe)->first();
        return $result ? (float)$result['commission'] : 0;
    }

    /**
     * Récupère l'opérateur pour un numéro donné
     */
    public function getOperateurByPhone(string $phone): ?array
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $prefixe = substr($phone, 0, 3);
        
        return $this->where('prefixe', $prefixe)->first();
    }

    /**
     * Récupère tous les opérateurs actifs
     */
    public function getOperateursActifs(): array
    {
        return $this->where('est_actif', 1)->orderBy('operateur')->findAll();
    }

    /**
     * Vérifie si un numéro est vers un autre opérateur
     */
    public function isAutreOperateur(string $phone, string $operateurActuel): bool
    {
        $operateur = $this->getOperateurByPhone($phone);
        if (!$operateur) {
            return false;
        }
        return $operateur['operateur'] !== $operateurActuel;
    }

    /**
     * Calcule la commission pour un transfert
     */
    public function calculerCommission(string $prefixe, float $montant): float
    {
        $commission = $this->getCommissionByPrefixe($prefixe);
        return ($commission / 100) * $montant;
    }
}