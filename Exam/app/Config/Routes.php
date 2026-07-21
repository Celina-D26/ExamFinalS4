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

// Dashboard principal
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

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

// Routes opérateur - Gestion des préfixes
$routes->get('prefixes', 'PrefixeController::index', ['filter' => 'auth']);
$routes->post('prefixes/ajouter', 'PrefixeController::ajouter', ['filter' => 'auth']);
$routes->get('prefixes/modifier/(:num)', 'PrefixeController::modifier/$1', ['filter' => 'auth']);
$routes->post('prefixes/update/(:num)', 'PrefixeController::update/$1', ['filter' => 'auth']);
$routes->get('prefixes/supprimer/(:num)', 'PrefixeController::supprimer/$1', ['filter' => 'auth']);
$routes->post('prefixes/toggle/(:num)', 'PrefixeController::toggleActif/$1', ['filter' => 'auth']);

// Routes opérateur - Gestion des gains
$routes->get('gains', 'GainsController::index', ['filter' => 'auth']);
$routes->get('gains/montants', 'GainsController::montantsOperateurs', ['filter' => 'auth']);
$routes->get('gains/export-csv', 'GainsController::exportCsv', ['filter' => 'auth']);
$routes->get('gains/export-montants-csv', 'GainsController::exportMontantsCsv', ['filter' => 'auth']);

// Routes pour les barèmes
$routes->get('frais/baremes', 'FraisController::getBaremesAjax', ['filter' => 'auth']);
$routes->get('frais', 'FraisController::index', ['filter' => 'auth']);
$routes->post('frais/simuler', 'FraisController::simuler', ['filter' => 'auth']);

// Routes opérateur - Comptes
$routes->get('comptes', 'ComptesController::index', ['filter' => 'auth']);

// Routes pour les opérations
$routes->post('client/transfer', 'Client\Operations::transferSimple');