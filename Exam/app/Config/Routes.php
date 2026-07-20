<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');

// ============================================
// ROUTES PUBLIQUES (non protégées)
// ============================================
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('logout', 'Login::logout');

// ============================================
// ROUTES CLIENT (protégées par auth)
// ============================================
$routes->group('client', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Client\Dashboard::index');
    $routes->get('operations', 'Client\Operations::index');
    $routes->post('operations/deposit', 'Client\Operations::deposit');
    $routes->post('operations/withdrawal', 'Client\Operations::withdrawal');
    $routes->post('operations/transfer', 'Client\Operations::transfer');
    $routes->get('history', 'Client\Operations::history');
});

// ============================================
// ROUTES ADMIN/OPÉRATEUR (protégées par auth)
// ============================================
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Dashboard (redirige vers client/dashboard)
    $routes->get('dashboard', 'Client\Dashboard::index');
    
    // Frais
    $routes->get('frais', 'FraisController::index');
    $routes->post('frais/simuler', 'FraisController::simuler');
    $routes->post('frais/enregistrer', 'FraisController::enregistrer');
    $routes->get('frais/baremes', 'FraisController::getBaremesAjax');
    $routes->get('frais/direct', 'FraisController::getBaremesDirect');
    
    // Comptes clients
    $routes->get('comptes', 'ComptesController::index');
    $routes->get('comptes/detail/(:any)', 'ComptesController::detail/$1');
    
    // Préfixes
    $routes->get('prefixes', 'PrefixeController::index');
    $routes->post('prefixes/ajouter', 'PrefixeController::ajouter');
    $routes->get('prefixes/modifier/(:num)', 'PrefixeController::modifier/$1');
    $routes->post('prefixes/update/(:num)', 'PrefixeController::update/$1');
    $routes->get('prefixes/supprimer/(:num)', 'PrefixeController::supprimer/$1');
    $routes->post('prefixes/toggle/(:num)', 'PrefixeController::toggleActif/$1');
    
    // Gains
    $routes->get('gains', 'GainsController::index');
    $routes->get('gains/montants', 'GainsController::montantsOperateurs');
    $routes->get('gains/export-csv', 'GainsController::exportCsv');
    $routes->get('gains/export-montants-csv', 'GainsController::exportMontantsCsv');
    
    // Utilisateurs (si besoin)
    $routes->get('users', 'Users::list');
    $routes->get('form', 'Form::index');
});