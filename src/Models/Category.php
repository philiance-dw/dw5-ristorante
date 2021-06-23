<?php

namespace App\Models;

use App\Database;
use PDO;

class Category extends Model {
  /** @var string */
  private $name;
  /** @var Dish[] $dishes */
  private $dishes; // pas present en BDD

  public function __construct() {
    $this->table = 'categories';
  }

  public function getName() {
    return $this->name;
  }
  public function setName(string $name): self {
    $this->name = $name;
    return $this;
  }

  public function getDishes() {
    return $this->dishes;
  }

  public function setDishes(array $dishes) {
    $this->dishes = $dishes;
    return $this;
  }

  public function populateDishes() {
    $query = <<< EOL
		SELECT * FROM dishes
		WHERE category_id=:id
		EOL;

    $pdo = Database::getConnection();

    $statement = $pdo->prepare($query);
    $statement->execute([':id' => $this->getId()]);

    $response = $statement->fetchAll(PDO::FETCH_CLASS, Dish::class);

    if (!empty($response)) {
      $this->setDishes($response);
    }
  }
}