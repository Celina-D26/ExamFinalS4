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
    $routes->post('operations/transferSimple', 'Client\Operations::transferSimple');
    $routes->post('operations/transferMultiple', 'Client\Operations::transferMultiple');
    $routes->get('history', 'Client\Operations::history');
});

// Routes pour les barèmes
$routes->get('frais/baremes', 'FraisController::getBaremesAjax', ['filter' => 'auth']);
$routes->get('frais', 'FraisController::index', ['filter' => 'auth']);

// Routes opérateur
$routes->get('comptes', 'ComptesController::index', ['filter' => 'auth']);

// Redirection
$routes->get('dashboard', 'Client\Dashboard::index', ['filter' => 'auth']);