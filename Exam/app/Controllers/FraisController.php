<?php

namespace App\Controllers;

use App\Models\FraisBaremeModel;

class FraisController extends BaseController
{
    protected $fraisModel;
    protected $session;

    public function __construct()
    {
        $this->fraisModel = new FraisBaremeModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Page principale : Liste des barèmes et simulateur
     */
    public function index()
    {
        // Vérifier l'authentification
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Récupérer l'utilisateur connecté
        $username = $this->session->get('username') ?? 'Utilisateur';
        $phoneNumber = $this->session->get('phone_number') ?? '';

        // Récupérer tous les barèmes
        $baremes = $this->fraisModel->findAll();

        $data = [
            'baremes' => $baremes,
            'gainsTotaux' => 0,
            'fraisCalcule' => null,
            'montantTeste' => null,
            'typeOperationTeste' => null,
            'username' => $username,
            'phone_number' => $phoneNumber,
            'title' => 'Gestion des Barèmes de Frais'
        ];

        return view('frais/index', $data);
    }

    /**
     * Récupère les barèmes pour les requêtes AJAX
     */
    public function getBaremesAjax()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Non authentifié'
            ]);
        }

        try {
            $baremes = $this->fraisModel->findAll();
            
            if (empty($baremes)) {
                // Barèmes par défaut
                $baremes = [
                    ['id' => 1, 'type_operation' => 'retrait', 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50],
                    ['id' => 2, 'type_operation' => 'retrait', 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 75],
                    ['id' => 3, 'type_operation' => 'retrait', 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100],
                    ['id' => 4, 'type_operation' => 'retrait', 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 150],
                    ['id' => 5, 'type_operation' => 'retrait', 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 200],
                    ['id' => 6, 'type_operation' => 'retrait', 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 300],
                    ['id' => 7, 'type_operation' => 'transfert', 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 25],
                    ['id' => 8, 'type_operation' => 'transfert', 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50],
                    ['id' => 9, 'type_operation' => 'transfert', 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 75],
                    ['id' => 10, 'type_operation' => 'transfert', 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 100],
                ];
            }
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $baremes,
                'count' => count($baremes)
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}