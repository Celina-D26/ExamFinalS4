<?php

namespace App\Controllers;

use App\Models\GainsModel;

class GainsController extends BaseController
{
    protected $gainsModel;

    public function __construct()
    {
        $this->gainsModel = new GainsModel();
    }

    public function index()
    {
        // Récupérer les données depuis le modèle
        $gainsParOperateur = $this->gainsModel->getGainsParOperateur();
        $gainsParType = $this->gainsModel->getGainsParType();
        $gainsDetail = $this->gainsModel->getTransactions(50);
        $totalGains = $this->gainsModel->getTotalGains();

        $data = [
            'gainsParOperateur' => $gainsParOperateur,
            'gainsParType' => $gainsParType,
            'gainsDetail' => $gainsDetail,
            'totalGains' => $totalGains,
            'title' => 'Situation des Gains'
        ];

        return view('gains/index', $data);
    }

    public function montantsOperateurs()
    {
        // Récupérer toutes les transactions
        $transactions = $this->gainsModel->getTransactions(1000);
        
        // Votre opérateur
        $monOperateur = 'Telma';
        
        // Mapping des opérateurs par client
        $clientOperateurs = $this->getClientOperateurs();
        
        // Initialisation
        $vous = [
            'operateur' => $monOperateur . ' (VOUS)',
            'total_montant' => 0,
            'total_frais' => 0,
            'total_commission' => 0,
            'total_a_envoyer' => 0,
            'total_a_reverser' => 0,
            'nombre_transactions' => 0,
            'details' => []
        ];

        $autres = [
            'operateur' => 'Autres Opérateurs (À reverser)',
            'total_montant' => 0,
            'total_frais' => 0,
            'total_commission' => 0,
            'total_a_envoyer' => 0,
            'total_a_reverser' => 0,
            'nombre_transactions' => 0,
            'details' => []
        ];

        $totalGeneral = [
            'nombre_transactions' => 0,
            'total_montant' => 0,
            'total_frais' => 0,
            'total_commission' => 0,
            'total_a_envoyer' => 0,
            'total_a_reverser' => 0
        ];

        foreach ($transactions as $tx) {
            $clientId = $tx['client_id'] ?? '';
            $operateur = $clientOperateurs[$clientId] ?? 'Inconnu';
            
            $montant = floatval($tx['montant'] ?? 0);
            $frais = floatval($tx['frais_appliques'] ?? 0);
            $commission = floatval($tx['commission_inter_operateur'] ?? 0);
            
            $totalGeneral['nombre_transactions']++;
            $totalGeneral['total_montant'] += $montant;
            $totalGeneral['total_frais'] += $frais;
            $totalGeneral['total_commission'] += $commission;
            
            if ($operateur === $monOperateur) {
                $vous['total_montant'] += $montant;
                $vous['total_frais'] += $frais;
                $vous['total_commission'] += $commission;
                $vous['total_a_envoyer'] += $frais;
                $vous['nombre_transactions']++;
                $vous['details'][] = [
                    'client_id' => $clientId,
                    'type' => $tx['type_operation'] ?? 'inconnu',
                    'montant' => $montant,
                    'frais' => $frais,
                    'commission' => $commission,
                    'a_envoyer' => $frais,
                    'a_reverser' => 0,
                    'date' => $tx['created_at'] ?? date('Y-m-d H:i:s')
                ];
                $totalGeneral['total_a_envoyer'] += $frais;
            } else {
                $autres['total_montant'] += $montant;
                $autres['total_frais'] += $frais;
                $autres['total_commission'] += $commission;
                $autres['total_a_reverser'] += $commission;
                $autres['nombre_transactions']++;
                $autres['details'][] = [
                    'client_id' => $clientId,
                    'type' => $tx['type_operation'] ?? 'inconnu',
                    'montant' => $montant,
                    'frais' => $frais,
                    'commission' => $commission,
                    'a_envoyer' => 0,
                    'a_reverser' => $commission,
                    'date' => $tx['created_at'] ?? date('Y-m-d H:i:s')
                ];
                $totalGeneral['total_a_reverser'] += $commission;
            }
        }

        $montantsParOperateur = [];
        if ($vous['nombre_transactions'] > 0) {
            $montantsParOperateur[] = $vous;
        }
        if ($autres['nombre_transactions'] > 0) {
            $montantsParOperateur[] = $autres;
        }

        $data = [
            'montantsParOperateur' => $montantsParOperateur,
            'resumeGeneral' => $totalGeneral,
            'title' => 'Montants à envoyer par Opérateur'
        ];

        return view('gains/montants', $data);
    }

    /**
     * Récupère le mapping des opérateurs par client
     */
    private function getClientOperateurs()
    {
        $db = \Config\Database::connect();
        $operateurs = [];
        
        if ($db->tableExists('comptes_clients')) {
            $clients = $db->table('comptes_clients')
                ->select('client_id, phone_number')
                ->get()
                ->getResultArray();
            
            foreach ($clients as $client) {
                $phone = $client['phone_number'] ?? '';
                $prefixe = substr(preg_replace('/[^0-9]/', '', $phone), 0, 3);
                
                if ($db->tableExists('prefixes')) {
                    $op = $db->table('prefixes')
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

    public function exportCsv()
    {
        $transactions = $this->gainsModel->getTransactions(100);
        $totalGains = $this->gainsModel->getTotalGains();

        $filename = 'situation_des_gains_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF");
        
        fputcsv($output, ['SITUATION DES GAINS', 'Généré le ' . date('d/m/Y à H:i')]);
        fputcsv($output, ['Total des gains: ' . number_format($totalGains, 2, ',', ' ') . ' Ar']);
        fputcsv($output, []);
        fputcsv($output, ['ID', 'Client', 'Type', 'Montant', 'Frais', 'Commission', 'Date']);
        
        foreach ($transactions as $tx) {
            fputcsv($output, [
                $tx['id'] ?? '',
                $tx['client_id'] ?? '',
                $tx['type_operation'] ?? '',
                number_format($tx['montant'] ?? 0, 2, ',', ' ') . ' Ar',
                number_format($tx['frais_appliques'] ?? 0, 2, ',', ' ') . ' Ar',
                number_format($tx['commission_inter_operateur'] ?? 0, 2, ',', ' ') . ' Ar',
                date('d/m/Y H:i', strtotime($tx['created_at'] ?? 'now'))
            ]);
        }
        
        fclose($output);
        exit;
    }

    public function exportMontantsCsv()
    {
        $filename = 'montants_par_operateur_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF");
        
        fputcsv($output, ['MONTANTS PAR OPÉRATEUR', 'Généré le ' . date('d/m/Y à H:i')]);
        fputcsv($output, []);
        fputcsv($output, ['Opérateur', 'Transactions', 'Montant Total', 'Frais', 'Commission', 'À Garder', 'À Reverser']);
        
        fclose($output);
        exit;
    }
}