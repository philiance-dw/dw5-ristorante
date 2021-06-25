<?php

namespace App\Models;

use App\Database;
use PDO;

class Order extends Model {
  private $user_id;
  private $status = "reçu";
  private $method;
  private $items;
  private $totalPrice;

  public function __construct() {
    $this->table = "orders";
  }

  public function getUserId() {
    return $this->user_id;
  }

  public function setUserId(int $user_id): self {
    $this->user_id = $user_id;
    return $this;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus(string $status): self {
    $this->status = $status;
    return $this;
  }

  public function getMethod() {
    return $this->method;
  }

  public function setMethod(string $method): self {
    $this->method = $method;
    return $this;
  }

  public function populateItems() {
    $pdo = Database::getConnection();

    $query = <<< EOL
		SELECT d.id,
			d.name,
			d.description,
			d.size,
			d.image_url,
			d.price,
			d.category_id,
			od.quantity
		FROM orders AS o
		JOIN order_details AS od
			ON o.id=od.order_id
		JOIN dishes AS d
			ON od.dish_id=d.id
		WHERE o.id=:id;
		EOL;
    $statement = $pdo->prepare($query);
    $statement->execute([':id' => $this->getId()]);

    $items = $statement->fetchAll(PDO::FETCH_CLASS, Dish::class);

    if ($items) {
      $this->setItems($items);
    }
  }

  public function addItem(int $dish_id, int $quantity) {
    $pdo = Database::getConnection();
    $query = <<< EOL
		INSERT INTO order_details
		(order_id, dish_id, quantity)
		VALUES(:order_id, :dish_id, :quantity);
		EOL;
    $statement = $pdo->prepare($query);
    return $statement->execute([
      ':order_id' => $this->getId(),
      ':dish_id' => $dish_id,
      ':quantity' => htmlentities($quantity),
    ]);
  }

  public function getItems() {
    return $this->items;
  }

  public function setItems(array $items): self {
    $this->items = $items;
    return $this;
  }

  public function getTotalPrice() {
    return $this->totalPrice;
  }

  public function setTotalPrice(float $totalPrice): self {
    $this->totalPrice = $totalPrice;
    return $this;
  }

}