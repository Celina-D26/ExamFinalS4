// application/controllers/Dashboard.php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        // Vérifier si l'utilisateur est connecté
        if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $data['username'] = $this->session->userdata('username');
        $this->load->view('dashboard', $data);
    }
}