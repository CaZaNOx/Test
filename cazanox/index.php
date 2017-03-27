<?php

require_once('classes/session.php');
require_once('config/config.php');

require_once('classes/model.php');
require_once('classes/view.php');
require_once('classes/controller.php');


function __autoload($className) {
  $file = 'models/' . substr(strtolower($className), 0, -5) . '.php';
  if (file_exists($file)) {
    require_once($file);
  } else {
    die("The model '$className' could not be found!");
  }
}

require_once('classes/application.php');

$app = new Application();
