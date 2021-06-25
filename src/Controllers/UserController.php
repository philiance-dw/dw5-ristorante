<?php

namespace App\Controllers;

class UserController extends Controller {

  public function getProfile() {
    $user = unserialize($_SESSION['user']);
    $user->populateOrders();

    foreach ($user->getOrders() as $order) {
      $totalPrice = 0;

      foreach ($order->getItems() as $order_item) {
        $totalPrice += $order_item->getQuantity() * $order_item->getPrice();
      }

      $order->setTotalPrice(number_format($totalPrice, 2, '.', ''));
    }

    $this->render('profile.twig', ['title' => 'Mon compte', 'user' => $user]);
  }
}