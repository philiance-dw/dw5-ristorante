<?php

namespace App\Controllers;

class ErrorController extends Controller {
  public function get404() {
    $this->render('404.twig', ['title' => 'Page introuvable']);
  }

  public function get500(string $message) {
    $this->render('500.twig', ['title' => 'Erreur serveur', 'errorMessage' => $message]);
  }
}