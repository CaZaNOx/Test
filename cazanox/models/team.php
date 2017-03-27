<?php

class TeamModel extends Model{

  private $year;

  public function __construct(PDO $database, $year) {
    $this->database = $database;
    $this->year = $year;
  }

  public function __destruct() {
    $this->database = null;
  }

  public function setDate($year = null) {
    $year == null ? $this->year = date('Y') : $this->year = $year;
  }

  public function getYear() {
    return $this->year;
  }

  public function getFirstDayOfYear($year) {
    return date('j M Y', strtotime("$year-1-1"));
  }

  public function getLastDayOfYear($year) {
    return date('t M Y', strtotime("$year-12-1"));
  }

  public function getPrevYearUrl($department, $year) {
    $year--;
    return ROOT . 'team/show/' . $department . '/' . $year;
  }

  public function getNextYearUrl($department, $year) {
    $year++;
    return ROOT . 'team/show/' . $department . '/'. $year;
  }

  public function getTeam($department) {
    try {
      if($department == "all"){
        $sql = "SELECT CONCAT(firstname, ' ', lastname) AS name FROM Employee WHERE status <> 'Deleted';";
        $query = $this->database->prepare($sql);
        $query->execute();
      } else {
        $sql = "SELECT CONCAT(firstname, ' ', lastname) AS name FROM Employee, Department ";
        $sql .= "WHERE Department.idDepartment = Employee.idDepartment AND name = :department AND status <> 'Deleted';";
        $query = $this->database->prepare($sql);
        $query->execute(array(':department' => $department));
      }
      return $query->fetchAll(PDO::FETCH_COLUMN, 0);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getAbsences($department, $year) {
    try {
      if ($department == "all") {
        $sql = "SELECT CONCAT(firstname, ' ', lastname) AS name, type, begin, end FROM Absences, Employee ";
        $sql .= "WHERE Absences.idEmployee = Employee.idEmployee AND Employee.status <> 'Deleted' ";
        $sql .= "AND :year BETWEEN YEAR(begin) AND YEAR(end) AND Absences.status='Approved' ORDER BY Absences.status, name;";
        $query = $this->database->prepare($sql);
        $query->execute(array(':year' => $year));
      } else {
        $sql = "SELECT CONCAT(firstname, ' ', lastname) AS name, type, begin, end FROM Absences, Employee, Department ";
        $sql .= "WHERE Absences.idEmployee = Employee.idEmployee AND Employee.idDepartment = Department.idDepartment AND Employee.status <> 'Deleted' ";
        $sql .= "AND :year BETWEEN YEAR(begin) AND YEAR(end) AND Absences.status='Approved' AND name=:department ORDER BY Absences.status, name;";
        $query = $this->database->prepare($sql);
        $query->execute(array(':year' => $year, ':department' => $department));
      }
      return $this->groupArray($query->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getDepartments(){
    try {
      $sql = "SELECT name FROM Department; ";
      $query = $this->database->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  private function groupArray($array){
    $return = array();
    foreach($array as $key => $value){
      $return[$value['type']][$key] = $value;
    }
    return $return;
  }
}
