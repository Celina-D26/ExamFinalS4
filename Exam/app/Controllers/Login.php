<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends Controller
{
    protected $session;
    protected $validation;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
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
            'username' => 'required|min_length[2]|max_length[50]',
            'phone' => 'required|min_length[8]|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return view('login/index', [
                'validation' => $this->validator,
                'title' => 'SysInfo — Connexion'
            ]);
        }

        $username = trim($this->request->getPost('username'));
        $phoneNumber = $this->cleanPhoneNumber($this->request->getPost('phone'));

        $userModel = new UserModel();

        try {
            $user = $userModel->findUser($username, $phoneNumber);
            
            if ($user) {
                $userModel->updateLoginInfo($user['id']);
                $user = $userModel->find($user['id']);

                $this->session->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'phone_number' => $user['phone_number'],
                    'email' => $user['email'] ?? '',
                    'logged_in' => true
                ]);

                return redirect()->to('/dashboard');
            }

            $newUser = $userModel->createUser($username, $phoneNumber);

            if ($newUser) {
                $this->session->set([
                    'user_id' => $newUser['id'],
                    'username' => $newUser['username'],
                    'phone_number' => $newUser['phone_number'],
                    'email' => $newUser['email'] ?? '',
                    'logged_in' => true
                ]);

                return redirect()->to('/dashboard');
            }

            return view('login/index', [
                'error' => 'Erreur lors de la création du compte',
                'title' => 'SysInfo — Connexion'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Erreur login: ' . $e->getMessage());
            
            return view('login/index', [
                'error' => 'Erreur de connexion. Veuillez réessayer.',
                'title' => 'SysInfo — Connexion'
            ]);
        }
    }

    private function cleanPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        
        return $phone;
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}