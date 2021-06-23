<?php

namespace App\Models;

use App\Database;
use PDO;

class Dish extends Model {
  private $name;
  private $size;
  private $description;
  private $price;
  private $image_url = null;
  private $category_id;
  private $category_name; // pas présent en bdd
  private $quantity; // pas présent en BDD

  public function __construct() {
    $this->table = "dishes";
  }

  public static function find(array $params = []): array{
    $pdo = Database::getConnection();

    if (empty($params)) {
      $statement = $pdo->query("SELECT * FROM dishes");
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_CLASS, Dish::class);
    }

    $include = $params['include'] ?? null;

    if ($include) {
      if (in_array('categories', $include)) {
        $query = <<< EOL
				SELECT d.id,
					d.name,
					d.size,
					d.description,
					d.price,
					d.image_url,
					d.category_id,
					d.created_at,
					d.updated_at,
					c.name AS category_name
				FROM dishes AS d
				JOIN categories AS c
				ON d.category_id = c.id;
				EOL;

        $statement = $pdo->query($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, Dish::class);
      }
    }

    return [];
  }

  public function getName() {
    return $this->name;
  }
  public function setName(string $name): self {
    $this->name = $name;
    return $this;
  }

  public function getSize() {
    return $this->size;
  }
  public function setSize(string $size): self {
    $this->size = $size;
    return $this;
  }

  public function getDescription() {
    return $this->description;
  }
  public function setDescription(string $description): self {
    $this->description = $description;
    return $this;
  }

  public function getPrice() {
    return $this->price;
  }
  public function setPrice(float $price): self {
    $this->price = $price;
    return $this;
  }

  public function getImageUrl() {
    return $this->image_url;
  }
  public function setImageUrl(string $image_url): self {
    $this->image_url = $image_url;
    return $this;
  }

  public function getCategoryId() {
    return $this->category_id;
  }
  public function setCategoryId(int $category_id): self {
    $this->category_id = $category_id;
    return $this;
  }

  public function getCategoryName() {
    return $this->category_name;
  }
  public function setCategoryName(string $category_name): self {
    $this->category_name = $category_name;
    return $this;
  }

  public function getQuantity() {
    return $this->quantity;
  }
  public function setQuantity(string $quantity): self {
    $this->quantity = $quantity;
    return $this;
  }
}