<?php

namespace App;

use AltoRouter;
use App\Controllers\MainController;

class Router extends AltoRouter {

  private $router;

  public function __construct() {
    $this->router = new AltoRouter();
  }

  // on vient utiliser la méthode map d'Altorouter pour faire une méthode get personnalisée
  public function get($route, $target) {
    $this->router->map('GET', $route, $target);
    // on retourne this pour pouvoir executer d'autres méthodes à l'affilé -> chaining
    return $this;
  }

  // on vient utiliser la méthode map d'Altorouter pour faire une méthode post personnalisée
  public function post($route, $target) {
    $this->router->map('POST', $route, $target);
    return $this;
  }

  public function run() {
    // on vérifie les correspondance d'url et de route
    $match = $this->router->match();

    if (is_array($match)) {
      // si on a une correspondance on recupere la clé params et target de match
      [
        'target' => $target,
        'params' => $params,
      ] = $match;

      // on vient faire une petite transformation pour recuperer le controller et la méthode a executer en coupant la chaine de caractères qu'on recoit sur le symbole #
      // exemple MainController#getHome donnera
      // $controller = MainController
      // $action = getHome
      [$controller, $action] = explode("#", $target);

      // instantiacion dynamique du controller
      $controller = "App\Controllers\\$controller";
      $obj = new $controller;

      if (is_callable([$obj, $action])) {
        // on appelle la fonction demandée

        if (!empty($params)) {
          array_walk($params, [$obj, $action]);
          return;
        }

        $obj->$action($params);
      }

      return;
    }

    $mainController = new MainController();
    $mainController->get404();
  }
}