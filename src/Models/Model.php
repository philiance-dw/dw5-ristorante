<?php

namespace App\Models;

use App\Database;
use DateTime;
use PDO;
use ReflectionClass;
use ReflectionProperty;

abstract class Model {
  // protected static $tableName;
  protected $table;
  protected $pdo;

  /** @var int */
  protected $id;
  /** @var string */
  protected $created_at;
  /** @var string */
  protected $updated_at;

  public function __construct() {
    $this->pdo = Database::getConnection();

  }

  private function getClassProperties() {
    $reflect = new ReflectionClass($this);
    $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);

    $classProps = [];
    foreach ($props as $prop) {
      if (!in_array($prop->getName(), ['pdo'])) {
        array_push($classProps, $prop->getName());
      }

    }

    return $classProps;
  }

  private function getObjectAsArray() {
    $classProps = $this->getClassProperties();

    $objArray = [];

    foreach ($classProps as $prop) {
      $ucProp = implode('', array_map(fn($el) => ucfirst($el), explode("_", $prop)));

      $getter = "get$ucProp";
      if ($this->$getter()) {
        $objArray[$prop] = $this->$getter();
      }

    }

    return $objArray;
  }

  public static function find() {
    $class = get_called_class();
    $obj = new $class();
    $table = $obj->getTable();
    $pdo = Database::getConnection();

    $statement = $pdo->query("SELECT * FROM $table;");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_CLASS, $obj::class);
  }

  public static function findOne(array $params) {
    $class = get_called_class();
    $obj = new $class();
    $table = $obj->getTable();
    $pdo = Database::getConnection();

    $id = $params['id'] ?? null;
    $email = $params['email'] ?? null;

    if ($id) {
      $statement = $pdo->prepare("SELECT * FROM $table WHERE id=:id;");
      $statement->execute([':id' => htmlentities($id)]);
    } elseif ($email) {
      $statement = $pdo->prepare("SELECT * FROM $table WHERE email=:email;");
      $statement->execute([':email' => htmlentities($email)]);
    }

    $entity = $statement->fetchAll(PDO::FETCH_CLASS, $obj::class);

    if (!empty($entity)) {
      return $entity[0];
    }

    return false;
  }

  public function save() {
    $objArray = $this->getObjectAsArray();

    if (!isset($objArray['id'])) {
      return $this->create($objArray);
    }

    return $this->update($objArray);
  }

  public function create(array $entityArray): false | self{
    $tableName = $entityArray['table'];
    unset($entityArray['table']);
    unset($entityArray['id']);
    unset($entityArray['created_at']);
    unset($entityArray['updated_at']);
    $keys = array_keys($entityArray);
    $params = array_map(fn($el) => ":$el", $keys);
    $values = array_values($entityArray);
    $paramValues = array_combine($params, $values);

    $params = implode(',', $params);
    $keys = implode(',', $keys);

    $pdo = Database::getConnection();

    $statement = $pdo->prepare("INSERT INTO $tableName ($keys) VALUES ($params);");

    $statement->execute($paramValues);

    $lastInsertId = $pdo->lastInsertId();
    $statement = $pdo->query("SELECT * FROM $tableName WHERE id=$lastInsertId");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_CLASS, $this::class)[0];
  }

  public function update(array $entityArray) {
    $tableName = $entityArray['table'];
    $id = $entityArray['id'];

    // ici j'enleve les clés dont je n'ai pas besoin
    unset($entityArray['id']);
    unset($entityArray['table']);
    unset($entityArray['created_at']);
    unset($entityArray['updated_at']);

    $keys = array_keys($entityArray); // clés de l'objet
    $params = array_map(fn($el) => ":$el", $keys); // clés de l'objet préfixés avec :
    $values = array_values($entityArray); // valeurs de l'objet

    $params = array_combine($params, $values); // tableau de parametres à envoyé à la méthode execute

    $setString = [];

    foreach ($keys as $value) {
      $setString[] = "$value=:$value";
    }

    $setString = implode(', ', $setString);

    $pdo = Database::getConnection();

    $statement = $pdo->prepare("UPDATE $tableName SET $setString, updated_at=NOW() WHERE id=:id");
    $params[':id'] = $id;

    $statement->execute($params);

    $statement = $pdo->prepare("SELECT * FROM $tableName WHERE id=:id");
    $statement->execute([':id' => $id]);

    return $statement->fetchAll(PDO::FETCH_CLASS, $this::class)[0];
  }

  public static function deleteOne(int $id): bool {
    $class = get_called_class();
    $obj = new $class();
    $table = $obj->getTable();
    $pdo = Database::getConnection();

    $statement = $pdo->prepare("DELETE FROM $table WHERE id=:id;");
    $statement->execute(['id' => htmlentities($id)]);
    return (bool) $statement->fetchAll(PDO::FETCH_CLASS, $obj::class);
  }

  public function getTable(): string {
    return $this->table;
  }

  // public function getTableName(): string {
  //   return $this->table;
  // }

  public function getId(): ?int {
    return $this->id;
  }
  public function setId(int $id) {
    $this->id = $id;
    return $this;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }
  public function setCreatedAt(DateTime $created_at) {
    $this->created_at = $created_at;
    return $this;
  }

  public function getUpdatedAt() {
    return $this->updated_at;
  }
  public function setUpdatedAt(DateTime $updated_at) {
    $this->updated_at = $updated_at;
    return $this;
  }

}