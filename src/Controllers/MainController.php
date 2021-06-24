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
    $categories = Category::find();

    foreach ($categories as $index => $category) {
      // on recupere les categories et les plats associés
      $category->populateDishes();

      if (empty($category->getDishes())) {
        unset($categories[$index]);
      }
    }

    $this->render('menu.twig', ['title' => 'Menu', 'categories' => $categories]);
  }

  public function getContact() {
    $this->render('contact.twig', ['title' => 'Contact']);
  }

  public function getSignature() {
    $this->render('signature.twig');
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
}