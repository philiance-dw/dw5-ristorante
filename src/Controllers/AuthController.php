<?php

namespace App\Controllers;

use App\Form;
use App\Models\User;

class AuthController extends Controller {
  public function getConnection() {
    $this->render('auth/login.twig', ['title' => 'Connexion']);
  }

  public function postConnection() {
    $errors = Form::validate($_POST, true);

    if (empty($errors)) {

    }

    $this->render('auth/login.twig', [
      'title' => 'Connexion',
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }

  public function getSignup() {
    $this->render('auth/signup.twig', ['title' => 'Inscription']);
  }

  public function postSignup() {
    $errors = Form::validate($_POST);

    if (empty($errors)) {
      $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 14]);

      $user = new User();
      $user
        ->setFirstName($_POST['firstName'])
        ->setLastName($_POST['lastName'])
        ->setEmail($_POST['email'])
        ->setPassword($hashedPassword)
        ->setAddress($_POST['address'])
        ->setCity($_POST['city'])
        ->setCountry($_POST['country'])
        ->setPostalCode($_POST['postalCode'])
        ->setPhone($_POST['phone'])
        ->save();

      header('Location: /connexion');
    }

    $this->render('auth/signup.twig', [
      'title' => 'Inscription',
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }
}