<?php

class ManageModel extends Model{

  public function getAllAbsences($sortField, $sortOrder) {
    try {
      $sortField = $this->wrapInUnixTimeStapIfNeeded($sortField);
      $sql = "SELECT idAbsences AS id, DATE_FORMAT(Absences.creation, '%d/%m/%Y - %H:%i') AS creation, firstname, lastname, ";
      $sql .= "type, DATE_FORMAT(begin, '%d/%m/%Y') AS begin, DATE_FORMAT(end, '%d/%m/%Y') AS end, Absences.status as status ";
      $sql .= "FROM Absences INNER JOIN Employee ON Absences.idEmployee = Employee.idEmployee AND Employee.status <> 'Deleted'";
      $sql .= "ORDER BY " .$sortField . ' ' .$sortOrder . ";";
      $query = $this->database->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getAbsences($status, $sortField, $sortOrder) {
    try {
      $sortField = $this->wrapInUnixTimeStapIfNeeded($sortField);
      $sql = "SELECT idAbsences AS id, DATE_FORMAT(Absences.creation, '%H:%i:%s %d/%m/%Y') AS creation, firstname, lastname, ";
      $sql .= "type, DATE_FORMAT(begin, '%d/%m/%Y') AS begin, DATE_FORMAT(end, '%d/%m/%Y') AS end, Absences.status as status ";
      $sql .= "FROM Absences INNER JOIN Employee ON Absences.idEmployee = Employee.idEmployee ";
      $sql .= "WHERE Absences.status = :status AND Employee.status <> 'Deleted' ORDER BY " .$sortField . ' ' .$sortOrder . ";";
      $query = $this->database->prepare($sql);
      $query->execute(array(':status' => $status));
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getAbsence($absenceId) {
    try {
      $sql = "SELECT Absences.idAbsences AS id, DATE_FORMAT(Absences.creation, '%H:%i:%s %d/%m/%Y') AS creation, firstname, lastname, type, notes, DATE_FORMAT(begin, '%d/%m/%Y') AS begin, DATE_FORMAT(end, '%d/%m/%Y') AS end ";
      $sql .= "FROM Absences INNER JOIN Employee ON Absences.idEmployee = Employee.idEmployee ";
      $sql .= "WHERE Absences.idAbsences = :absenceId ";
      $query = $this->database->prepare($sql);
      $query->execute(array(':absenceId' => $absenceId));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function editAbsence($userId, $absenceId, $status) {
    try {
      $sql = "UPDATE Absences SET status = :status ";
      $sql .= "WHERE idAbsences = :absenceId;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':absenceId' => $absenceId, ':status' => $status));
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
    }
  }

}
