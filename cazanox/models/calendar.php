<?php

class CalendarModel extends Model{

  private $year;
  private $week;

  public function __construct(PDO $database, $year = null, $week = null) {
    $this->database = $database;
    $this->year = $year;
    $this->week = $week;
  }

  public function __destruct() {
    $this->database = null;
  }

  public function getPeriods($userId, $year, $week) {
    try {
      $sql = "SELECT DATE(begin) AS date, DATE_FORMAT(begin, '%H:%i') AS begin, DATE_FORMAT(end, '%H:%i') AS end ";
      $sql .= "FROM WorkingHours WHERE idEmployee = :userId AND WEEK(begin , 1) = :week AND YEAR(begin) = :year;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':userId' => $userId, ':week' => $week, ':year' => $year));
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      return $this->sortArrayByDate($result);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  private function sortArrayByDate($array) {
    $sorted = array();
    foreach ($array as $key => $item) {
      $sorted[$item['date']][$key] = $item;
    }
    ksort($sorted, SORT_NUMERIC);
    return $sorted;
  }

  public function getSum($userId, $year, $week) {
    try {
      $sql = "SELECT DATE(begin) AS date, DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(end)-TIME_TO_SEC(begin))), '%H:%i') as sum ";
      $sql .= "FROM WorkingHours WHERE idEmployee = :userId AND WEEK(begin , 1) = :week AND YEAR(begin) = :year ";
      $sql .= "GROUP BY YEAR(begin), MONTH(begin), DAY(begin);";
      $query = $this->database->prepare($sql);
      $query->execute(array(':userId' => $userId, ':week' => $week, ':year' => $year));
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getSchedule($userId, $year, $week) {
    try {
      $sql = "SELECT date, DATE_FORMAT(GET_SCHEDULE(date, :userId), '%H:%i') AS schedule ";
      $sql .= "FROM Calendar WHERE YEAR(date) = :year AND WEEKOFYEAR(date) = :week;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':userId' => $userId, ':week' => $week, ':year' => $year));
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getNotes($idEmployee, $year, $week) {
    try {
      $sql = "SELECT idNotes, date, note FROM Notes WHERE idEmployee = :idEmployee AND YEAR(date) = :year AND WEEK(date, 1) = :week ;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':year' => $year, ':week' => $week));
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getSettings($idEmployee) {
    try {
      $sql = "SELECT showNotes, numOfPeriods FROM Employee WHERE idEmployee = :idEmployee;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee));
      return $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function saveIntervals($idEmployee, $date, $periods) {
    try {
      $this->database->beginTransaction();
      $sql = "DELETE FROM WorkingHours WHERE idEmployee = :idEmployee AND DATE(begin) = :date;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':date' => $date));
      foreach ($periods as $period) {
        if (!empty($period[0])) {
          $sql = "INSERT INTO WorkingHours (idEmployee, begin, end) VALUES (:idEmployee, :begin, :end);";
          $query = $this->database->prepare($sql);
          $query->execute(array(':idEmployee' => $idEmployee, ':begin' => $date . ' ' . $period[0], ':end' => $date . ' ' . $period[1]));
        }
      }
      $this->database->commit();
    } catch (PDOException $ex) {
      $this->database->rollBack();
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  public function saveNote($idEmployee, $date, $note) {
    try {
      $this->database->beginTransaction();
      $sql = "DELETE FROM Notes WHERE idEmployee = :idEmployee AND DATE(date) = :date;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':date' => $date));
      if (!empty($note)) {
        $sql = "INSERT INTO Notes (idEmployee, date, note) VALUES (:idEmployee, :date, :note);";
        $query = $this->database->prepare($sql);
        $query->execute(array(':idEmployee' => $idEmployee, ':date' => $date, ':note' => $note));
      }
      $this->database->commit();
    } catch (PDOException $ex) {
      $this->database->rollBack();
      $_SESSION['error'] = $ex->getMessage();
    }
  }

  public function getPeriod() {
    $start = date('d/m/Y', strtotime($this->year . "W" . $this->week . "1"));
    $end = date('d/m/Y', strtotime($this->year . "W" . $this->week . "7"));
    return $start . ' - ' . $end;
  }

  public function getUrls($year, $week) {
    return array($this->prevWeekUrl($year, $week), $this->currentWeekUrl(), $this->nextWeekUrl($year, $week));
  }

  private function prevWeekUrl($year, $week) {
    if ($week == 1) {
      $year--;
      $week = 52;
    } else {
      $week--;
    }
    return ROOT . 'calendar/week/' . $year . '/' . $week;
  }

  private function currentWeekUrl() {
    $year = (int) date('Y');
    $week = (int) date('W');
    return ROOT . 'calendar/week/' . $year . '/' . $week;
  }

  private function nextWeekUrl($year, $week) {
    if ($week == 52) {
      $year++;
      $week = 1;
    } else {
      $week++;
    }
    return ROOT . 'calendar/week/' . $year . '/' . $week;
  }
}
