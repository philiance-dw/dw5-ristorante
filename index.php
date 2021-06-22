<?php

session_start();

// on vient inclure l'autoload de composer pour avoir accès au chargement automatiques des class (perso/externe)
require_once __DIR__ . '/vendor/autoload.php';

use App\Router;

$router = new Router();

// on définit nos routes publiques
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

// on définit nos routes admin
$router->setPath("/admin")
  ->get('', 'AdminController#redirectHome')
  ->get('/accueil', 'AdminController#getHome')
  ->get('/categories', 'CategoryController#getCategories')
  ->get('/categories/ajouter', 'CategoryController#getAddCategory')
  ->get('/categories/modifier/[i:id]', 'CategoryController#getEditCategory')
  ->get('/categories/supprimer/[i:id]', 'CategoryController#deleteCategory')
  ->get('/produits', 'ProductController#getProducts')
  ->get('/produits/ajouter', 'ProductController#getAddProduct')
  ->get('/produits/modifier/[i:id]', 'ProductController#getEditProduct')
  ->get('/produits/supprimer/[i:id]', 'ProductController#deleteProduct')
  ->get('/plats', 'DishController#getDishes');

$router->post('/categories/ajouter', 'CategoryController#postAddCategory')
  ->post('/categories/modifier/[i:id]', 'CategoryController#postEditCategory')
  ->post("/produits/ajouter", 'ProductController#postAddProduct')
  ->post("/produits/modifier/[i:id]", 'ProductController#postEditProduct');

// on lance le router
$router->run();