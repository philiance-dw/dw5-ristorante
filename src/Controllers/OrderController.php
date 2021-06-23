<?php

namespace App\Controllers;

use App\Models\Category;

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
}