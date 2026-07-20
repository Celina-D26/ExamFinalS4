<?php

namespace App\Controllers\Client;

use CodeIgniter\Controller;
use App\Models\CompteClientModel;
use App\Models\TransactionModel;

class Dashboard extends Controller
{
    protected $session;
    protected $compteModel;
    protected $transactionModel;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['url', 'form']);
        $this->session = \Config\Services::session();
        $this->compteModel = new CompteClientModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $phoneNumber = $this->session->get('phone_number');
        $username = $this->session->get('username') ?? 'Utilisateur';
        
        // Récupérer le client
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        // Si le client n'existe pas, le créer
        if (!$client) {
            $clientId = 'CLT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $this->compteModel->insert([
                'client_id' => $clientId,
                'nom' => $username,
                'prenom' => '',
                'phone_number' => $phoneNumber,
                'email' => $this->session->get('email') ?? '',
                'solde' => 100000,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0,
                'status' => 'actif'
            ]);
            $client = $this->compteModel->getClientByPhone($phoneNumber);
        }

        // Récupérer les transactions du client
        $transactions = $this->transactionModel
            ->where('client_id', $client['client_id'])
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->findAll();

        // Calculer les statistiques
        $total = $this->transactionModel
            ->where('client_id', $client['client_id'])
            ->countAllResults();
            
        $totalMontant = $this->transactionModel
            ->where('client_id', $client['client_id'])
            ->selectSum('montant')
            ->get()
            ->getRowArray();
            
        $totalFrais = $this->transactionModel
            ->where('client_id', $client['client_id'])
            ->selectSum('frais_appliques')
            ->get()
            ->getRowArray();

        $stats = [
            'total' => $total,
            'total_montant' => $totalMontant['montant'] ?? 0,
            'total_frais' => $totalFrais['frais_appliques'] ?? 0,
            'total_net' => ($totalMontant['montant'] ?? 0) - ($totalFrais['frais_appliques'] ?? 0)
        ];

        $data = [
            'title' => 'Mobile Money — Tableau de bord',
            'username' => $username,
            'phone_number' => $phoneNumber,
            'client' => $client,
            'transactions' => $transactions,
            'stats' => $stats
        ];

        return view('client/dashboard', $data);
    }
}