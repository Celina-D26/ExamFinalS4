<?php

namespace App\Controllers;

use App\Models\EpargneModel;
use App\Models\CompteClientModel;

class EpargneController extends BaseController
{
    protected $epargneModel;
    protected $compteModel;

    public function __construct()
    {
        $this->epargneModel = new EpargneModel();
        $this->compteModel = new CompteClientModel();
    }

    /**
     * Dashboard épargne du client
     */
    public function index()
    {
        $session = session();
        $phoneNumber = $session->get('phone_number');
        
        // Récupérer le client
        $client = $this->compteModel->getClientByPhone($phoneNumber);
        
        if (!$client) {
            return redirect()->to('/client/dashboard')->with('error', 'Client non trouvé');
        }

        // Récupérer ou créer le compte épargne
        $epargne = $this->epargneModel->getEpargneByClient($client['client_id']);
        if (!$epargne) {
            $epargne = $this->epargneModel->createEpargne($client['client_id'], 0);
        }

        // Récupérer les statistiques
        $stats = $this->epargneModel->getStatsEpargne($client['client_id']);

        $data = [
            'title' => 'Mon Épargne',
            'username' => $session->get('username'),
            'phone_number' => $phoneNumber,
            'client' => $client,
            'epargne' => $epargne,
            'stats' => $stats
        ];

        return view('epargne/index', $data);
    }

    /**
     * Ajouter de l'argent à l'épargne
     */
    public function ajouter()
    {
        $session = session();
        $phoneNumber = $session->get('phone_number');
        $montant = (float) $this->request->getPost('montant');
        
        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide');
        }

        $client = $this->compteModel->getClientByPhone($phoneNumber);
        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        // Vérifier le solde du compte principal
        if ($client['solde'] < $montant) {
            return redirect()->back()->with('error', 'Solde insuffisant');
        }

        // Retirer du compte principal
        $nouveauSolde = $client['solde'] - $montant;
        $this->compteModel->update($client['id'], ['solde' => $nouveauSolde]);

        // Ajouter à l'épargne
        $this->epargneModel->ajouterEpargne($client['client_id'], $montant);

        // Enregistrer la transaction
        $transactionModel = new \App\Models\TransactionModel();
        $transactionModel->insert([
            'client_id' => $client['client_id'],
            'type_operation' => 'epargne',
            'montant' => $montant,
            'frais_appliques' => 0,
            'montant_net' => -$montant,
            'solde_apres' => $nouveauSolde,
            'description' => 'Dépôt vers épargne',
            'status' => 'complete',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/epargne')->with('success', 'Montant ajouté à l\'épargne avec succès !');
    }

    /**
     * Retirer de l'épargne
     */
    public function retirer()
    {
        $session = session();
        $phoneNumber = $session->get('phone_number');
        $montant = (float) $this->request->getPost('montant');
        
        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide');
        }

        $client = $this->compteModel->getClientByPhone($phoneNumber);
        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        // Retirer de l'épargne
        $result = $this->epargneModel->retirerEpargne($client['client_id'], $montant);
        if (!$result) {
            return redirect()->back()->with('error', 'Solde d\'épargne insuffisant');
        }

        // Ajouter au compte principal
        $nouveauSolde = $client['solde'] + $montant;
        $this->compteModel->update($client['id'], ['solde' => $nouveauSolde]);

        // Enregistrer la transaction
        $transactionModel = new \App\Models\TransactionModel();
        $transactionModel->insert([
            'client_id' => $client['client_id'],
            'type_operation' => 'epargne_retrait',
            'montant' => $montant,
            'frais_appliques' => 0,
            'montant_net' => $montant,
            'solde_apres' => $nouveauSolde,
            'description' => 'Retrait de l\'épargne',
            'status' => 'complete',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/epargne')->with('success', 'Retrait de l\'épargne effectué avec succès !');
    }

    /**
     * Configurer le pourcentage d'épargne
     */
    public function configurer()
    {
        $session = session();
        $phoneNumber = $session->get('phone_number');
        $pourcentage = (float) $this->request->getPost('pourcentage');
        
        if ($pourcentage < 0 || $pourcentage > 100) {
            return redirect()->back()->with('error', 'Pourcentage invalide (0-100)');
        }

        $client = $this->compteModel->getClientByPhone($phoneNumber);
        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        $this->epargneModel->updatePourcentage($client['client_id'], $pourcentage);

        return redirect()->to('/epargne')->with('success', 'Pourcentage d\'épargne mis à jour !');
    }

    /**
     * Activer/Désactiver l'épargne
     */
    public function toggle()
    {
        $session = session();
        $phoneNumber = $session->get('phone_number');

        $client = $this->compteModel->getClientByPhone($phoneNumber);
        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        $epargne = $this->epargneModel->getEpargneByClient($client['client_id']);
        if (!$epargne) {
            return redirect()->back()->with('error', 'Compte épargne non trouvé');
        }

        $newStatus = $epargne['epargne_active'] == 1 ? 0 : 1;
        $this->epargneModel->toggleEpargne($client['client_id'], $newStatus == 1);

        $message = $newStatus == 1 ? 'Épargne activée' : 'Épargne désactivée';
        return redirect()->to('/epargne')->with('success', $message);
    }

    /**
     * Admin - Liste des comptes épargne
     */
    public function adminListe()
    {
        $data = [
            'epargnes' => $this->epargneModel->getAllEpargneWithClients(),
            'total_epargne' => $this->epargneModel->getTotalEpargneGlobal(),
            'title' => 'Gestion des Épargnes'
        ];

        return view('epargne/admin_liste', $data);
    }
}