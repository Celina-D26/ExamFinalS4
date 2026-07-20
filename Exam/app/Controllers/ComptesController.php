<?php

namespace App\Controllers;

use App\Models\CompteClientModel;

class ComptesController extends BaseController
{
    protected $compteModel;

    public function __construct()
    {
        $this->compteModel = new CompteClientModel();
    }

    public function index()
    {
        try {
            // Récupérer les données de la base
            $clients = $this->compteModel->findAll();
            
            // Calculer les statistiques à partir des données
            $stats = [
                'total_clients' => count($clients),
                'total_soldes' => 0,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0
            ];

            // Calculer les totaux à partir des données
            foreach ($clients as $client) {
                $stats['total_soldes'] += $client['solde'];
                $stats['total_depots'] += $client['total_depots'];
                $stats['total_retraits'] += $client['total_retraits'];
                $stats['total_transferts'] += $client['total_transferts'];
                $stats['total_frais_payes'] += $client['total_frais_payes'];
            }

            $data = [
                'clients' => $clients,
                'stats' => $stats,
                'title' => 'Situation des Comptes Clients'
            ];

            return view('comptes/index', $data);
            
        } catch (\Exception $e) {
            // En cas d'erreur, afficher des données vides
            $data = [
                'clients' => [],
                'stats' => [
                    'total_clients' => 0,
                    'total_soldes' => 0,
                    'total_depots' => 0,
                    'total_retraits' => 0,
                    'total_transferts' => 0,
                    'total_frais_payes' => 0
                ],
                'title' => 'Situation des Comptes Clients',
                'error' => $e->getMessage()
            ];

            return view('comptes/index', $data);
        }
    }

    public function detail(string $clientId)
    {
        $client = $this->compteModel->getClient($clientId);
        
        if (!$client) {
            return redirect()->to('/comptes')->with('error', 'Client non trouvé');
        }

        $data = [
            'client' => $client,
            'title' => 'Détail du client'
        ];

        return view('comptes/detail', $data);
    }
}