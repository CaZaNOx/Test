<?php

class Admin extends Controller {

  public function __construct() {
    parent::__construct();
    Session::authenticate(1000);
  }

  public function index() {
    $this->holidays();
  }

  public function holidays($sortField = null, $sortOrder = null) {
    if (is_null($sortField)) $sortField = 'date';
    if (is_null($sortOrder)) $sortOrder = 'asc';
    $model = new AdminModel($this->database);
    $view = new View($this, 'admin/holidays');
    $view->set('sortField', $sortField);
    $view->set('sortOrder', $sortOrder == 'desc' ? 'asc' : 'desc');
    $view->set('holidays', $model->getAllHolidays($sortField, $sortOrder));
    $view->render();
  }

  public function departments($sortField = null, $sortOrder = null) {
    if (is_null($sortField)) $sortField = 'id';
    if (is_null($sortOrder)) $sortOrder = 'asc';
    $model = new AdminModel($this->database);
    $view = new View($this, 'admin/departments');
    $view->set('sortField', $sortField);
    $view->set('sortOrder', $sortOrder == 'desc' ? 'asc' : 'desc');
    $view->set('departments', $model->getAllDepartments($sortField, $sortOrder));
    $view->render();
  }

  public function employees($sortField = null, $sortOrder = null) {
    if (is_null($sortField)) $sortField = 'id';
    if (is_null($sortOrder)) $sortOrder = 'asc';
    $model = new AdminModel($this->database);
    $view = new View($this, 'admin/employees');
    $view->set('sortField', $sortField);
    $view->set('sortOrder', $sortOrder == 'desc' ? 'asc' : 'desc');
    $view->set('employees', $model->getAllEmployees($sortField, $sortOrder));
    $view->render();
  }

  public function edit($object = null, $objectId = null) {
    if (is_null($object) || is_null($objectId)) {
      header('Location: ' . ROOT . 'admin');
    }
    $model = new AdminModel($this->database);
    if ($object == 'employee') {
      $this->editEmployee($objectId, $model);
    } elseif ($object == 'department') {
      $this->editDepartment($objectId, $model);
    } elseif ($object == 'holiday') {
      $this->editHoliday($objectId, $model);
    } else {
      header('Location: ' . ROOT . 'admin');
    }
  }

  public function create($object = null) {
    if (is_null($object)) {
      header('Location: ' . ROOT . 'admin');
    }
    $model = new AdminModel($this->database);
    if ($object == 'employee') {
      $this->createEmployee($model);
    } elseif ($object == 'department') {
      $this->createDepartment($model);
    } elseif ($object == 'holiday') {
      $this->createHoliday($model);
    } else {
      header('Location: ' . ROOT . 'admin');
    }
  }

  public function delete($object = null, $objectId = null) {

    if (isset($_POST['submit']) && !is_null($object) && !is_null($objectId)) {
      $model = new AdminModel($this->database);
      if ($object == 'holiday') {
        $model->deleteHoliday($objectId);
        header('Location: ' . ROOT . 'admin/holidays');
      } else if ($object == 'department') {
        $model->deleteDepartment($objectId);
        header('Location: ' . ROOT . 'admin/departments');
      }
    } else {
      header('Location: ' . ROOT . 'admin/holidays');
    }
  }

  private function editDepartment($objectId, $model) {
    if (isset($_POST['submit'])) {
      $model->editDepartment($_POST['id'], $_POST['name']);
      header('Location: ' . ROOT . 'admin/departments');
    } else {
      $view = new View($this, 'admin/departments/edit');
      $view->set('department', $model->getDepartment($objectId));
      $view->render();
    }
  }

  private function editHoliday($objectId, $model) {
    if (isset($_POST['submit'])) {
      $date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date'])));
      $model->editHoliday($_POST['id'], $_POST['name'], $date);
      header('Location: ' . ROOT . 'admin/holidays');
    } else {
      $view = new View($this, 'admin/holidays/edit');
      $view->set('holiday', $model->getHoliday($objectId));
      $view->render();
    }
  }

  private function editEmployee($objectId, $model) {
    if (isset($_POST['submit'])) {
      $model->editEmployee($_POST['id'], $_POST['idDepartment'], $_POST['username'], $_POST['firstname'],
        $_POST['lastname'], $_POST['password'], $_POST['accessLevel'], $_POST['status']);
      header('Location: ' . ROOT . 'admin/employees');
    } else {
      $view = new View($this, 'admin/employees/edit');
      $view->set('employee', $model->getEmployee($objectId));
      $view->set('departments', $model->getAllDepartments('name','asc'));
      $view->render();
    }
  }

  private function createEmployee($model) {
    if (isset($_POST['submit'])) {
      $model->createEmployee($_POST['username'], $_POST['idDepartment'], $_POST['firstname'], $_POST['lastname'],
        $_POST['password'], $_POST['accessLevel'], $_POST['status']);
      header('Location: ' . ROOT . 'admin/employees');
    } else {
      $view = new View($this, 'admin/employees/create');
      $view->set('departments', $model->getAllDepartments('name','asc'));
      $view->render();
    }
  }

  private function createDepartment($model) {
    if (isset($_POST['submit'])) {
      $model->createDepartment($_POST['name']);
      header('Location: ' . ROOT . 'admin/departments');
    } else {
      $view = new View($this, 'admin/departments/create');
      $view->render();
    }
  }

  private function createHoliday($model) {
    if (isset($_POST['submit'])) {
      $date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date'])));
      $model->createHoliday($_POST['name'], $date);
      header('Location: ' . ROOT . 'admin/holidays');
    } else {
      $view = new View($this, 'admin/holidays/create');
      $view->render();
    }
  }

}