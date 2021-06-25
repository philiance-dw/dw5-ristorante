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

    $baseUri = $_SERVER['REQUEST_URI'];

    $baseUriArr = explode('/', $baseUri);
    $uri = $baseUriArr[1];

    if (sizeof($baseUriArr) >= 1) {
      $uri = $baseUriArr[sizeof($baseUriArr) - 1];
      if (!$uri) {
        $uri = $baseUriArr[sizeof($baseUriArr) - 2];
      }
    }

    $pageName = empty($uri) ? 'home' : $uri;
    $twig->addGlobal('pageName', $pageName);
    $twig->addGlobal('user', $_SESSION['user'] ?? null);

    $this->twig = $twig;
  }

  /**
   *
   * Cette méthode permet de renvoyer un template twig en utilisant la méthode render de twig
   *
   * @param string|TemplateWrapper $name Le nom du template
   * @param array $context Tableau de paramètres à envoyer à la vue
   *
   */
  protected function render($name, array $context = []) {
    echo $this->twig->render($name, $context);
  }
}