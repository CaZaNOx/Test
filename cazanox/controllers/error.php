<?php

class Error extends Controller {

  public function __construct() {
    parent::__construct();
    Session::authenticate(10);
  }

  public function index() {
    $this->page404();
  }

  public function page404() {
    $view = new View($this, 'error/404');
    $view->render();
  }

  public function page401() {
    $view = new View($this, 'error/401');
    $view->render();
  }
}
