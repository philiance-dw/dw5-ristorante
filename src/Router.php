<?php

namespace App;

use AltoRouter;
use App\Controllers\ErrorController;

class Router extends AltoRouter {
  private $path;
  private $router;

  /**
   *
   * A l'instanciation de notre router on instancie altorouter et on l'affecte à la propriété router de la class
   *
   */
  public function __construct() {
    $this->router = new AltoRouter();
  }

  /**
   * @param string $path  chemin base
   */
  public function setPath(string $path) {
    $this->path = $path;
    return $this;
  }

  /**
   *
   * On vient utiliser la méthode map d'Altorouter pour faire une méthode get personnalisée
   *
   * @param string $route la route à atteindre
   * @param mixed $target la méthode à executer quand l'utilisateur arrive sur cette route
   *
   * @return Router retourne l'instance actuelle du router
   *
   */
  public function get($route, $target) {
    $this->router->map('GET', $this->path . $route, $target);
    $this->router->map('GET', $this->path . $route . '/', $target);
    // on retourne this pour pouvoir executer d'autres méthodes à l'affilé -> chaining
    return $this;
  }

  /**
   *
   * On vient utiliser la méthode map d'Altorouter pour faire une méthode post personnalisée
   *
   * @param string $route la route à atteindre
   * @param mixed $target la méthode à executer quand l'utilisateur arrive sur cette route
   *
   * @return Router retourne l'instance actuelle du router
   *
   */
  public function post($route, $target) {
    $this->router->map('POST', $this->path . $route, $target);
    return $this;
  }

  public function delete($route, $target) {
    $this->router->map('DELETE', $this->path . $route, $target);
    return $this;
  }

  /**
   *
   * Cette méthode permet de lancer le router et de vérifier les correspondances avec les routes prédéfinies
   *
   */
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

    // on instancie le ErrorController et on utilise la méthode get404 pour renvoyer une page d'erreur si pas de correspondance
    $errorController = new ErrorController();
    $errorController->get404();
  }

  /**
   *
   * Méthode servant à rediriger en page d'accueil un utilisateur connecté
   *
   */
  public static function redirectLoggedUserToHome() {
    if (isset($_SESSION['user'])) {
      header("Location: /");
    }
  }

  /**
   *
   * Méthode servant à rediriger selon le paramametre
   *
   * @param string $path chemin de redirection
   *
   */
  public static function redirect(string $path) {
    header("Location: $path");
  }
}