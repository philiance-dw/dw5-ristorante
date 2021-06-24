<?php

namespace App\Models;

use App\Database;
use PDO;
use PDOException;

class Cart extends Model {
  private $user_id;
  private $items;

  public function __construct() {
    $this->table = 'carts';
  }

  public function getUserId() {
    return $this->user_id;
  }

  public function setUserId(int $user_id): self {
    $this->user_id = $user_id;
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
			ci.quantity
		FROM carts AS c
		JOIN cart_items AS ci
			ON c.id=ci.cart_id
		JOIN dishes AS d
			ON ci.dish_id=d.id
		WHERE c.id=:id;
		EOL;
    $statement = $pdo->prepare($query);
    $statement->execute([':id' => $this->getId()]);

    $items = $statement->fetchAll(PDO::FETCH_CLASS, Dish::class);

    if ($items) {
      $this->setItems($items);
    }
  }

  public function getItems() {
    return $this->items;
  }

  public function setItems(array $items): self {
    $this->items = $items;
    return $this;
  }

  public function addItem(int $dish_id, int $quantity) {
    $pdo = Database::getConnection();
    $query = <<< EOL
		INSERT INTO cart_items
		(cart_id, dish_id, quantity)
		VALUES(:cart_id, :dish_id, :quantity);
		EOL;
    $statement = $pdo->prepare($query);
    return $statement->execute([
      ':cart_id' => $this->getId(),
      ':dish_id' => $dish_id,
      ':quantity' => htmlentities($quantity),
    ]);
  }

  public function updateItem(int $dish_id, int $quantity, bool $isExact = false) {
    $pdo = Database::getConnection();
    $params = [
      ':cart_id' => $this->getId(),
      ':dish_id' => $dish_id,
    ];

    $query = "SELECT quantity FROM cart_items WHERE dish_id=:dish_id AND cart_id=:cart_id";
    $statement = $pdo->prepare($query);
    $statement->execute($params);
    $oldQuantity = (int) $statement->fetch(PDO::FETCH_COLUMN);

    if (!$isExact) {
      $quantity += $oldQuantity;
    }

    $query = <<< EOL
		UPDATE cart_items
		SET quantity=:quantity
		WHERE cart_id=:cart_id
			AND dish_id=:dish_id;
		EOL;
    $statement = $pdo->prepare($query);
    $params[':quantity'] = htmlentities($quantity);

    return $statement->execute($params);
  }

  public function addOrUpdateItem(int $dish_id, int $quantity, bool $isExact = false) {
    $response = '';

    try {
      $response = $this->addItem($dish_id, $quantity);
    } catch (PDOException $e) {
      $message = $e->getMessage();

      if (str_contains(strtolower($message), 'duplicate')) {
        $response = $this->updateItem($dish_id, $quantity, $isExact);
      }
    } finally {
      return $response;
    }
  }

  public function deleteItem(int $dish_id) {
    $pdo = Database::getConnection();
    $params = [
      ':cart_id' => $this->getId(),
      ':dish_id' => $dish_id,
    ];

    $query = "DELETE FROM cart_items WHERE dish_id=:dish_id AND cart_id=:cart_id";
    $statement = $pdo->prepare($query);
    return $statement->execute($params);
  }
}