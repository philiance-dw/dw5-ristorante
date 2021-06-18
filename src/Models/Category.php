<?php

namespace App\Models;

use App\Database;
use PDO;

class Category extends Model {
  /** @var string */
  private $name;

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

  public static function getDishes() {
    $pdo = Database::getConnection();
    $statement = $pdo->prepare("SELECT c.name, d.id, d.name, d.description, d.size, d.price, d.created_at, d.updated_at FROM categories as c JOIN dishes as d ON c.id=d.category_id");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_GROUP);
  }
}