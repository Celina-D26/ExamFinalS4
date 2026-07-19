<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Form extends Controller
{
    protected $session;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['url']);
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Vérifier l'authentification
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('form/index', [
            'title' => 'SysInfo — Formulaire utilisateur',
            'user_name' => $this->session->get('user_name')
        ]);
    }
}