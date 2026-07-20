<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');

// Routes publiques
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('logout', 'Login::logout');

// Routes client
$routes->group('client', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Client\Dashboard::index');
    $routes->get('operations', 'Client\Operations::index');
    $routes->post('operations/deposit', 'Client\Operations::deposit');
    $routes->post('operations/withdrawal', 'Client\Operations::withdrawal');
    $routes->post('operations/transfer', 'Client\Operations::transfer');
    $routes->get('history', 'Client\Operations::history');
});

// Route pour récupérer les barèmes (pour le calcul des frais)
$routes->get('frais/baremes', 'FraisController::getBaremesAjax', ['filter' => 'auth']);

// Routes opérateur (existantes)
$routes->get('comptes', 'ComptesController::index', ['filter' => 'auth']);
$routes->get('frais', 'FraisController::index', ['filter' => 'auth']);
$routes->post('frais/simuler', 'FraisController::simuler', ['filter' => 'auth']);
$routes->post('frais/enregistrer', 'FraisController::enregistrer', ['filter' => 'auth']);

// Redirection
$routes->get('dashboard', 'Client\Dashboard::index', ['filter' => 'auth']);
// Route de debug (à supprimer après)
$routes->get('client/debug', 'Client\Operations::debug', ['filter' => 'auth']);