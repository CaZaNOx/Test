<?php

class AdminModel extends Model{

  public function getAllEmployees($sortField, $sortOrder) {
    try {
      $sortField = $this->wrapInUnixTimeStapIfNeeded($sortField);
      $sql = "SELECT idEmployee AS id, name as department, username, firstname, lastname, accessLevel, DATE_FORMAT(userCreation, '%d/%m/%Y') AS userCreation, DATE_FORMAT(lastLogin, '%H:%i:%s  %d/%m/%Y') AS lastLogin, status ";
      $sql .= "FROM Employee LEFT JOIN Department ON Employee.idDepartment = Department.idDepartment ORDER BY $sortField $sortOrder;";
      $query = $this->database->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }


  public function getEmployee($idEmployee) {
    try {
      $sql = "SELECT idEmployee AS id, name as department, username, firstname, lastname, password, accessLevel, status ";
      $sql .= "FROM Employee LEFT JOIN Department ON Employee.idDepartment = Department.idDepartment WHERE idEmployee = :idEmployee ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function createEmployee($username, $idDepartment, $firstname, $lastname, $password, $accessLevel, $status) {
    try {
      $sql = "INSERT INTO Employee (username, idDepartment, firstname, lastname, password, accessLevel, status) VALUES (:username, :idDepartment, :firstname, :lastname, :password, :accessLevel, :status);";
      $query = $this->database->prepare($sql);

      $query->execute(array(':username' => $username, ':idDepartment' => $idDepartment, ':firstname' => $firstname,
        ':lastname' => $lastname, 'password' => $password, ':accessLevel' => $accessLevel, ':status' => $status));
      $_SESSION['success'] = 'Successfully created Employee "' . $username . '".';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function editEmployee($userId, $idDepartment, $username, $firstname, $lastname, $password, $accessLevel, $status) {
    try {
      $sql = "UPDATE Employee SET username = :username, idDepartment = :idDepartment, firstname = :firstname, lastname = :lastname, password = :password, accessLevel = :accessLevel, status= :status WHERE idEmployee = :userId LIMIT 1;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':userId' => $userId, ':idDepartment' => $idDepartment, ':username' => $username, ':firstname' => $firstname,
        ':lastname' => $lastname, 'password' => $password, ':accessLevel' => $accessLevel, ':status' => $status));
      $_SESSION['success'] = 'Successfully edited Employee "' . $username . '".';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getAllDepartments($sortField, $sortOrder) {
    try {
      $sortField = $this->wrapInUnixTimeStapIfNeeded($sortField);
      $sql = "SELECT Department.idDepartment AS id, name, COUNT(Employee.idDepartment) AS members FROM Department LEFT JOIN Employee ON (Department.idDepartment = Employee.idDepartment) GROUP BY name ORDER BY $sortField $sortOrder;";
      $query = $this->database->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getDepartment($idDepartment) {
    try {
      $sql = "SELECT idDepartment AS id, name FROM Department WHERE idDepartment = :idDepartment;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idDepartment' => $idDepartment));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function createDepartment($name) {
    try {
      $sql = "INSERT INTO Department (name) VALUES (:name);";
      $query = $this->database->prepare($sql);
      $query->execute(array(':name' => $name));
      $_SESSION['success'] = 'Successfully created Department "' . $name . '".';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function editDepartment($idDepartment, $name) {
    try {
      $sql = "UPDATE Department SET name = :name WHERE idDepartment = :idDepartment LIMIT 1 ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idDepartment' => $idDepartment, ':name' => $name));
      $_SESSION['success'] = 'Successfully edited Department "' . $name . '".';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function deleteDepartment($idDepartment) {
    try {
      $sql = "DELETE FROM Department WHERE idDepartment = :idDepartment;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idDepartment' => $idDepartment));
      $_SESSION['success'] = 'Successfully deleted Department.';
    } catch (PDOException $ex) {

      $_SESSION['error'] = 'Department not empty!'; //$ex->getMessage();
      return null;
    }
  }

  public function getAllHolidays($sortField, $sortOrder) {
    try {
      $sortField = $this->wrapInUnixTimeStapIfNeeded($sortField);
      $sql = "SELECT idHoliday AS id, DATE_FORMAT(date, '%d/%m/%Y') AS date, name ";
      $sql .= "FROM Holiday ORDER BY $sortField $sortOrder;";
      $query = $this->database->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getHoliday($idHoliday) {
    try {
      $sql = "SELECT idHoliday AS id, DATE_FORMAT(date, '%d/%m/%Y') AS date, name ";
      $sql .= "FROM Holiday WHERE idHoliday = :idHoliday;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idHoliday' => $idHoliday));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function createHoliday($name, $date) {
    try {
      $sql = "INSERT INTO Holiday (name, date) VALUES (:name, :date);";
      $query = $this->database->prepare($sql);
      $query->execute(array(':name' => $name, ':date' => $date));
      $_SESSION['success'] = 'Successfully created Holiday "' . $name . '".';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function editHoliday($idHoliday, $name, $date) {
    try {
      $sql = "UPDATE Holiday SET Holiday.name = :name, Holiday.date = :date WHERE Holiday.idHoliday = :idHoliday LIMIT 1 ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idHoliday' => $idHoliday, ':name' => $name, ':date' => $date));
      $_SESSION['success'] = 'Successfully edited Holiday "' . $name . '".';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function deleteHoliday($idHoliday) {
    try {
      $sql = "DELETE FROM  Holiday WHERE idHoliday = :idHoliday;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idHoliday' => $idHoliday));
      $_SESSION['success'] = 'Successfully deleted Holiday.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

} 