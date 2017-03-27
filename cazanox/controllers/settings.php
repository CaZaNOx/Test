<?php

class Settings extends Controller {

  public function __construct() {
    parent::__construct();
    Session::authenticate(10);
  }

  public function index() {
    $this->sort();
  }

  public function sort($sortField = null, $sortOrder = null){
    if (is_null($sortField)) $sortField = 'begin';
    if (is_null($sortOrder)) $sortOrder = 'desc';
    $view = new View($this, 'settings/index');
    $model = new SettingsModel($this->database);
    $id = Session::get('id');
    $view->set('sortField', $sortField);
    $view->set('sortOrder', $sortOrder == 'desc' ? 'asc' : 'desc');
    $view->set('user', $model->getSettings($id));
    $view->set('employmentLevels', $model->getAllEmploymentLevel($id, $sortField, $sortOrder));
    $view->render();
  }

  public function create() {
    $model = new SettingsModel($this->database);
    if (isset($_POST['submit'])) {
      $schedule = array($_POST['mondayHours'], $_POST['mondayMinutes'], $_POST['tuesdayHours'], $_POST['tuesdayMinutes'],
        $_POST['wednesdayHours'], $_POST['wednesdayMinutes'], $_POST['thursdayHours'], $_POST['thursdayMinutes'],
        $_POST['fridayHours'], $_POST['fridayMinutes'],$_POST['saturdayHours'], $_POST['saturdayMinutes']);
      $model->createEmploymentLevel($_SESSION['id'], $_POST['begin'], $_POST['end'], $_POST['level'], $schedule);
      header('Location: ' . ROOT . 'settings');
    }
    $view = new View($this, 'settings/create');
    $view->render();
  }

  public function edit($idInterval = null) {
    if (!is_null($idInterval)) {
      $model = new SettingsModel($this->database);
      if (isset($_POST['submit'])) {
        $model->editEmploymentLevel($idInterval, $_POST['begin'], $_POST['end'], $_POST['level']);
        header('Location: ' . ROOT . 'settings');
      } else {
        $view = new View($this, 'settings/edit');
        $view->set('employmentLevel', $model->getEmploymentLevel($idInterval));
        $view->render();
      }
    } else {
      header('Location: ' . ROOT . 'settings');
    }
  }

  public function delete($idInterval = null) {
    $model = new SettingsModel($this->database);
    if (isset($_POST['submit'])) {
      $model->deleteEmploymentLevel($idInterval);
    }
    header('Location: ' . ROOT . 'settings');
  }

  public function save() {
    $model = new SettingsModel($this->database);
    if (isset($_POST['submit'])) {
      $model->editSettings($_SESSION['id'], $_POST['periods'], $_POST['notes'], $_POST['messages']);
    }
    header('Location: ' . ROOT . 'settings');
  }

  public function changePassword() {
    $model = new UserModel($this->database);
    if (isset($_POST['submit'])) {
      if ($model->login($_SESSION['username'], $_POST['currentPassword'])) {
        if ($_POST['newPassword'] == $_POST['confirmPassword']) {
          $model->changePassword($_SESSION['id'], $_POST['newPassword']);
        } else {
          Session::set('error', 'Passwords do not match.');
        }
      } else {
        Session::set('error', 'Current password not correct.');
      }
    }
    header('Location: ' . ROOT . 'settings');
  }

}
