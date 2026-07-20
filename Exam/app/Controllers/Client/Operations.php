<?php

namespace App\Controllers\Client;

use CodeIgniter\Controller;
use App\Models\CompteClientModel;
use App\Models\TransactionModel;
use App\Models\FraisBaremeModel;

class Operations extends Controller
{
    protected $session;
    protected $compteModel;
    protected $transactionModel;
    protected $fraisModel;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['url', 'form']);
        $this->session = \Config\Services::session();
        $this->compteModel = new CompteClientModel();
        $this->transactionModel = new TransactionModel();
        $this->fraisModel = new FraisBaremeModel();
    }

    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $phoneNumber = $this->session->get('phone_number');
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        // Si le client n'existe pas, utiliser les données de session
        if (!$client) {
            $client = [
                'client_id' => 'CLT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'nom' => $this->session->get('username') ?? 'Utilisateur',
                'phone_number' => $phoneNumber,
                'solde' => 100000
            ];
        }

        $data = [
            'title' => 'Mobile Money — Opérations',
            'username' => $this->session->get('username'),
            'phone_number' => $phoneNumber,
            'client' => $client
        ];

        return view('client/operations', $data);
    }

    public function deposit()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        // Récupérer le montant
        $input = $this->request->getJSON(true);
        $amount = $input ? ($input['amount'] ?? 0) : $this->request->getPost('amount');
        
        if (!$amount || $amount <= 0) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Montant invalide'
            ]);
        }

        $phoneNumber = $this->session->get('phone_number');
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        if (!$client) {
            return $this->response->setJSON(['success' => false, 'message' => 'Client non trouvé']);
        }

        try {
            // Mettre à jour le solde
            $nouveauSolde = $client['solde'] + $amount;
            $this->compteModel->update($client['id'], ['solde' => $nouveauSolde]);
            
            // Mettre à jour les stats
            $this->compteModel->update($client['id'], [
                'total_depots' => ($client['total_depots'] ?? 0) + $amount
            ]);
            
            // Créer la transaction
            $transactionData = [
                'client_id' => $client['client_id'],
                'type_operation' => 'depot',
                'montant' => $amount,
                'frais_appliques' => 0,
                'montant_net' => $amount,
                'solde_apres' => $nouveauSolde,
                'description' => 'Dépôt automatique',
                'reference' => 'TXN' . date('Ymd') . rand(100000, 999999)
            ];
            
            $this->transactionModel->insert($transactionData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Dépôt effectué avec succès',
                'new_balance' => $nouveauSolde
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur dépôt: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }

    public function withdrawal()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        // Récupérer le montant
        $input = $this->request->getJSON(true);
        $amount = $input ? ($input['amount'] ?? 0) : $this->request->getPost('amount');
        
        if (!$amount || $amount <= 0) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Montant invalide'
            ]);
        }

        $phoneNumber = $this->session->get('phone_number');
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        if (!$client) {
            return $this->response->setJSON(['success' => false, 'message' => 'Client non trouvé']);
        }

        try {
            // Calculer les frais
            $fee = $this->fraisModel->getFrais('retrait', $amount);
            $totalAmount = $amount + $fee;
            
            // Vérifier le solde
            if ($client['solde'] < $totalAmount) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Solde insuffisant. Vous avez ' . number_format($client['solde'], 0, ',', ' ') . ' Ar',
                    'balance' => $client['solde']
                ]);
            }
            
            // Mettre à jour le solde
            $nouveauSolde = $client['solde'] - $totalAmount;
            $this->compteModel->update($client['id'], ['solde' => $nouveauSolde]);
            
            // Mettre à jour les stats
            $this->compteModel->update($client['id'], [
                'total_retraits' => ($client['total_retraits'] ?? 0) + $amount,
                'total_frais_payes' => ($client['total_frais_payes'] ?? 0) + $fee
            ]);
            
            // Créer la transaction
            $transactionData = [
                'client_id' => $client['client_id'],
                'type_operation' => 'retrait',
                'montant' => $amount,
                'frais_appliques' => $fee,
                'montant_net' => -$totalAmount,
                'solde_apres' => $nouveauSolde,
                'description' => 'Retrait automatique',
                'reference' => 'TXN' . date('Ymd') . rand(100000, 999999)
            ];
            
            $this->transactionModel->insert($transactionData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Retrait effectué avec succès',
                'new_balance' => $nouveauSolde,
                'fee' => $fee
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur retrait: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }

    public function transfer()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        // Récupérer les données
        $input = $this->request->getJSON(true);
        if ($input) {
            $amount = $input['amount'] ?? 0;
            $destinationPhone = $input['destination_phone'] ?? '';
        } else {
            $amount = $this->request->getPost('amount');
            $destinationPhone = $this->request->getPost('destination_phone');
        }
        
        if (!$amount || $amount <= 0) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Montant invalide'
            ]);
        }

        if (!$destinationPhone) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Numéro de destination requis'
            ]);
        }

        $phoneNumber = $this->session->get('phone_number');
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        if (!$client) {
            return $this->response->setJSON(['success' => false, 'message' => 'Client non trouvé']);
        }

        try {
            // Vérifier le destinataire
            $destinationClient = $this->compteModel->getClientByPhone($destinationPhone);
            if (!$destinationClient) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Destinataire non trouvé'
                ]);
            }

            if ($destinationClient['client_id'] == $client['client_id']) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Vous ne pouvez pas vous transférer à vous-même'
                ]);
            }
            
            // Calculer les frais
            $fee = $this->fraisModel->getFrais('transfert', $amount);
            $totalAmount = $amount + $fee;
            
            // Vérifier le solde
            if ($client['solde'] < $totalAmount) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Solde insuffisant. Vous avez ' . number_format($client['solde'], 0, ',', ' ') . ' Ar'
                ]);
            }
            
            // Débiter l'émetteur
            $nouveauSoldeEmetteur = $client['solde'] - $totalAmount;
            $this->compteModel->update($client['id'], ['solde' => $nouveauSoldeEmetteur]);
            $this->compteModel->update($client['id'], [
                'total_transferts' => ($client['total_transferts'] ?? 0) + $amount,
                'total_frais_payes' => ($client['total_frais_payes'] ?? 0) + $fee
            ]);
            
            // Créditer le destinataire
            $nouveauSoldeDestinataire = $destinationClient['solde'] + $amount;
            $this->compteModel->update($destinationClient['id'], ['solde' => $nouveauSoldeDestinataire]);
            
            // Créer la transaction pour l'émetteur
            $this->transactionModel->insert([
                'client_id' => $client['client_id'],
                'type_operation' => 'transfert',
                'montant' => $amount,
                'frais_appliques' => $fee,
                'montant_net' => -$totalAmount,
                'solde_apres' => $nouveauSoldeEmetteur,
                'description' => "Transfert vers $destinationPhone",
                'reference' => 'TXN' . date('Ymd') . rand(100000, 999999)
            ]);

            // Créer la transaction pour le destinataire
            $this->transactionModel->insert([
                'client_id' => $destinationClient['client_id'],
                'type_operation' => 'depot',
                'montant' => $amount,
                'frais_appliques' => 0,
                'montant_net' => $amount,
                'solde_apres' => $nouveauSoldeDestinataire,
                'description' => "Transfert reçu de $phoneNumber",
                'reference' => 'TXN' . date('Ymd') . rand(100000, 999999)
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Transfert effectué avec succès',
                'new_balance' => $nouveauSoldeEmetteur,
                'fee' => $fee,
                'destination' => $destinationPhone
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur transfert: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }

    public function history()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $phoneNumber = $this->session->get('phone_number');
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        // Si le client n'existe pas
        if (!$client) {
            $client = [
                'client_id' => 'CLT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'nom' => $this->session->get('username') ?? 'Utilisateur',
                'phone_number' => $phoneNumber,
                'solde' => 100000
            ];
        }
        
        // Récupérer les transactions
        $type = $this->request->getGet('type');
        $transactions = [];
        
        if ($type) {
            $transactions = $this->transactionModel->getTransactionsByType($client['client_id'], $type);
        } else {
            $transactions = $this->transactionModel->getTransactionsClient($client['client_id']);
        }

        // Récupérer aussi toutes les transactions pour debug
        $allTransactions = $this->transactionModel->getAllTransactions();

        $data = [
            'title' => 'Mobile Money — Historique',
            'username' => $this->session->get('username'),
            'phone_number' => $phoneNumber,
            'client' => $client,
            'transactions' => $transactions,
            'all_transactions' => $allTransactions,
            'current_type' => $type,
            'total_transactions' => count($transactions)
        ];

        return view('client/history', $data);
    }

    // Route de debug
    public function debug()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $phoneNumber = $this->session->get('phone_number');
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        $allTransactions = $this->transactionModel->getAllTransactions();
        $clientTransactions = $this->transactionModel->getTransactionsClient($client['client_id'] ?? '');
        
        $data = [
            'title' => 'Debug',
            'client' => $client,
            'all_transactions' => $allTransactions,
            'client_transactions' => $clientTransactions,
            'username' => $this->session->get('username'),
            'phone_number' => $phoneNumber
        ];
        
        return view('client/debug', $data);
    }
}