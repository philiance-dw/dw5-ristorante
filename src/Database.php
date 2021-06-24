<?php

namespace App;

use App\Controllers\ErrorController;
use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database {
  /**
   *
   * Cette méthode permet de charger les variables d'environnement et retourne une instance PDO servant à effectuer des requetes en base de donnée
   *
   * @return PDO retourn une instance de PDO
   *
   */
  public static function getConnection() {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    $pdo = null;

    try {
      $pdo = new PDO("mysql:dbname=ristorante;host=localhost", $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    } catch (PDOException $e) {
      $errorController = new ErrorController();
      $errorController->get500($e->getMessage());
      die();
    }

    if ($pdo) {
      return $pdo;
    }
  }
}