<?php

class User extends Controller {

  public function index() {
    $view = new View($this, 'user/login');
    $view->render(true);
  }

  public function login() {
    $model = new UserModel($this->database);
    $user = $model->login($_POST['username'], $_POST['password']);
    if ($user && $user->status != 'Deleted') {
      if ($user->status == 'Active') {
        $model->updateLastLogin($user->id);
        Session::set('username', $user->username);
        Session::set('id', $user->id);
        Session::set('accessLevel', $user->accessLevel);
        Session::set('lastActivity', time());
        header('Location: ' . ROOT . 'calendar');
      } else {
        Session::set('error', 'User disabled.');
        header('Location: ' . ROOT . 'user/index');
      }
    } else {
      Session::set('error', 'Incorrect username or password.');
      header('Location: ' . ROOT . 'user/index');
    }
  }

  public function logout() {
    Session::destroy();
    header('Location: ' . ROOT . 'user/index');
  }

}
