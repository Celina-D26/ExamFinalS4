<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Routes d'authentification
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('logout', 'Login::logout');

// Routes protégées
$routes->get('dashboard', 'Dashboard::index');
$routes->get('users', 'Users::list');

$routes->get('form', 'Form::index');

// frais
$routes->get('frais', 'FraisController::index');
$routes->post('frais/simuler', 'FraisController::simuler');
$routes->post('frais/enregistrer', 'FraisController::enregistrer');


// Routes pour les comptes clients
$routes->get('comptes', 'ComptesController::index');
$routes->get('comptes/detail/(:any)', 'ComptesController::detail/$1');
// Si vous voulez que toutes les autres routes soient protégées
// $routes->get('(:any)', 'Dashboard::index/$1');

