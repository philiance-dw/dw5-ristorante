<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller {
  /** @var \Twig\Environment */
  private $twig;

  public function __construct() {
    $loader = new FilesystemLoader(dirname(dirname(__DIR__)) . '/views');

    $twig = new Environment($loader, [
      'cache' => false,
    ]);

    $uri = explode('/', $_SERVER['REQUEST_URI'])[1];
    $pageName = empty($uri) ? 'home' : $uri;
    $twig->addGlobal('pageName', $pageName);

    $this->twig = $twig;
  }

  protected function render($name, array $context = []) {
    echo $this->twig->render($name, $context);
  }
}