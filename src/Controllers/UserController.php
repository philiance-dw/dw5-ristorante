<?php

namespace App\Controllers;

use App\Models\User;
use App\Router;

class UserController extends Controller {

  public function getProfile() {
    $user = unserialize($_SESSION['user']);
    $user->populateOrders();

    $orders = $user->getOrders();

    if ($orders) {
      foreach ($orders as $order) {
        $totalPrice = 0;

        foreach ($order->getItems() as $order_item) {
          $totalPrice += $order_item->getQuantity() * $order_item->getPrice();
        }

        $order->setTotalPrice(number_format($totalPrice, 2, '.', ''));
      }
    }

    $this->render('profile.twig', ['title' => 'Mon compte', 'user' => $user]);
  }

  public function delete() {
    $user = unserialize($_SESSION['user']) ?? null;

    if ($user) {
      User::deleteOne($user->getId());
      unset($_SESSION['user']);
      session_unset();
      session_destroy();
      Router::redirect('/');
    }

    Router::redirect('/profile');
  }
}