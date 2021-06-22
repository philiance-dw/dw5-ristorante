<?php

namespace App;

use Dotenv\Dotenv;
use PDO;

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

    return new PDO("mysql:dbname=ristorante;host=localhost", $_ENV['DB_USER'], $_ENV['DB_PASS'], [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  }
}