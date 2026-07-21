<?php

namespace App\Controllers\Operator;

use CodeIgniter\Controller;
use App\Models\ClientModel;

class Clients extends Controller
{
    protected $session;
    protected $clientModel;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['url']);
        $this->session = \Config\Services::session();
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        // Vérifier l'authentification
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Récupérer tous les clients avec leurs utilisateurs
        try {
            $clients = $this->clientModel->getAllClientsWithUsers();
        } catch (\Exception $e) {
            $clients = [];
            log_message('error', 'Erreur lors de la récupération des clients: ' . $e->getMessage());
        }
        
        $data = [
            'title' => 'Mobile Money — Clients',
            'username' => $this->session->get('username') ?? 'Utilisateur',
            'phone_number' => $this->session->get('phone_number') ?? '',
            'clients' => $clients
        ];

        return view('operator/clients', $data);
    }

    public function view($id)
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        try {
            $client = $this->clientModel->getClientWithUser($id);
            if (!$client) {
                return redirect()->to('/operator/clients')->with('error', 'Client non trouvé');
            }
        } catch (\Exception $e) {
            return redirect()->to('/operator/clients')->with('error', 'Erreur lors de la récupération du client');
        }
        
        $data = [
            'title' => 'Mobile Money — Détails client',
            'username' => $this->session->get('username') ?? 'Utilisateur',
            'phone_number' => $this->session->get('phone_number') ?? '',
            'client' => $client
        ];

        return view('operator/client_view', $data);
    }

    public function toggleStatus($id)
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        try {
            $client = $this->clientModel->find($id);
            if (!$client) {
                return $this->response->setJSON(['success' => false, 'message' => 'Client non trouvé']);
            }

            $newStatus = $client['is_active'] ? 0 : 1;
            $this->clientModel->update($id, ['is_active' => $newStatus]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ]);
        }
    }
}