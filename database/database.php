<?php

use Dotenv\Dotenv;

try {
  $dotenv = Dotenv::createImmutable(dirname(__DIR__));
  $dotenv->load();

  $pdo = new PDO("mysql:dbname=ristorante;host=localhost", $_ENV['DB_USER'], $_ENV['DB_PASS'], [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ]);

} catch (PDOException $e) {
  echo $e->getMessage();
  die();
}