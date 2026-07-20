<?php

namespace App\Controllers;

use App\Models\PrefixeModel;

class PrefixeController extends BaseController
{
    protected $prefixeModel;

    public function __construct()
    {
        $this->prefixeModel = new PrefixeModel();
    }

    public function index()
    {
        $data = [
            'prefixes' => $this->prefixeModel->findAll(),
            'title' => 'Configuration des Préfixes',
        ];
        return view('prefixes/index', $data);
    }

    public function ajouter()
    {
        $rules = [
            'prefixe' => 'required|min_length[2]|max_length[5]|is_unique[prefixes.prefixe]',
            'operateur' => 'required|min_length[2]|max_length[50]',
            'pays' => 'required|min_length[2]|max_length[50]',
            'commission' => 'required|numeric|greater_than_equal[0]|less_than_equal[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'prefixe' => $this->request->getPost('prefixe'),
            'operateur' => $this->request->getPost('operateur'),
            'pays' => $this->request->getPost('pays'),
            'commission' => $this->request->getPost('commission'),
            'est_actif' => $this->request->getPost('est_actif') ? 1 : 0,
        ];

        $this->prefixeModel->insert($data);
        return redirect()->to('/prefixes')->with('success', 'Préfixe ajouté avec succès !');
    }

    public function modifier($id)
    {
        $prefixe = $this->prefixeModel->find($id);
        if (!$prefixe) {
            return redirect()->to('/prefixes')->with('error', 'Préfixe non trouvé');
        }

        $data = [
            'prefixe' => $prefixe,
            'title' => 'Modifier le Préfixe',
        ];

        return view('prefixes/edit', $data);
    }

    public function update($id)
    {
        // Vérifier si le préfixe existe
        $prefixe = $this->prefixeModel->find($id);
        if (!$prefixe) {
            return redirect()->to('/prefixes')->with('error', 'Préfixe non trouvé');
        }

        $rules = [
            'prefixe' => 'required|min_length[2]|max_length[5]',
            'operateur' => 'required|min_length[2]|max_length[50]',
            'pays' => 'required|min_length[2]|max_length[50]',
            'commission' => 'required|numeric|greater_than_equal[0]|less_than_equal[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'prefixe' => $this->request->getPost('prefixe'),
            'operateur' => $this->request->getPost('operateur'),
            'pays' => $this->request->getPost('pays'),
            'commission' => $this->request->getPost('commission'),
            'est_actif' => $this->request->getPost('est_actif') ? 1 : 0,
        ];

        $this->prefixeModel->update($id, $data);
        return redirect()->to('/prefixes')->with('success', 'Préfixe modifié avec succès !');
    }

    public function supprimer($id)
    {
        $prefixe = $this->prefixeModel->find($id);
        if (!$prefixe) {
            return redirect()->to('/prefixes')->with('error', 'Préfixe non trouvé');
        }

        $this->prefixeModel->delete($id);
        return redirect()->to('/prefixes')->with('success', 'Préfixe supprimé avec succès !');
    }

    public function toggleActif($id)
    {
        $prefixe = $this->prefixeModel->find($id);
        if (!$prefixe) {
            return $this->response->setJSON(['success' => false, 'message' => 'Préfixe non trouvé']);
        }

        $newStatus = $prefixe['est_actif'] == 1 ? 0 : 1;
        $this->prefixeModel->update($id, ['est_actif' => $newStatus]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Statut modifié avec succès',
            'new_status' => $newStatus
        ]);
    }
}