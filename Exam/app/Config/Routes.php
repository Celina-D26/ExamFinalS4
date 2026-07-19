<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

// IMPORTANT : Définir Login comme contrôleur par défaut
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');  // ← C'est Login ici !
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Routes d'authentification
$routes->get('/', 'Login::index');        // ← Page d'accueil = Login
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('logout', 'Login::logout');

// Routes protégées
$routes->get('dashboard', 'Dashboard::index');
$routes->get('users', 'Users::list');
$routes->get('form', 'Form::index');

// Si vous voulez que toutes les autres routes soient protégées
// $routes->get('(:any)', 'Dashboard::index/$1');