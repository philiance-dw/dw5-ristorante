<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Order;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class OrderController extends Controller {
  public function getOrderingPage() {
    $categories = Category::find();

    foreach ($categories as $index => $category) {
      // on recupere les categories et les plats associés
      $category->populateDishes();

      if (empty($category->getDishes())) {
        unset($categories[$index]);
      }
    }

    $this->render('ordering.twig', ['title' => 'Commander', 'categories' => $categories]);
  }

  public function getPaymentPage() {
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

    $this->render('payment.twig', ['title' => 'Payer', 'amountToPay' => $totalPrice]);
  }

  public function processPayment() {
    /**
     *
     * https: //keithweaverca.medium.com/using-stripe-with-php-c341fcc6b68b
     *
     */
    $user = unserialize($_SESSION['user']);
    $user->populateCart();
    $cart = $user->getCart();

    Stripe::setApiKey($_ENV['STRIPE_API_KEY']);

    $token = $_POST['stripeToken'] ?? null;
    $amountToPay = $_POST['amountToPay'] ?? null;

    $message = '';

    if ($token && $amountToPay) {
      try {
        $charge = Charge::create(
          [
            // on multiplie par 100 pour avoir le montant correct
            // stripe comptabilise en centimes
            'amount' => $amountToPay * 100,
            'currency' => 'eur',
            'source' => $token,
          ]
        );

        $success = $charge->status === 'succeeded';

        if ($success) {
          $order = new Order();
          $order = $order->setUserId($user->getId())
            ->setMethod("visa")
            ->save();

          foreach ($cart->getItems() as $cart_item) {
            $order->addItem($cart_item->getId(), $cart_item->getQuantity());
            $cart->deleteItem($cart_item->getId());
          }

          $this->render('order-confirm.twig', ['title' => 'Commande validée', 'orderId' => $order->getId()]);
          return;
        }

        $message = "Erreur durant la validation du paiement";
      } catch (ApiErrorException $e) {
        // on peut recuperer l'erreur dans la variable $e
        $message = '';
      }

      $this->render('order-error.twig', ['title' => 'Commande échouée', 'errorMessage' => $message]);

    }
  }
}