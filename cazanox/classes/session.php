<?php
/**
* User Session Class
*/
class Session {

  public function __construct() {

  }

  public static function init() {
    session_start();
  }

  public static function destroy() {
    session_unset();
    session_destroy();
  }

  public static function set($key, $value) {
    $_SESSION[$key] = $value;
  }

  public static function setList($list) {
    foreach($list as $key=>$value) {
      Session::set($key, $value);
    }
  }

  public static function get($key) {
    return $_SESSION[$key];
  }

  public static function setUserId($userId){
    $_SESSION['id'] = $userId;
  }

  public static function getUserId(){
    return $_SESSION['id'];
  }

  public static function authenticate($accessLevel = 10) {
    if (!isset($_SESSION['accessLevel']) || Session::sessionIsExpired()) {
      //Session::destroy();
      header('Location: ' . ROOT . 'user/index');
      exit();
    } elseif ($_SESSION['accessLevel'] < $accessLevel) {
      header('Location: ' . ROOT . 'error/page401');
      exit();
    }
  }

  public static function getMessage($messageType) {
    if(isset($_SESSION[$messageType])){
      return $_SESSION[$messageType];
    } else {
      return false;
    }
  }

  public static function removeMessage($messageType) {
    unset($_SESSION[$messageType]);
  }

  private static function sessionIsExpired() {
    if (isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] < 1800)) {
      $_SESSION['lastActivity'] = time();
      return false;
    }
    Session::set('warning', 'Session expired.');
    return true;
  }
}
