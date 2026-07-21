<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
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
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'SysInfo — Tableau de bord',
            'username' => $this->session->get('username'),
            'phone_number' => $this->session->get('phone_number')
        ];

        return view('dashboard/index', $data);
    }
}