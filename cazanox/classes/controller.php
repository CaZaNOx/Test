<?php

/**
 * Class Controller
 */
abstract class Controller {

  public $name;
  public $database;

  public function __construct() {
    Session::init();
    $this->name = strtolower(get_class($this));
    $this->database = $this->connectToDatabase();
  }

  private function connectToDatabase() {
    $connection = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8', USER, PASSWORD);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connection;
  }

}
