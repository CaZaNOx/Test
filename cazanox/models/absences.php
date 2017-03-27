<?php

class AbsencesModel extends Model{

  public function getAllAbsences($idEmployee, $sortField, $sortOrder) {
    try {
      $sortField = $this->wrapInUnixTimeStapIfNeeded($sortField);
      $sql = "SELECT idAbsences AS id, type, DATE_FORMAT(creation, '%d/%m/%Y') AS creation, DATE_FORMAT(begin, '%d/%m/%Y') AS begin, DATE_FORMAT(end, '%d/%m/%Y') AS end, NUM_OF_WEEKDAYS(begin, end) AS days, status ";
      $sql .= "FROM Absences WHERE idEmployee = :idEmployee ORDER BY $sortField $sortOrder;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee));
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getAbsences($idEmployee, $status, $sortField, $sortOrder) {
    try {
      $sortField = $this->wrapInUnixTimeStapIfNeeded($sortField);
      $sql = "SELECT idAbsences AS id, type, DATE_FORMAT(creation, '%H:%i:%s %d/%m/%Y') AS creation, DATE_FORMAT(begin, '%d/%m/%Y') AS begin, DATE_FORMAT(end, '%d/%m/%Y') AS end, NUM_OF_WEEKDAYS(begin, end) AS days, status ";
      $sql .= "FROM Absences WHERE idEmployee = :idEmployee AND status = :status ORDER BY $sortField $sortOrder;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':status' => $status));
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function createAbsence($idEmployee, $type, $begin, $end, $notes) {
    try {
      $sql = "INSERT INTO Absences (idEmployee, type, begin, end, notes) VALUES (:idEmployee, :type, :begin, :end, :notes);";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':type' => $type, ':begin' => $begin, ':end' => $end, ':notes' => $notes));
      $_SESSION['success'] = 'Successfully created Absence.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  public function getAbsence($idAbsences) {
    try {
      $sql = "SELECT idAbsences AS id, type, notes, DATE_FORMAT(begin, '%d/%m/%Y') AS begin, DATE_FORMAT(end , '%d/%m/%Y') AS end ";
      $sql .= "FROM Absences WHERE idAbsences = :idAbsences ";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idAbsences' => $idAbsences));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function editAbsence($idAbsences, $type, $begin, $end, $notes) {
    $begin = date('Y-m-d', strtotime(str_replace('/', '-', $begin)));
    $end = date('Y-m-d', strtotime(str_replace('/', '-', $end)));
    try {
      $sql = "UPDATE fleXtime.Absences SET Absences.type = :type, Absences.begin = :begin, Absences.end = :end, Absences.notes =:notes ";
      $sql .= "WHERE idAbsences = :idAbsences;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idAbsences' => $idAbsences, ':type' => $type, ':begin' => $begin, ':end' => $end, ':notes' => $notes));
      $_SESSION['success'] = 'Successfully edited Absence.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  public function deleteAbsence($idAbsences) {
    try {
      $sql = "DELETE FROM Absences WHERE idAbsences = :idAbsences;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idAbsences' => $idAbsences));
      $_SESSION['success'] = 'Successfully deleted Abscence.';
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }
}
