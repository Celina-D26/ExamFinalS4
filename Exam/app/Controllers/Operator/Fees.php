<?php

namespace App\Controllers\Operator;

use CodeIgniter\Controller;
use App\Models\FeeModel;

class Fees extends Controller
{
    protected $session;
    protected $feeModel;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['url', 'form']);
        $this->session = \Config\Services::session();
        $this->feeModel = new FeeModel();
    }

    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        try {
            $fees = $this->feeModel->getAllFees();
            $groupedFees = $this->feeModel->getAllFeesGrouped();
        } catch (\Exception $e) {
            $fees = [];
            $groupedFees = [];
            log_message('error', 'Erreur lors de la récupération des frais: ' . $e->getMessage());
        }
        
        $data = [
            'title' => 'Mobile Money — Gestion des frais',
            'username' => $this->session->get('username') ?? 'Utilisateur',
            'phone_number' => $this->session->get('phone_number') ?? '',
            'fees' => $fees,
            'grouped_fees' => $groupedFees
        ];

        return view('operator/fees', $data);
    }

    public function create()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        $rules = [
            'operation_type' => 'required|in_list[withdrawal,transfer]',
            'min_amount' => 'required|numeric|greater_than[0]',
            'max_amount' => 'required|numeric|greater_than[min_amount]',
            'fee_type' => 'required|in_list[fixed,percentage]',
            'fee_value' => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            $data = [
                'operation_type' => $this->request->getPost('operation_type'),
                'min_amount' => $this->request->getPost('min_amount'),
                'max_amount' => $this->request->getPost('max_amount'),
                'fee_type' => $this->request->getPost('fee_type'),
                'fee_value' => $this->request->getPost('fee_value'),
                'is_active' => 1
            ];

            $this->feeModel->insert($data);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Barème de frais créé avec succès'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        try {
            $fee = $this->feeModel->find($id);
            if (!$fee) {
                return $this->response->setJSON(['success' => false, 'message' => 'Barème non trouvé']);
            }

            $this->feeModel->delete($id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Barème supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }

    public function toggleStatus($id)
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        try {
            $fee = $this->feeModel->find($id);
            if (!$fee) {
                return $this->response->setJSON(['success' => false, 'message' => 'Barème non trouvé']);
            }

            $newStatus = $fee['is_active'] ? 0 : 1;
            $this->feeModel->update($id, ['is_active' => $newStatus]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Statut mis à jour',
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ]);
        }
    }

    public function getFeeStructure()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        try {
            $fees = $this->feeModel->getAllFeesGrouped();
            return $this->response->setJSON([
                'success' => true,
                'data' => $fees
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }
}