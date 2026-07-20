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
            $nouveauSolde = $client['solde'] + $amount;
            $this->compteModel->update($client['id'], ['solde' => $nouveauSolde]);
            $this->compteModel->update($client['id'], [
                'total_depots' => ($client['total_depots'] ?? 0) + $amount
            ]);
            
            $this->transactionModel->enregistrerTransaction([
                'client_id' => $client['client_id'],
                'type_operation' => 'depot',
                'montant' => $amount,
                'frais_appliques' => 0,
                'commission' => 0,
                'montant_net' => $amount,
                'solde_apres' => $nouveauSolde,
                'include_fees' => 0,
                'is_multiple' => 0,
                'description' => 'Dépôt automatique'
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Dépôt effectué avec succès',
                'new_balance' => $nouveauSolde
            ]);
        } catch (\Exception $e) {
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

        $input = $this->request->getJSON(true);
        $amount = $input ? ($input['amount'] ?? 0) : $this->request->getPost('amount');
        $includeFees = $input ? ($input['include_fees'] ?? false) : ($this->request->getPost('include_fees') ?? false);
        
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
            $fee = $this->fraisModel->getFrais('retrait', $amount);
            
            if ($includeFees) {
                $totalAmount = $amount;
                $amountRecu = $amount - $fee;
            } else {
                $totalAmount = $amount + $fee;
                $amountRecu = $amount;
            }
            
            if ($client['solde'] < $totalAmount) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Solde insuffisant. Vous avez ' . number_format($client['solde'], 0, ',', ' ') . ' Ar'
                ]);
            }
            
            $nouveauSolde = $client['solde'] - $totalAmount;
            $this->compteModel->update($client['id'], ['solde' => $nouveauSolde]);
            $this->compteModel->update($client['id'], [
                'total_retraits' => ($client['total_retraits'] ?? 0) + $amount,
                'total_frais_payes' => ($client['total_frais_payes'] ?? 0) + $fee
            ]);
            
            $this->transactionModel->enregistrerTransaction([
                'client_id' => $client['client_id'],
                'type_operation' => 'retrait',
                'montant' => $amount,
                'frais_appliques' => $fee,
                'commission' => 0,
                'montant_net' => -$totalAmount,
                'solde_apres' => $nouveauSolde,
                'include_fees' => $includeFees ? 1 : 0,
                'is_multiple' => 0,
                'description' => 'Retrait' . ($includeFees ? ' (frais inclus)' : '')
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Retrait effectué avec succès',
                'new_balance' => $nouveauSolde,
                'fee' => $fee,
                'amount_received' => $amountRecu
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }

    public function transferSimple()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        $input = $this->request->getJSON(true);
        if ($input) {
            $amount = $input['amount'] ?? 0;
            $destinationPhone = $input['destination_phone'] ?? '';
            $includeFees = $input['include_fees'] ?? false;
        } else {
            $amount = $this->request->getPost('amount');
            $destinationPhone = $this->request->getPost('destination_phone');
            $includeFees = $this->request->getPost('include_fees') ?? false;
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
            
            $fee = $this->fraisModel->getFrais('transfert', $amount);
            
            if ($includeFees) {
                $totalAmount = $amount;
                $amountRecu = $amount - $fee;
            } else {
                $totalAmount = $amount + $fee;
                $amountRecu = $amount;
            }
            
            if ($client['solde'] < $totalAmount) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Solde insuffisant. Vous avez ' . number_format($client['solde'], 0, ',', ' ') . ' Ar'
                ]);
            }
            
            $nouveauSolde = $client['solde'] - $totalAmount;
            $this->compteModel->update($client['id'], ['solde' => $nouveauSolde]);
            $this->compteModel->update($client['id'], [
                'total_transferts' => ($client['total_transferts'] ?? 0) + $amount,
                'total_frais_payes' => ($client['total_frais_payes'] ?? 0) + $fee
            ]);
            
            $nouveauSoldeDest = $destinationClient['solde'] + $amountRecu;
            $this->compteModel->update($destinationClient['id'], ['solde' => $nouveauSoldeDest]);
            
            $this->transactionModel->enregistrerTransaction([
                'client_id' => $client['client_id'],
                'type_operation' => 'transfert',
                'montant' => $amount,
                'frais_appliques' => $fee,
                'commission' => 0,
                'montant_net' => -$totalAmount,
                'solde_apres' => $nouveauSolde,
                'include_fees' => $includeFees ? 1 : 0,
                'is_multiple' => 0,
                'destinations' => json_encode([$destinationPhone]),
                'description' => "Transfert vers $destinationPhone"
            ]);

            $this->transactionModel->enregistrerTransaction([
                'client_id' => $destinationClient['client_id'],
                'type_operation' => 'depot',
                'montant' => $amountRecu,
                'frais_appliques' => 0,
                'commission' => 0,
                'montant_net' => $amountRecu,
                'solde_apres' => $nouveauSoldeDest,
                'include_fees' => 0,
                'is_multiple' => 0,
                'description' => "Transfert reçu de $phoneNumber"
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Transfert effectué avec succès',
                'new_balance' => $nouveauSolde,
                'fee' => $fee,
                'amount_sent' => $amountRecu
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Envoi multiple vers plusieurs numéros
     */
    public function transferMultiple()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        // Récupérer les données POST
        $input = $this->request->getJSON(true);
        if ($input) {
            $amount = $input['amount'] ?? 0;
            $destinations = $input['destinations'] ?? [];
            $includeFees = $input['include_fees'] ?? false;
        } else {
            $amount = $this->request->getPost('amount');
            $destinations = $this->request->getPost('destinations');
            $includeFees = $this->request->getPost('include_fees') ?? false;
        }
        
        // Vérifier le montant
        if (!$amount || $amount <= 0) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Montant total invalide'
            ]);
        }

        // Vérifier les destinations
        if (empty($destinations) || !is_array($destinations)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Aucun destinataire valide'
            ]);
        }

        $phoneNumber = $this->session->get('phone_number');
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        if (!$client) {
            return $this->response->setJSON(['success' => false, 'message' => 'Client non trouvé']);
        }

        try {
            $nbDestinataires = count($destinations);
            $montantParPersonne = $amount / $nbDestinataires;
            
            // Vérifier chaque destinataire
            $destClients = [];
            foreach ($destinations as $destPhone) {
                $destClient = $this->compteModel->getClientByPhone($destPhone);
                if (!$destClient) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => "Le numéro $destPhone n'existe pas"
                    ]);
                }
                
                if ($destClient['client_id'] == $client['client_id']) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => "Vous ne pouvez pas vous transférer à vous-même ($destPhone)"
                    ]);
                }
                
                $destClients[] = $destClient;
            }
            
            // Calculer les frais (transfert même opérateur)
            $fee = $this->fraisModel->getFrais('transfert', $amount);
            
            // Gérer l'inclusion des frais
            if ($includeFees) {
                $totalAmount = $amount;
                $montantRecuParPersonne = $montantParPersonne - ($fee / $nbDestinataires);
            } else {
                $totalAmount = $amount + $fee;
                $montantRecuParPersonne = $montantParPersonne;
            }
            
            // Vérifier le solde
            if ($client['solde'] < $totalAmount) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Solde insuffisant. Vous avez ' . number_format($client['solde'], 0, ',', ' ') . ' Ar'
                ]);
            }
            
            // Débiter l'émetteur
            $nouveauSolde = $client['solde'] - $totalAmount;
            $this->compteModel->update($client['id'], ['solde' => $nouveauSolde]);
            $this->compteModel->update($client['id'], [
                'total_transferts' => ($client['total_transferts'] ?? 0) + $amount,
                'total_frais_payes' => ($client['total_frais_payes'] ?? 0) + $fee
            ]);
            
            // Créditer chaque destinataire
            foreach ($destClients as $i => $destClient) {
                $nouveauSoldeDest = $destClient['solde'] + $montantRecuParPersonne;
                $this->compteModel->update($destClient['id'], ['solde' => $nouveauSoldeDest]);
                
                $this->transactionModel->enregistrerTransaction([
                    'client_id' => $destClient['client_id'],
                    'type_operation' => 'depot',
                    'montant' => $montantRecuParPersonne,
                    'frais_appliques' => 0,
                    'commission' => 0,
                    'montant_net' => $montantRecuParPersonne,
                    'solde_apres' => $nouveauSoldeDest,
                    'include_fees' => 0,
                    'is_multiple' => 1,
                    'description' => "Transfert multiple reçu de $phoneNumber"
                ]);
            }

            // Transaction principale
            $this->transactionModel->enregistrerTransaction([
                'client_id' => $client['client_id'],
                'type_operation' => 'transfert',
                'montant' => $amount,
                'frais_appliques' => $fee,
                'commission' => 0,
                'montant_net' => -$totalAmount,
                'solde_apres' => $nouveauSolde,
                'include_fees' => $includeFees ? 1 : 0,
                'is_multiple' => 1,
                'destinations' => json_encode($destinations),
                'description' => "Envoi multiple vers " . $nbDestinataires . " numéros"
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Envoi multiple effectué avec succès vers ' . $nbDestinataires . ' destinataires',
                'new_balance' => $nouveauSolde,
                'fee' => $fee,
                'amount_per_person' => $montantRecuParPersonne,
                'nb_destinataires' => $nbDestinataires
            ]);
        } catch (\Exception $e) {
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
        
        if (!$client) {
            $client = [
                'client_id' => 'CLT' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'nom' => $this->session->get('username') ?? 'Utilisateur',
                'phone_number' => $phoneNumber,
                'solde' => 100000
            ];
        }
        
        $type = $this->request->getGet('type');
        $transactions = [];
        
        if ($type) {
            $transactions = $this->transactionModel->getTransactionsByType($client['client_id'], $type);
        } else {
            $transactions = $this->transactionModel->getTransactionsClient($client['client_id']);
        }

        $data = [
            'title' => 'Mobile Money — Historique',
            'username' => $this->session->get('username'),
            'phone_number' => $phoneNumber,
            'client' => $client,
            'transactions' => $transactions,
            'current_type' => $type,
            'total_transactions' => count($transactions)
        ];

        return view('client/history', $data);
    }
}