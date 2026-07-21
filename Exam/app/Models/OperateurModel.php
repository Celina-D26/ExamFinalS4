<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prefixes', 'commission_pourcentage', 'is_other', 'is_active'];
    protected $useTimestamps = true;

    /**
     * Récupère l'opérateur par préfixe
     */
    public function getOperateurByPrefix($prefix)
    {
        try {
            $operateurs = $this->where('is_active', 1)->findAll();
            foreach ($operateurs as $op) {
                $prefixes = json_decode($op['prefixes'], true);
                if (is_array($prefixes) && in_array($prefix, $prefixes)) {
                    return $op;
                }
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Récupère les opérateurs autres
     */
    public function getOtherOperateurs()
    {
        try {
            return $this->where('is_other', 1)->where('is_active', 1)->findAll();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Récupère l'opérateur principal
     */
    public function getPrincipalOperateur()
    {
        try {
            return $this->where('is_other', 0)->where('is_active', 1)->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Vérifie si un numéro appartient à l'opérateur principal
     */
    public function isPrincipalOperateur($phoneNumber)
    {
        try {
            $principal = $this->getPrincipalOperateur();
            if (!$principal) {
                return true; // Par défaut, on considère que c'est le même opérateur
            }
            $prefixes = json_decode($principal['prefixes'], true);
            if (!is_array($prefixes)) {
                return true;
            }
            foreach ($prefixes as $prefix) {
                if (strpos($phoneNumber, $prefix) === 0) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            return true;
        }
    }

    /**
     * Récupère la commission pour un opérateur
     */
    public function getCommission($phoneNumber)
    {
        try {
            $operateur = $this->getOperateurByPrefix(substr($phoneNumber, 0, 3));
            if (!$operateur) {
                return 0;
            }
            return (float)$operateur['commission_pourcentage'];
        } catch (\Exception $e) {
            return 0;
        }
    }
}