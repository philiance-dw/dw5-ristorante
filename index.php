<?php

session_start();

// on vient inclure l'autoload de composer pour avoir accès au chargement automatiques des class (perso/externe)
require_once __DIR__ . '/vendor/autoload.php';

use App\Router;

$router = new Router();

// on définit nos routes
$router->get('/', 'MainController#getHome')
  ->get('/about', 'MainController#getAbout')
  ->get('/menu', 'MainController#getMenu')
  ->get('/contact', 'MainController#getContact')
  ->get('/connexion', 'AuthController#getConnection')
  ->get('/deconnexion', 'AuthController#logout')
  ->get('/inscription', 'AuthController#getSignup');

$router->post('/contact', 'MainController#postContact')
  ->post('/connexion', 'AuthController#postConnection')
  ->post('/inscription', 'AuthController#postSignup');

// on lance le router
$router->run();