<?php

class SettingsModel extends Model{

  public function getAllEmploymentLevel($idEmployee, $sortField, $sortOrder) {
    try {
      $sortField = $this->wrapInUnixTimeStapIfNeeded($sortField);
      $sql = "SELECT idEmploymentLevel AS id, DATE_FORMAT(begin, '%d/%m/%Y') AS begin, DATE_FORMAT(end, '%d/%m/%Y') AS end, level ";
      $sql .= "FROM EmploymentLevel WHERE idEmployee = :idEmployee ORDER BY $sortField $sortOrder;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee));
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getEmploymentLevel($idEmploymentLevel) {
    try {
      $sql = "SELECT idEmploymentLevel AS id, DATE_FORMAT(begin, '%d/%m/%Y') AS begin, DATE_FORMAT(end, '%d/%m/%Y') AS end, level ";
      $sql .= "FROM EmploymentLevel WHERE idEmploymentLevel = :idEmploymentLevel ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmploymentLevel' => $idEmploymentLevel));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function createEmploymentLevel($idEmployee, $begin, $end, $level, $schedule = array()) {
    $begin = date('Y-m-d', strtotime(str_replace('/', '-', $begin)));
    $end = date('Y-m-d', strtotime(str_replace('/', '-', $end)));
    $schedule = $this->cleanUpSchedule($schedule);
    try {
      $sql = "INSERT INTO EmploymentLevel (idEmployee, begin, end, level, monday, tuesday, wednesday, thursday, friday, saturday) ";
      $sql .="VALUES (:idEmployee, :begin, :end, :level, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday);";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':begin' => $begin, ':end' => $end, ':level' => $level,
      ':monday' => $schedule[0], ':tuesday' => $schedule[1], ':wednesday' => $schedule[2], ':thursday' => $schedule[3],
        ':friday' => $schedule[4],':saturday' => $schedule[5]));
      $_SESSION['success'] = 'Successfully created Employment Level.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  public function editEmploymentLevel($idEmploymentLevel, $begin, $end, $level) {
    $begin = date('Y-m-d', strtotime(str_replace('/', '-', $begin)));
    $end = date('Y-m-d', strtotime(str_replace('/', '-', $end)));
    try {
      $sql = "UPDATE EmploymentLevel SET begin = :begin, end = :end, level = :level ";
      $sql .= "WHERE idEmploymentLevel = :idEmploymentLevel;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmploymentLevel' => $idEmploymentLevel, ':begin' => $begin, ':end' => $end, ':level' => $level));
      $_SESSION['success'] = 'Successfully edit Employment Level.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  public function deleteEmploymentLevel($idEmploymentLevel) {
    try {
      $sql = "DELETE FROM EmploymentLevel WHERE idEmploymentLevel = :idEmploymentLevel;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmploymentLevel' => $idEmploymentLevel));
      $_SESSION['success'] = 'Successfully deleted Employment Level.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  public function getSettings($idEmployee) {
    try {
      $sql = "SELECT numOfPeriods, showNotes, showMessages FROM Employee WHERE idEmployee = :idEmployee ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function editSettings($idEmployee, $numOfPeriods, $showNotes, $showMessages) {
    try {
      $sql = "UPDATE Employee SET numOfPeriods = :numOfPeriods, showNotes = :showNotes, showMessages = :showMessages ";
      $sql .= "WHERE idEmployee = :idEmployee ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':numOfPeriods' => $numOfPeriods, ':showNotes' => $showNotes, ':showMessages' => $showMessages));
      Session::set('showMessages', $showMessages);
      $_SESSION['success'] = 'Successfully saved new settings.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  private function cleanUpSchedule($schedule = array()){
    $cleanUp = array();
    for($i = 0; $i < 12; $i += 2){
      $hour = empty($schedule[$i]) ? 0 : $schedule[$i];
      $minute = empty($schedule[$i+1]) ? 0 : $schedule[$i+1];
      array_push($cleanUp, $hour . ':' . $minute);
    }
    return $cleanUp;
  }


}
