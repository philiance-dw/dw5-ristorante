<?php

namespace App\Controllers;

use App\Database;
use App\Form;
use App\Models\Category;
use App\Router;
use PHPMailer\PHPMailer\PHPMailer;

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

    $pdo = Database::getConnection();

    if (empty($errors)) {
      // faire quelque chose avec les données ...

      //Create an instance; passing `true` enables exceptions
      $mail = new PHPMailer(true);

      //Server settings
      $mail->isSendMail();
      //Recipients
      $mail->setFrom($_POST['email'], "{$_POST['firstName']} {$_POST['lastName']}"); //Add a recipient
      $mail->addAddress('contact@ristorante.david-nogueira.dev', 'David');

      //Content
      $mail->isHTML(true); //Set email format to HTML
      $mail->Subject = 'Mail';
      $mail->Body = $_POST['message'];
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();

      Router::redirect('/contact');
      return;
    }

    $this->render('contact.twig', [
      'title' => 'Contact',
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }
}