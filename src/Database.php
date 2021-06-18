<?php

namespace App;

use Dotenv\Dotenv;
use PDO;

class Database {
  public static function getConnection() {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    return new PDO("mysql:dbname=ristorante;host=localhost", $_ENV['DB_USER'], $_ENV['DB_PASS'], [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  }
}