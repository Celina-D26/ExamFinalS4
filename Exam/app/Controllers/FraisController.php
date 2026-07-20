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
        // Récupérer l'utilisateur connecté pour le sidebar
        $userData = $this->session->get('user_data');
        $username = $userData['username'] ?? 'Utilisateur';
        $phoneNumber = $userData['phone_number'] ?? '';

        $data = [
            'baremes'     => $this->fraisModel->findAll(),
            'gainsTotaux' => $this->fraisModel->getGainsTotaux(),
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
     * Action pour calculer les frais en fonction d'une opération et d'un montant
     */
    public function simuler()
    {
        $typeOperation = $this->request->getPost('type_operation');
        $montant       = (float) $this->request->getPost('montant');

        $frais = $this->fraisModel->getFrais($typeOperation, $montant);

        // Récupérer l'utilisateur connecté pour le sidebar
        $userData = $this->session->get('user_data');
        $username = $userData['username'] ?? 'Utilisateur';
        $phoneNumber = $userData['phone_number'] ?? '';

        $data = [
            'baremes'            => $this->fraisModel->findAll(),
            'gainsTotaux'        => $this->fraisModel->getGainsTotaux(),
            'fraisCalcule'       => $frais,
            'montantTeste'       => $montant,
            'typeOperationTeste' => $typeOperation,
            'username' => $username,
            'phone_number' => $phoneNumber,
            'title' => 'Gestion des Barèmes de Frais'
        ];

        return view('frais/index', $data);
    }

    /**
     * Action pour ajouter ou modifier une tranche de frais
     */
    public function enregistrer()
    {
        $id = $this->request->getPost('id');

        $rulesData = [
            'type_operation' => $this->request->getPost('type_operation'),
            'montant_min'    => $this->request->getPost('montant_min'),
            'montant_max'    => $this->request->getPost('montant_max'),
            'frais'          => $this->request->getPost('frais'),
        ];

        if ($id) {
            $this->fraisModel->update($id, $rulesData);
            $message = "Barème mis à jour avec succès !";
        } else {
            $this->fraisModel->insert($rulesData);
            $message = "Nouveau barème ajouté !";
        }

        return redirect()->to('/frais')->with('success', $message);
    }

    /**
     * Récupère les barèmes pour les requêtes AJAX
     */
    public function getBaremesAjax()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        try {
            $baremes = $this->fraisModel->findAll();
            return $this->response->setJSON([
                'success' => true,
                'data' => $baremes
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}