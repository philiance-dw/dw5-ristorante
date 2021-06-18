<?php

namespace App\Models;

class Dish extends Model {
  private $name;
  private $size;
  private $description;
  private $price;
  private $category_id;

  public function __construct() {
    $this->table = "dishes";
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

  public function getCategoryId() {
    return $this->category_id;
  }
  public function setCategoryId(int $category_id): self {
    $this->category_id = $category_id;
    return $this;
  }
}