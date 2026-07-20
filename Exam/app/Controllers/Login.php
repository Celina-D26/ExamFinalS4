<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends Controller
{
    protected $session;
    protected $userModel;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('login/index', [
            'title' => 'SysInfo — Connexion'
        ]);
    }

    public function authenticate()
    {
        $rules = [
            'phone' => 'required|min_length[8]|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return view('login/index', [
                'validation' => $this->validator,
                'title' => 'SysInfo — Connexion'
            ]);
        }

        $phoneNumber = $this->request->getPost('phone');
        
        // Nettoyer le numéro de téléphone
        $phoneNumber = $this->cleanPhoneNumber($phoneNumber);
        
        // Rechercher ou créer l'utilisateur
        $user = $this->userModel->findOrCreateByPhone($phoneNumber);
        
        if ($user) {
            $this->session->set([
                'user_id' => $user['id'],
                'phone_number' => $user['phone_number'],
                'user_name' => $user['name'] ?? 'Utilisateur',
                'email' => $user['email'] ?? '',
                'logged_in' => true
            ]);

            return redirect()->to('/dashboard');
        }

        return view('login/index', [
            'error' => 'Numéro de téléphone invalide',
            'title' => 'SysInfo — Connexion'
        ]);
    }

    private function cleanPhoneNumber($phone)
    {
        // Supprimer tous les caractères non numériques
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Ajouter le code pays si nécessaire (ex: 261 pour Madagascar)
        if (strlen($phone) === 9 && substr($phone, 0, 1) !== '0') {
            $phone = '261' . $phone;
        }
        
        return $phone;
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}