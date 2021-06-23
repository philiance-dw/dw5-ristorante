<?php

namespace App\Controllers;

class ApiController {
  public function postAddDishToCart() {
    // on recupere le json
    $data = file_get_contents('php://input');
    // on le decode en le transformant en tableau associatif
    $data = json_decode($data, true);

    $dish_id = $data['dish_id'];
    $quantity = $data['quantity'];

    $quantity = $quantity > 20 ? 20 : $quantity;
    $quantity = $quantity < 1 ? 1 : $quantity;

    $user = unserialize($_SESSION['user']);
    $user->populateCart();

    $cart = $user->getCart();
    $success = $cart->addOrUpdateItem($dish_id, $quantity);

    echo json_encode(['message' => $success ? 'Plat correctement ajouté au panier.' : "Erreur lors de l'ajout au panier."]);
  }
}