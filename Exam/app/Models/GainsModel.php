<?php

namespace App\Models;

use CodeIgniter\Model;

class GainsModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    /**
     * Récupère les gains par opérateur (même opérateur vs autres opérateurs)
     */
    public function getGainsParOperateur()
    {
        // Retourner des données par défaut si la table n'existe pas
        if (!$this->db->tableExists('transactions')) {
            return ['meme_operateur' => [], 'autre_operateur' => []];
        }

        try {
            // Gains pour le même opérateur (commission_inter_operateur = 0)
            $memeOperateur = $this->db->table('transactions')
                ->select('type_operation, COUNT(*) as nombre, SUM(frais_appliques) as total_frais')
                ->where('commission_inter_operateur', 0)
                ->groupBy('type_operation')
                ->get()
                ->getResultArray();

            // Gains pour les autres opérateurs (commission_inter_operateur > 0)
            $autreOperateur = $this->db->table('transactions')
                ->select('type_operation, COUNT(*) as nombre, SUM(frais_appliques) as total_frais, SUM(commission_inter_operateur) as total_commission')
                ->where('commission_inter_operateur >', 0)
                ->groupBy('type_operation')
                ->get()
                ->getResultArray();

            return [
                'meme_operateur' => $memeOperateur ?: [],
                'autre_operateur' => $autreOperateur ?: []
            ];
        } catch (\Exception $e) {
            log_message('error', 'Erreur getGainsParOperateur: ' . $e->getMessage());
            return ['meme_operateur' => [], 'autre_operateur' => []];
        }
    }

    /**
     * Récupère les gains par type d'opération
     */
    public function getGainsParType()
    {
        if (!$this->db->tableExists('transactions')) {
            return [];
        }

        try {
            return $this->db->table('transactions')
                ->select('type_operation, COUNT(*) as nombre, SUM(montant) as total_montant, SUM(frais_appliques) as total_frais')
                ->groupBy('type_operation')
                ->get()
                ->getResultArray() ?: [];
        } catch (\Exception $e) {
            log_message('error', 'Erreur getGainsParType: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère toutes les transactions
     */
    public function getTransactions($limit = 50)
    {
        if (!$this->db->tableExists('transactions')) {
            return [];
        }

        try {
            return $this->db->table('transactions')
                ->select('transactions.*')
                ->orderBy('transactions.created_at', 'DESC')
                ->limit($limit)
                ->get()
                ->getResultArray() ?: [];
        } catch (\Exception $e) {
            log_message('error', 'Erreur getTransactions: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Calcul du total des gains
     */
    public function getTotalGains()
    {
        if (!$this->db->tableExists('transactions')) {
            return 0;
        }

        try {
            $result = $this->db->table('transactions')
                ->select('SUM(frais_appliques) as total')
                ->whereIn('type_operation', ['retrait', 'transfert'])
                ->get()
                ->getRowArray();
            return $result['total'] ?? 0;
        } catch (\Exception $e) {
            log_message('error', 'Erreur getTotalGains: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Récupère le résumé général
     */
    public function getResumeGeneral()
    {
        if (!$this->db->tableExists('transactions')) {
            return [
                'total_montant' => 0,
                'total_frais' => 0,
                'total_commission' => 0,
                'total_a_envoyer' => 0,
                'total_a_reverser' => 0,
                'nombre_transactions' => 0
            ];
        }

        try {
            $result = $this->db->table('transactions')
                ->select('
                    SUM(montant) as total_montant,
                    SUM(frais_appliques) as total_frais,
                    SUM(commission_inter_operateur) as total_commission,
                    COUNT(*) as nombre_transactions
                ')
                ->get()
                ->getRowArray();

            $result['total_a_envoyer'] = $result['total_frais'] ?? 0;
            $result['total_a_reverser'] = $result['total_commission'] ?? 0;
            
            return $result ?: [
                'total_montant' => 0,
                'total_frais' => 0,
                'total_commission' => 0,
                'total_a_envoyer' => 0,
                'total_a_reverser' => 0,
                'nombre_transactions' => 0
            ];
        } catch (\Exception $e) {
            log_message('error', 'Erreur getResumeGeneral: ' . $e->getMessage());
            return [
                'total_montant' => 0,
                'total_frais' => 0,
                'total_commission' => 0,
                'total_a_envoyer' => 0,
                'total_a_reverser' => 0,
                'nombre_transactions' => 0
            ];
        }
    }

    /**
     * Récupère les montants par opérateur
     */
    public function getMontantsParOperateur()
    {
        if (!$this->db->tableExists('transactions')) {
            return [];
        }

        try {
            $transactions = $this->getTransactions(1000);
            
            if (empty($transactions)) {
                return [];
            }

            // Mapping des opérateurs par client
            $clientOperateurs = $this->getClientOperateurs();
            
            $operateurs = [];
            $monOperateur = 'Telma';

            foreach ($transactions as $tx) {
                $clientId = $tx['client_id'] ?? '';
                $operateur = $clientOperateurs[$clientId] ?? 'Inconnu';
                
                $montant = floatval($tx['montant'] ?? 0);
                $frais = floatval($tx['frais_appliques'] ?? 0);
                $commission = floatval($tx['commission_inter_operateur'] ?? 0);
                
                if (!isset($operateurs[$operateur])) {
                    $operateurs[$operateur] = [
                        'operateur' => $operateur,
                        'nombre_transactions' => 0,
                        'total_montant' => 0,
                        'total_frais' => 0,
                        'total_commission' => 0,
                        'total_a_envoyer' => 0,
                        'total_a_reverser' => 0,
                        'details' => []
                    ];
                }
                
                $operateurs[$operateur]['nombre_transactions']++;
                $operateurs[$operateur]['total_montant'] += $montant;
                $operateurs[$operateur]['total_frais'] += $frais;
                $operateurs[$operateur]['total_commission'] += $commission;
                
                if ($operateur === $monOperateur) {
                    $operateurs[$operateur]['total_a_envoyer'] += $frais;
                } else {
                    $operateurs[$operateur]['total_a_reverser'] += $commission;
                }
                
                $operateurs[$operateur]['details'][] = [
                    'client_id' => $clientId,
                    'type' => $tx['type_operation'] ?? 'inconnu',
                    'montant' => $montant,
                    'frais' => $frais,
                    'commission' => $commission,
                    'a_envoyer' => ($operateur === $monOperateur) ? $frais : 0,
                    'a_reverser' => ($operateur !== $monOperateur) ? $commission : 0,
                    'date' => $tx['created_at'] ?? date('Y-m-d H:i:s')
                ];
            }

            return array_values($operateurs);
        } catch (\Exception $e) {
            log_message('error', 'Erreur getMontantsParOperateur: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère le mapping des opérateurs par client
     */
    private function getClientOperateurs()
    {
        $operateurs = [];
        
        if ($this->db->tableExists('comptes_clients')) {
            $clients = $this->db->table('comptes_clients')
                ->select('client_id, phone_number')
                ->get()
                ->getResultArray();
            
            foreach ($clients as $client) {
                $phone = $client['phone_number'] ?? '';
                $prefixe = substr(preg_replace('/[^0-9]/', '', $phone), 0, 3);
                
                if ($this->db->tableExists('prefixes')) {
                    $op = $this->db->table('prefixes')
                        ->select('operateur')
                        ->where('prefixe', $prefixe)
                        ->get()
                        ->getRowArray();
                    $operateurs[$client['client_id']] = $op['operateur'] ?? 'Inconnu';
                } else {
                    $operateurs[$client['client_id']] = 'Inconnu';
                }
            }
        }
        
        return $operateurs;
    }
}