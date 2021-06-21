<?php

namespace App\Controllers;

use App\Router;

class AdminController extends Controller {
  public function redirectHome() {
    Router::redirect('/admin/accueil');
  }

  public function getHome() {
    $this->render('admin/home.twig', ['title' => 'Accueil']);
  }

}