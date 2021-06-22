<?php

namespace App\Controllers;

use App\Models\Dish;

class DishController extends Controller {
  public function getDishes() {
    $dishes = Dish::find(['include' => ['categories']]);

    $this->render('admin/dishes.twig', [
      'title' => 'Plats',
      'dishes' => $dishes,
    ]);
  }

}