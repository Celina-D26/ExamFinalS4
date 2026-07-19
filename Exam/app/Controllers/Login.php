<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends Controller
{
    protected $session;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        // Vérifier si déjà connecté
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        // Afficher la page de connexion
        return view('login/index', [
            'title' => 'SysInfo — Connexion'
        ]);
    }

    public function authenticate()
    {
        // Règles de validation
        $rules = [
            'username' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return view('login/index', [
                'validation' => $this->validator,
                'title' => 'SysInfo — Connexion'
            ]);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Utilisateurs de test
        $validUsers = [
            'admin@sysinfo.com' => 'admin123',
            'user@sysinfo.com' => 'user123',
            'demo@sysinfo.com' => 'demo123'
        ];

        if (array_key_exists($username, $validUsers) && $validUsers[$username] === $password) {
            $this->session->set([
                'username' => $username,
                'email' => $username,
                'logged_in' => true,
                'user_name' => $this->getUserName($username)
            ]);

            return redirect()->to('/dashboard');
        }

        return view('login/index', [
            'error' => 'Email ou mot de passe incorrect',
            'title' => 'SysInfo — Connexion'
        ]);
    }

    private function getUserName($email)
    {
        $names = [
            'admin@sysinfo.com' => 'Admin Sys',
            'user@sysinfo.com' => 'Utilisateur Test',
            'demo@sysinfo.com' => 'Démo Compte'
        ];
        return $names[$email] ?? 'Utilisateur';
    }

    public function logout()
    {
        // Détruire la session
        $this->session->destroy();
        
        // Rediriger vers la page de connexion
        return redirect()->to('/login');
    }
}