<?php

namespace App\Controllers\Operator;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        // Vérifier la session
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Données simples pour le test
        $data = [
            'title' => 'Mobile Money — Opérateur',
            'username' => session()->get('username') ?? 'Utilisateur',
            'phone_number' => session()->get('phone_number') ?? '',
            'total_clients' => 5,
            'total_transactions' => 42,
            'total_fees' => 12500,
            'clients' => [
                ['id' => 1, 'name' => 'Jean Dupont', 'phone' => '340000001', 'balance' => 150000, 'status' => 'Actif'],
                ['id' => 2, 'name' => 'Marie Martin', 'phone' => '340000002', 'balance' => 25000, 'status' => 'Actif'],
                ['id' => 3, 'name' => 'Pierre Ravel', 'phone' => '340000003', 'balance' => 7500, 'status' => 'Inactif'],
            ]
        ];

        return view('operator/dashboard', $data);
    }
}