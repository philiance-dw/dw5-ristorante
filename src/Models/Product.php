<?php

namespace App\Models;

class Product extends Model {
  private $name;
  private $quantity;
  private $price;
  private $category_id;

  public function __construct() {
    $this->table = "products";
  }

  public function getName() {
    return $this->name;
  }
  public function setName(string $name): self {
    $this->name = $name;
    return $this;
  }

  public function getQuantity() {
    return $this->quantity;
  }
  public function setQuantity(int $quantity): self {
    $this->quantity = $quantity;
    return $this;
  }

  public function getPrice() {
    return $this->price;
  }
  public function setPrice(float $price): self {
    $this->price = $price;
    return $this;
  }

  public function getCategoryId() {
    return $this->category_id;
  }
  public function setCategoryId(int $category_id): self {
    $this->category_id = $category_id;
    return $this;
  }

}