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
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $phoneNumber = $this->session->get('phone_number');
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        if (!$client) {
            // Créer un client par défaut si non trouvé
            $clientData = [
                'client_id' => 'CLT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'nom' => $this->session->get('username') ?? 'Utilisateur',
                'prenom' => '',
                'phone_number' => $phoneNumber,
                'email' => $this->session->get('email') ?? '',
                'solde' => 100000,
                'total_depots' => 0,
                'total_retraits' => 0,
                'total_transferts' => 0,
                'total_frais_payes' => 0,
                'status' => 'actif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->compteModel->insert($clientData);
            $client = $this->compteModel->getClientByPhone($phoneNumber);
        }

        $transactions = $this->transactionModel->getTransactionsClient($client['client_id'] ?? '', 10);

        $data = [
            'title' => 'Mobile Money — Tableau de bord',
            'username' => $this->session->get('username'),
            'phone_number' => $phoneNumber,
            'client' => $client,
            'transactions' => $transactions
        ];

        return view('client/dashboard', $data);
    }
}