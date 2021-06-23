<?php

namespace App\Controllers;

use App\Router;

class CartController extends Controller {
  public function getCartPage() {
    $user = unserialize($_SESSION['user']);
    $user->populateCart();

    $cart = $user->getCart();

    $totalPrice = null;

    $items = $cart->getItems();

    if ($items) {
      $totalPrice = 0;

      foreach ($items as $item) {
        $itemPrice = $item->getPrice() * $item->getQuantity();
        $totalPrice += $itemPrice;
      }
    }

    $this->render('cart.twig', ['title' => 'Panier', 'cart' => $cart, 'totalPrice' => $totalPrice]);
  }

  public function postAddDishToCart(int $id) {
    $quantity = (int) $_POST['quantity'];

    $quantity = $quantity > 20 ? 20 : $quantity;
    $quantity = $quantity < 1 ? 1 : $quantity;

    $user = unserialize($_SESSION['user']);
    $user->populateCart();

    $cart = $user->getCart();
    $cart->addOrUpdateItem($id, $quantity);

    Router::redirect('/panier');
  }
}