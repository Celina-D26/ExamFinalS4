<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Login extends Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Charger les helpers
        helper(['form', 'url']);
        
        // Charger les services
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        // Si l'utilisateur est déjà connecté, le rediriger vers le dashboard
        if ($this->session->get('logged_in')) {
            return redirect()->to('dashboard');
        }

        $data['title'] = 'Connexion - SysInfo';
        return view('login_view', $data);
    }

    public function authenticate()
    {
        // Configuration des règles de validation
        $rules = [
            'username' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            // En cas d'erreur, on revient à la page de connexion avec les erreurs
            return view('login_view', [
                'validation' => $this->validator
            ]);
        }

        // Données de test (statique)
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Simulation de validation sans base de données
        if ($this->validateUser($username, $password)) {
            // Création de la session
            $sessionData = [
                'username' => $username,
                'email' => $username,
                'logged_in' => true
            ];
            $this->session->set($sessionData);

            // Redirection vers le tableau de bord
            return redirect()->to('dashboard');
        }

        // En cas d'échec, on affiche un message d'erreur
        return view('login_view', [
            'error' => 'Email ou mot de passe incorrect'
        ]);
    }

    private function validateUser($username, $password)
    {
        // Validation statique avec des identifiants de test
        $validUsers = [
            'admin@sysinfo.com' => 'admin123',
            'user@sysinfo.com' => 'user123',
            'demo@sysinfo.com' => 'demo123'
        ];

        // Vérification si l'utilisateur existe dans le tableau de test
        if (array_key_exists($username, $validUsers)) {
            return $validUsers[$username] === $password;
        }

        return false;
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('login');
    }

    public function dashboard()
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->session->get('logged_in')) {
            return redirect()->to('login');
        }

        $data['username'] = $this->session->get('username');
        return view('dashboard_view', $data);
    }
}