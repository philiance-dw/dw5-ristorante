<?php

namespace App\Controllers;

use App\Form;
use App\Models\Category;
use App\Router;

class MainController extends Controller {
  // renvoi la page d'accueil
  public function getHome() {
    $this->render('home.twig', ['title' => 'Accueil']);
  }

  public function getAbout() {
    $this->render('about.twig', ['title' => 'A propos']);
  }

  public function getMenu() {
    // on recupere les categories et les plats associés
    $dishes = Category::getDishes();

    $this->render('menu.twig', ['title' => 'Menu', 'dishes' => $dishes]);
  }

  public function getContact() {
    $this->render('contact.twig', ['title' => 'Contact']);
  }

  public function postContact() {
    // on valide la firmulaire en utilisant notre class Form
    $errors = Form::validate($_POST);

    if (empty($errors)) {
      // faire quelque chose avec les données ...
      Router::redirect('/');
      return;
    }

    $this->render('contact.twig', [
      'title' => 'Contact',
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }

  public function get404() {
    $this->render('404.twig', ['title' => 'Page introuvable']);
  }
}