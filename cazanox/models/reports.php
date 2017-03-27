<?php

class ReportsModel extends Model {

  public function getMonthName($month) {
    $dateObj = DateTime::createFromFormat('!m', $month);
    return $dateObj->format('F');
  }

  public function getFirstDayOfWeek($year, $week) {
    return date('j M Y', strtotime($year . 'W' . sprintf('%02d', $week) . '1'));
  }

  public function getLastDayOfWeek($year, $week) {
    return date('j M Y', strtotime($year . 'W' . sprintf('%02d', $week) . '7'));
  }

  public function getFirstDayOfMonth($year, $month) {
    return date('j M Y', strtotime("$year-$month-1"));
  }

  public function getLastDayOfMonth($year, $month) {
    return date('t M Y', strtotime("$year-$month-1"));
  }

  public function getFirstDayOfYear($year) {
    return date('j M Y', strtotime("$year-1-1"));
  }

  public function getLastDayOfYear($year) {
    return date('t M Y', strtotime("$year-12-1"));
  }

  public function getNextWeekUrl($year, $week) {
    if ($week == 52) {
      $week = 1;
      $year++;
    } else {
      $week++;
    }
    return ROOT . 'reports/week/' . $year . '/' . $week;
  }

  public function getLastWeekUrl($year, $week) {
    if ($week == 1) {
      $week = 52;
      $year--;
    } else {
      $week--;
    }
    return ROOT . 'reports/week/' . $year . '/' . $week;
  }

  public function getNextMonthUrl($year, $month) {
    if ($month == 12) {
      $month = 1;
      $year++;
    } else {
      $month++;
    }
    return ROOT . 'reports/month/' . $year . '/' . $month;
  }

  public function getLastMonthUrl($year, $month) {
    if ($month == 1) {
      $month = 12;
      $year--;
    } else {
      $month--;
    }
    return ROOT . 'reports/month/' . $year . '/' . $month;
  }

  public function getNextYearUrl($year) {
    $year += 1;
    return ROOT . 'reports/year/' . $year;
  }

  public function getLastYearUrl($year) {
    $year -= 1;
    return ROOT . 'reports/year/' . $year;
  }

  public function getMonthOverview($idEmployee, $year, $month) {
    try {
      $sql = "SELECT DATE_FORMAT(date, '%a') AS weekday, ";
      $sql .= "DATE_FORMAT(date, '%d/%m/%Y') AS date, ";
      $sql .= "DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(end)-TIME_TO_SEC(begin))), '%H:%i') as worked, ";
      $sql .= "DATE_FORMAT(GET_SCHEDULE(date, :idEmployee), '%H:%i') AS schedule, ";
      $sql .= "GET_ABSENCE(date, :idEmployee) AS absence, ";
      $sql .= "CASE WHEN GET_ABSENCE(date, :idEmployee) IS NOT NULL THEN DATE_FORMAT(GET_SCHEDULE(date, :idEmployee), '%H:%i') ELSE '' END AS absenceTime ";
      $sql .= "FROM WorkingHours ";
      $sql .= "RIGHT JOIN Calendar ON (DATE(begin) = date AND idEmployee = :idEmployee) ";
      $sql .= "WHERE YEAR(date) = :year AND MONTH(date) = :month ";
      $sql .= "GROUP BY DATE;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':month' => $month, ':year' => $year));
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getWeekOverview($idEmployee, $year, $week) {
    try {
      $sql = "SELECT DATE_FORMAT(date, '%W') AS weekday, ";
      $sql .= "DATE_FORMAT(date, '%d/%m/%Y') AS date, ";
      $sql .= "DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(end)-TIME_TO_SEC(begin))), '%H:%i') as worked, ";
      $sql .= "DATE_FORMAT(GET_SCHEDULE(date, :idEmployee), '%H:%i') AS schedule, ";
      $sql .= "GET_ABSENCE(date, :idEmployee) AS absence, ";
      $sql .= "CASE WHEN GET_ABSENCE(date, :idEmployee) IS NOT NULL THEN DATE_FORMAT(GET_SCHEDULE(date, :idEmployee), '%H:%i') ELSE '' END AS absenceTime ";
      $sql .= "FROM WorkingHours RIGHT JOIN Calendar ON (DATE(begin) = date AND idEmployee = :idEmployee) ";
      $sql .= "WHERE YEAR(date) = :year AND WEEK(date, 1) = :week AND WEEKDAY(date) <> '6' GROUP BY DATE; ";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':week' => $week, ':year' => $year));
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getWeekWorkingPeriods($idEmployee, $year, $week){
    try {
      $sql = "SELECT WEEKDAY(begin) AS weekday, CONCAT('1970-01-01 ', TIME(begin)) AS begin, CONCAT('1970-01-01 ', TIME(end)) AS end FROM WorkingHours ";
      $sql .= "WHERE YEAR(begin) = :year AND WEEK(begin, 1) = :week AND idEmployee = :idEmployee ORDER BY weekday;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':week' => $week, ':year' => $year));
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }
  }

  public function getYearOverview($idEmployee, $year){
    try{
      $sql = "SELECT DATE_FORMAT(TIMEDIFF(end, begin), '%H:%i') AS total ";
      $sql .= "FROM WorkingHours RIGHT JOIN Calendar ON (DATE(begin) = date AND idEmployee = :idEmployee) ";
      $sql .= "WHERE YEAR(date) = :year GROUP BY date;";
      $query = $this->database->prepare($sql);
      $query->execute(array(':idEmployee' => $idEmployee, ':year' => $year));
      return $query->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
      $_SESSION['error'] = $ex->getMessage();
      return null;
    }

  }

}
