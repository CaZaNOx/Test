<?php

class Calendar extends Controller {

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
    if ($week < 1 || $week > 52 || $year < 2000 || $year > 3000) {
      header('Location: ' . ROOT . 'error/page404');
      exit();
    }
    $view = new View($this, 'calendar/index');
    $model = new CalendarModel($this->database, $year, $week);
    $id = Session::get('id');
    $view->set('year', $year);
    $view->set('week', $week);
    $view->set('urls', $model->getUrls($year, $week));
    $view->set('settings', $model->getSettings($id));
    $view->set('periods', $model->getPeriods($id, $year, $week));
    $view->set('notes', $model->getNotes($id, $year, $week));
    $view->set('schedule', $model->getSchedule($id, $year, $week));
    $view->set('sum', $model->getSum($id, $year, $week));
    $view->render();
  }

  public function save() {
    if (isset($_POST['submit'])) {
      $model = new CalendarModel($this->database);
      $periods = array_chunk(array_slice($_POST, 0, -3), 2);
      $model->saveIntervals(Session::getUserId(), $_POST['date'], $periods);
      $model->saveNote(Session::getUserId(), $_POST['date'], $_POST['notes']);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
}
