<?php

class UserModel extends Model{

  public function login($username, $password) {
    $user = $this->getUserByUsername($username);
    if ($user && $this->checkPassword($user, $password)) {
      return $user;
    } else {
      return false; // password incorrect or user not found
    }
  }

  public function getUserByUsername($username) {
    try {
      $sql = "SELECT idEmployee AS id, username, firstname, lastname, password, accessLevel, status, showMessages ";
      $sql .= "FROM Employee WHERE username = :username ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':username' => $username));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      echo 'ERROR: ' . $ex->getMessage();
      return null;
    }
  }

  public function checkPassword($user, $password) {
    return $user->password == $password;
  }

  public function getUserByUserId($userId) {
    try {
      $sql = "SELECT idEmployee AS id, username, firstname, lastname, password, accessLevel, status ";
      $sql .= "FROM Employee WHERE idEmployee = :userId ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':userId' => $userId));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function changePassword($userId, $password) {
    try {
      $sql = "UPDATE Employee SET password = :password ";
      $sql .= "WHERE idEmployee = :userId ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':userId' => $userId, ':password' => $password));
      $_SESSION['success'] = 'Successfully changed password.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  public function updateLastLogin($userId) {
    try {
      $sql = "UPDATE Employee SET lastLogin = NOW() WHERE idEmployee = :userId;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':userId' => $userId));
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }
}
