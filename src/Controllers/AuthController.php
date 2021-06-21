<?php

namespace App\Controllers;

use App\Form;
use App\Models\User;
use App\Router;

class AuthController extends Controller {
  public function getConnection() {
    Router::redirectLoggedUserToHome();
    $this->render('auth/login.twig', [
      'title' => 'Connexion',
    ]);
  }

  public function postConnection() {
    $errors = Form::validate($_POST, true);

    if (empty($errors)) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $user = User::findOne(['email' => $email]);

      if ($user && password_verify($password, $user->getPassword())) {
        $_SESSION['user'] = $user;
        Router::redirect('/');
        return;
      }

      $errors['notFound'] = 'email ou mot de passe incorrect';
    }

    $this->render('auth/login.twig', [
      'title' => 'Connexion',
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }

  public function getSignup() {
    Router::redirectLoggedUserToHome();
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

      Router::redirect('/connexion');
    }

    $this->render('auth/signup.twig', [
      'title' => 'Inscription',
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }

  public function logout() {
    unset($_SESSION['user']);
    Router::redirect('/');
  }
}