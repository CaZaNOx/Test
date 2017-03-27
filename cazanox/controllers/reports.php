<?php

class Reports extends Controller {

  public function __construct() {
    parent::__construct();
    Session::authenticate(10);
  }

  public function index() {
    $this->week();
  }

  public function week($year = null, $week = null) {
    if (is_null($year)) $year = (int) date('Y');
    if (is_null($week)) $week = (int) date('W');
    $view = new View($this, 'reports/week');
    $model = new ReportsModel($this->database);
    $view->set('week', $week);
    $view->set('firstDayOfWeek', $model->getfirstDayOfWeek($year, $week));
    $view->set('lastDayOfWeek', $model->getlastDayOfWeek($year, $week));
    $view->set('lastWeekUrl', $model->getLastWeekUrl($year, $week));
    $view->set('nextWeekUrl', $model->getNextWeekUrl($year, $week));
    $view->set('reports', $model->getWeekOverview(Session::getUserId(), $year, $week));
    $view->set('workingPeriods', $model->getWeekWorkingPeriods(Session::getUserId(), $year, $week));
    $view->render();
  }

  public function month($year = null, $month = null) {
    if (is_null($year)) $year = (int) date('Y');
    if (is_null($month)) $month = (int) date('n');
    $view = new View($this, 'reports/month');
    $model = new ReportsModel($this->database);
    $view->set('monthName', $model->getMonthName($month));
    $view->set('firstDayOfMonth', $model->getfirstDayOfMonth($year, $month));
    $view->set('lastDayOfMonth', $model->getlastDayOfMonth($year, $month));
    $view->set('lastMonthUrl', $model->getLastMonthUrl($year, $month));
    $view->set('nextMonthUrl', $model->getNextMonthUrl($year, $month));
    $view->set('reports', $model->getMonthOverview(Session::getUserId(), $year, $month));
    $view->render();
  }

  public function year($year = null) {
    if (is_null($year)) $year = (int) date('Y');
    $view = new View($this, 'reports/year');
    $model = new ReportsModel($this->database);
    $view->set('year', $year);
    $view->set('firstDayOfYear', $model->getfirstDayOfYear($year));
    $view->set('lastDayOfYear', $model->getlastDayOfYear($year));
    $view->set('lastYearUrl', $model->getLastYearUrl($year));
    $view->set('nextYearUrl', $model->getNextYearUrl($year));
    $view->set('timeSeries', $model->getYearOverview(Session::getUserId(), $year));
    $view->render();
  }

}
