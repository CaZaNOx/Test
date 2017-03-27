<?php

class Model {
  public function __construct(PDO $database) {
    $this->database = $database;
  }

  public function __destruct() {
    $this->database = null;
  }

  public function wrapInUnixTimeStapIfNeeded($column){
    if($column == 'creation' || $column == 'date' || $column == 'begin' || $column == 'end'){
      $column = 'UNIX_TIMESTAMP(' . $column . ')';
    }
    return $column;
  }
} 