<?php

class Absences extends Controller {

  public function __construct() {
    parent::__construct();
    Session::authenticate(10);
  }

  public function index($sortField = null, $sortOrder = null) {
    $this->all($sortField, $sortOrder);
  }

  public function all($sortField = null, $sortOrder = null) {
    if (is_null($sortField)) $sortField = 'creation';
    if (is_null($sortOrder)) $sortOrder = 'desc';
    $view = new View($this, 'absences/overview');
    $model = new AbsencesModel($this->database);
    $view->set('sortField', $sortField);
    $view->set('sortOrder', $sortOrder == 'desc' ? 'asc' : 'desc');
    $view->set('status', 'all');
    $view->set('absences', $model->getAllAbsences(Session::getUserId(), $sortField, $sortOrder));
    $view->render();
  }

  public function pending($sortField = null, $sortOrder = null) {
    $this->getAbsences('pending', $sortField, $sortOrder);
  }

  public function approved($sortField = null, $sortOrder = null) {
    $this->getAbsences('approved', $sortField, $sortOrder);
  }

  public function declined($sortField = null, $sortOrder = null) {
    $this->getAbsences('declined', $sortField, $sortOrder);
  }

  private function getAbsences($status, $sortField, $sortOrder) {
    if (is_null($sortField)) $sortField = 'creation';
    if (is_null($sortOrder)) $sortOrder = 'desc';
    $view = new View($this, 'absences/overview');
    $model = new AbsencesModel($this->database);
    $view->set('sortField', $sortField);
    $view->set('sortOrder', $sortOrder == 'desc' ? 'asc' : 'desc');
    $view->set('status', $status);
    $view->set('absences', $model->getAbsences(Session::getUserId(), $status, $sortField, $sortOrder));
    $view->render();
  }

  public function create() {
    $model = new AbsencesModel($this->database);
    if (isset($_POST['submit'])) {
      $begin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['begin'])));
      $end = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['end'])));
      $model->createAbsence(Session::getUserId(), $_POST['type'], $begin, $end, $_POST['notes']);
      header('Location: ' . ROOT . 'absences');
    } else {
      $view = new View($this, 'absences/create');
      $view->render();
    }
  }

  public function edit($id = null) {
    $model = new AbsencesModel($this->database);
    if (!is_null($id)) {
      if (isset($_POST['submit'])) {
        $model->editAbsence($id, $_POST['type'], $_POST['begin'], $_POST['end'], $_POST['notes']);
        header('Location: ' . ROOT . 'absences');
      } else {
        $view = new View($this, 'absences/edit');
        $view->set('absence', $model->getAbsence($id));
        $view->render();
      }
    } else {
      header('Location: ' . ROOT . 'absences');
    }

  }

  public function delete($id = null) {
    if (isset($_POST['submit']) && !is_null($id)) {
      $model = new AbsencesModel($this->database);
      $model->deleteAbsence($id);
    }
    header('Location: ' . ROOT . 'absences');
  }

}
