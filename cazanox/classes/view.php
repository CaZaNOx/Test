<?php
/**
* Class View
*/
class View {

  private $controller;
  private $data;
  private $template;

  public function __construct($controller, $template) {
    $this->controller = $controller;
    $this->data = new StdClass();
    $file = 'views/' . $template . '.php';
    if(file_exists($file)){
      $this->template = $file;
    } else {
      $this->template = 'views/error/404.php';
    }
  }

  public function set($variable , $value) {
    $this->$variable = $value;
  }

  public function get($variable) {
    if(isset($this->$variable)){
      return $this->$variable;
    }
    return 'not defined';
  }

  public function render($loginPage = false) {
    $controller = $this->controller;
    include('views/_layout/header.php');
    if(!$loginPage){
      include('views/_layout/navigation.php');
    }
    include($this->template);
    include('views/_layout/footer.php');
  }

  public function addLabel($value) {
    switch (strtolower($value)) {
      case "approved":
      case "active":
        $value = '<span class="label label-success">' . $value . '</span>';
        break;
      case "pending":
      case "disabled":
        $value = '<span class="label label-warning">' . $value . '</span>';
        break;
      case "declined":
      case "deleted":
        $value = '<span class="label label-danger">' . $value . '</span>';
        break;
    }
    return $value;
  }

  public function addButtonLong($action, $link) {
    switch ($action) {
      case "approve":
        $action = '<a href=' . ROOT . $link . ' class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span> ' . $action . '</a>';
        break;
      case "decline":
        $action = '<a href=' . ROOT . $link . ' class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> ' . $action . '</a>';
        break;
      case "edit":
        $action = '<a href=' . ROOT . $link . ' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span> ' . $action . '</a>';
        break;
      case "view":
        $action = '<a href=' . ROOT . $link . ' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-search"></span> ' . $action . '</a>';
        break;
    }
    return $action;
  }

  public function addButtonShort($action, $link) {
    switch ($action) {
      case "approve":
        $action = '<a href=' . ROOT . $link . ' class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></a>';
        break;
      case "decline":
        $action = '<a href=' . ROOT . $link . ' class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a>';
        break;
      case "edit":
        $action = '<a href=' . ROOT . $link . ' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></a>';
        break;
      case "view":
        $action = '<a href=' . ROOT . $link . ' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-search"></span></a>';
        break;
    }
    return $action;
  }

  public function getSortingLinks($column, $baseUrl, $sortField, $sortOrder) {
    if ($column == $sortField) {
      $url = ROOT . $baseUrl . '/' . $column . '/' . $sortOrder;
    } else {
      $url = ROOT . $baseUrl . '/' . $column;
    }
    return '<a href="' . $url . '">' . $column . '</a>';
  }

  public function timeDifference($time1, $time2){
    if(empty($time1)) $time1 = '00:00';
    if(empty($time2)) $time2 = '00:00';
    $time1 = explode(':', $time1);
    $time2 = explode(':', $time2);
    $minutes1 = $time1[0] * 60 + $time1[1];
    $minutes2 = $time2[0] * 60 + $time2[1];
    $minutes = abs($minutes1 - $minutes2);
    $hours = (int) ($minutes / 60);
    $minutes = (int) ($minutes % 60);
    $sign = ($minutes2 > $minutes1) ? '-' : '';
    return $sign . sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
  }

  public function timeSum($time1, $time2){
    if(empty($time1)) $time1 = '00:00';
    if(empty($time2)) $time2 = '00:00';
    $time1 = explode(':', $time1);
    $time2 = explode(':', $time2);
    $hours = (int) ($time1[0] + $time2[0] + ($time1[1] + $time2[1]) / 60);
    $minutes = (int) (($time1[1] + $time2[1]) % 60);
    return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
  }

}
