<?php

class Team extends Controller {

  public function __construct() {
    parent::__construct();
    Session::authenticate(10);
  }

  public function index() {
    $this->show();
  }

  public function show($department = null, $year = null) {
    if (is_null($department)) $department = 'all';
    if (is_null($year)) $year = date('Y');
    $view = new View($this, 'team/index');
    $model = new TeamModel($this->database, $year);
    $view->set('year', $year);
    $view->set('firstDayOfYear', $model->getfirstDayOfYear($year));
    $view->set('lastDayOfYear', $model->getlastDayOfYear($year));
    $view->set('lastYearUrl', $model->getPrevYearUrl($department, $year));
    $view->set('nextYearUrl', $model->getNextYearUrl($department, $year));
    $view->set('team', $model->getTeam($department));
    $view->set('departments', $model->getDepartments());
    $view->set('absences', $model->getAbsences($department, $year));
    $view->render();
  }

}
