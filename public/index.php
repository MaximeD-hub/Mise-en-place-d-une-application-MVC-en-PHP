<?php
/**
 * Point d'entrée de l'application
 * 
 * @package Public
 */

// Charger la configuration
require_once __DIR__ . '/../config/config.php';

use App\Core\Router;

// Créer le routeur
$router = new Router();

// Routes publiques
$router->get('/', 'TrajetController@index');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Routes utilisateur authentifié
$router->get('/trajet/create', 'TrajetController@create');
$router->post('/trajet/store', 'TrajetController@store');
$router->get('/trajet/edit/{id}', 'TrajetController@edit');
$router->post('/trajet/update/{id}', 'TrajetController@update');
$router->post('/trajet/delete/{id}', 'TrajetController@delete');
$router->get('/trajet/details/{id}', 'TrajetController@details');

// Routes admin
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/users', 'AdminController@listUsers');
$router->get('/admin/trajets', 'AdminController@listTrajets');
$router->post('/admin/trajet/delete/{id}', 'AdminController@deleteTrajet');

// Agences (admin)
$router->get('/admin/agences', 'AgenceController@index');
$router->get('/admin/agence/create', 'AgenceController@create');
$router->post('/admin/agence/store', 'AgenceController@store');
$router->get('/admin/agence/edit/{id}', 'AgenceController@edit');
$router->post('/admin/agence/update/{id}', 'AgenceController@update');
$router->post('/admin/agence/delete/{id}', 'AgenceController@delete');

// Dispatcher
$router->dispatch();