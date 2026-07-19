<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Users extends Controller
{
    protected $session;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['url']);
        $this->session = \Config\Services::session();
    }

    public function list()
    {
        // Vérifier l'authentification
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Données factices pour la liste
        $users = [
            [
                'id' => 1,
                'name' => 'Andry Rakoto',
                'email' => 'andry.rakoto@si.mg',
                'matricule' => 'USR-0041',
                'role' => 'Administrateur',
                'department' => 'DSI',
                'last_login' => '2026-04-29 08:12',
                'status' => 'Actif'
            ],
            [
                'id' => 2,
                'name' => 'Fanja Razafy',
                'email' => 'fanja.razafy@si.mg',
                'matricule' => 'USR-0042',
                'role' => 'Gestionnaire',
                'department' => 'Finance',
                'last_login' => '2026-04-28 17:45',
                'status' => 'Actif'
            ],
            [
                'id' => 3,
                'name' => 'Hery Ranaivo',
                'email' => 'hery.ranaivo@si.mg',
                'matricule' => 'USR-0043',
                'role' => 'Auditeur',
                'department' => 'RH',
                'last_login' => '2026-04-25 10:00',
                'status' => 'Inactif'
            ],
            [
                'id' => 4,
                'name' => 'Lalao Rabenja',
                'email' => 'lalao.rabenja@si.mg',
                'matricule' => 'USR-0044',
                'role' => 'Opérateur',
                'department' => 'Commercial',
                'last_login' => '2026-04-29 09:30',
                'status' => 'Actif'
            ],
            [
                'id' => 5,
                'name' => 'Miora Tsarafidy',
                'email' => 'miora.tsarafidy@si.mg',
                'matricule' => 'USR-0045',
                'role' => 'Gestionnaire',
                'department' => 'DSI',
                'last_login' => '—',
                'status' => 'Suspendu'
            ],
            [
                'id' => 6,
                'name' => 'Rodin Nomenjanahary',
                'email' => 'rodin.n@si.mg',
                'matricule' => 'USR-0046',
                'role' => 'Administrateur',
                'department' => 'DSI',
                'last_login' => '2026-04-29 07:55',
                'status' => 'Actif'
            ]
        ];

        return view('users/list', [
            'users' => $users,
            'title' => 'SysInfo — Utilisateurs',
            'user_name' => $this->session->get('user_name')
        ]);
    }
}