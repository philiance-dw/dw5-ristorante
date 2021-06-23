<?php

namespace App\Models;

use App\Database;
use PDO;

// interface Test {
//   public function test(string $message);
// }

// class User implements Test {}

class User extends Model {
  private $first_name;
  private $last_name;
  private $phone;
  private $address;
  private $city;
  private $country;
  private $postal_code;
  private $email;
  private $password;
  private $is_admin = false;
  private $cart;

  public function __construct() {
    $this->table = 'users';
  }

  public function setFirstName(string $first_name): self {
    $this->first_name = $first_name;
    return $this;
  }
  public function getFirstName() {
    return $this->first_name;
  }

  public function setLastName(string $last_name): self {
    $this->last_name = $last_name;
    return $this;
  }
  public function getLastName() {
    return $this->last_name;
  }

  public function getPhone() {
    return $this->phone;
  }
  public function setPhone(string $phone): self {
    $this->phone = $phone;
    return $this;
  }

  public function getAddress() {
    return $this->address;
  }
  public function setAddress(string $address): self {
    $this->address = $address;
    return $this;
  }

  public function getCity() {
    return $this->city;
  }
  public function setCity(string $city): self {
    $this->city = $city;
    return $this;
  }

  public function getCountry() {
    return $this->country;
  }
  public function setCountry(string $country): self {
    $this->country = $country;
    return $this;
  }

  public function getPostalCode() {
    return $this->postal_code;
  }
  public function setPostalCode(string $postal_code): self {
    $this->postal_code = $postal_code;
    return $this;
  }

  public function getEmail() {
    return $this->email;
  }
  public function setEmail(string $email): self {
    $this->email = $email;
    return $this;
  }

  public function getPassword() {
    return $this->password;
  }
  public function setPassword(string $password): self {
    $this->password = $password;
    return $this;
  }

  public function getIsAdmin() {
    return $this->is_admin;
  }
  public function setIsAdmin(bool $is_admin): self {
    $this->is_admin = $is_admin;
    return $this;
  }

  public function getCart() {
    return $this->cart;
  }
  public function setCart($cart) {
    $this->cart = $cart;
    return $this;
  }

  public function populateCart() {
    $pdo = Database::getConnection();
    $statement = $pdo->prepare("SELECT * FROM carts WHERE user_id=:id");
    $statement->execute([':id' => $this->getId()]);
    $cart = $statement->fetchAll(PDO::FETCH_CLASS, Cart::class);

    if ($cart) {
      $cart = $cart[0];
      $cart->populateItems();
      $this->setCart($cart);
    }
  }
}