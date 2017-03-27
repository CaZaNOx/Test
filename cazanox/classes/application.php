<?php
/**
 * Class Application
 */
class Application {

  private $controller;
  private $function;
  private $argument_1;
  private $argument_2;

  public function __construct() {
    $this->parsePath();
    if (!empty($this->controller)) {
      if (file_exists('controllers/' . $this->controller . '.php')) {
        require('controllers/' . $this->controller . '.php');
        $this->controller = new $this->controller();
        if (method_exists($this->controller, $this->function)) {
          $this->controller->{$this->function}($this->argument_1, $this->argument_2);
        } else {
          $this->controller->index();
        }
      } else {
        // Page Not Found
        header('Location: ' . ROOT . 'error/404');
        exit();
      }
    } else {
      // Main Site
      header('Location: ' . ROOT . 'calendar');
      exit();
    }
  }

  private function parsePath() {
    if (isset($_GET['path'])) {
      $path = $_GET['path'];
      $path = explode('/', $path);
      $this->controller = (isset($path[0]) ? $path[0] : null);
      $this->function = (isset($path[1]) ? $path[1] : null);
      $this->argument_1 = (isset($path[2]) ? $path[2] : null);
      $this->argument_2 = (isset($path[3]) ? $path[3] : null);
    }
    if (DEBUG) {
      echo 'Controller: ' . $this->controller . '<br />';
      echo 'Function:   ' . $this->function . '<br />';
      echo 'Argument 1: ' . $this->argument_1 . '<br />';
      echo 'Argument 2: ' . $this->argument_2 . '<br />';
    }
  }
}
