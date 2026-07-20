<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    protected $request;
    protected $response;
    protected $logger;
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->request = $request;
        $this->response = $response;
        $this->logger = $logger;
        $this->session = \Config\Services::session();
        
        // Vérifier la connexion à la base de données
        if (ENVIRONMENT !== 'testing') {
            $this->checkDatabaseConnection();
        }
    }

    private function checkDatabaseConnection()
    {
        try {
            $db = \Config\Database::connect();
            $db->query('SELECT 1');
        } catch (\Exception $e) {
            log_message('error', 'Database connection error: ' . $e->getMessage());
            // Ne pas bloquer l'application
        }
    }
}