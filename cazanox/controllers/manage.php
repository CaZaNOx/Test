<?php

class Manage extends Controller {

  public function __construct() {
    parent::__construct();
    Session::authenticate(100);
  }

  public function index() {
    $this->pending();
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
    $model = new ManageModel($this->database);
    $view = new View($this, 'manage/overview');
    $view->set('status', $status);
    $view->set('sortField', $sortField);
    $view->set('sortOrder', $sortOrder == 'desc' ? 'asc' : 'desc');
    $view->set('absences', $model->getAbsences($status, $sortField, $sortOrder));
    $view->render();
  }

  public function all($sortField = null, $sortOrder = null) {
    if(is_null($sortField)) $sortField = 'creation';
    if(is_null($sortOrder)) $sortOrder = 'desc';
    $model = new ManageModel($this->database);
    $view = new View($this, 'manage/overview');
    $view->set('status', 'all');
    $view->set('sortField', $sortField);
    $view->set('sortOrder', $sortOrder == 'desc' ? 'asc' : 'desc');
    $view->set('absences', $model->getAllAbsences($sortField, $sortOrder));
    $view->render();
  }

  public function view($absence) {
    if (empty($absence)) {
      header('Location: ' . ROOT . 'manage');
    }
    $view = new View($this, 'manage/view');
    $model = new ManageModel($this->database);
    $view->set('absence', $model->getAbsence($absence));
    $view->render();
  }

  public function approve($absence) {
    if (!empty($absence)) {
      $model = new ManageModel($this->database);
      $model->editAbsence(Session::getUserId(), $absence, 'Approved');
    }
    header('Location: ' . ROOT . 'manage');
  }

  public function decline($absence) {
    if (!empty($absence)) {
      $model = new ManageModel($this->database);
      $model->editAbsence(Session::getUserId(), $absence, 'Declined');
    }
    header('Location: ' . ROOT . 'manage');
  }

}