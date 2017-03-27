<?php

function getTable($array) {
  if ($array) {
    echo '<table id="searchTable" class="table table-striped">';
    echo '<thead><tr>';
    foreach ($array[0] as $key => $value) {
      echo '<th>' . $key . '</th>' ;
    }
    echo '</tr></thead>';
    foreach ($array as $row) {
      echo '<tr>';
      foreach ($row as $key => $value) {
        echo '<td>' . $value . '</td>';
      }
      echo '</tr>';
    }
    echo '</table>';
  } else {
    echo '<p>No data to display.</p>';
  }
}

function getTableWithLinks($array, $sortField, $newOrder) {
  if ($array) {
    echo '<table id="searchTable" class="table table-striped">';
    echo '<thead><tr>';
    foreach ($array[0] as $key => $value) {
      if($key != 'action'){
        if($key == $sortField){
          $url = ROOT . $baseUrl . $key . '/' . $newOrder;
        } else {
          $url = ROOT . $baseUrl . $key;
        }
        echo '<th><a href="' . $url . '">' . $key . '</a></th>';
      } else {
        echo '<th>' . $key . '</th>';
      }

    }
    echo '</tr></thead>';
    foreach ($array as $row) {
      echo '<tr>';
      foreach ($row as $key => $value) {
        echo '<td>' . $value . '</td>';
      }
      echo '</tr>';
    }
    echo '</table>';
  } else {
    echo '<p>No data to display.</p>';
  }
}

function labelizeColumn($table, $column) {
  if (isset($table) && isset($table[0][$column])) {
    foreach ($table as $key => $value) {
      $table[$key][$column] = labelizeCell($table[$key][$column]);
    }
  }
  return $table;
}

function buttonizeColumn($table, $column, $action, $url) {
  if (isset($table)) {
    foreach ($table as $key => $value) {
      $link = $url . $value['id'];
      $table[$key][$column] = buttonizeCellLarge($action, $link);
    }
  }
  return $table;
}

function timeDifference($time1, $time2){
  $time1 = explode(':', $time1);
  $time2 = explode(':', $time2);
  $minutes1 = $time1[0] * 60 + $time1[1];
  $minutes2 = $time2[0] * 60 + $time2[1];
  $minutes = abs($minutes1 - $minutes2);
  $hours = (int) ($minutes / 60);
  $minutes = (int) ($minutes % 60);
  $sign = ($minutes2 > $minutes1) ? '-' : '';
  return $sign . sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}

function timeSum($time1, $time2){
  $time1 = explode(':', $time1);
  $time2 = explode(':', $time2);
  $hours = (int) ($time1[0] + $time2[0] + ($time1[1] + $time2[1]) / 60);
  $minutes = (int) (($time1[1] + $time2[1]) % 60);
  return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}


function addTotalAndOvertimeColumn($table) {
  if (isset($table)) {
    foreach ($table as $key => $value) {
      if($table)
      if ($table[$key]['weekday'] != 'Sun') {
        $worked = empty($table[$key]['worked']) ? '00:00' : $table[$key]['worked'];
        $absence = empty($table[$key]['']) ? '00:00' : $table[$key][''];
        $total = timeSum($worked, $absence);
        $schedule = empty($table[$key]['schedule']) ? '00:00' : $table[$key]['schedule'];
        $table[$key]['total'] = $total;
        $table[$key]['overtime'] = timeDifference($total, $schedule);
      } else {
        $table[$key]['total'] = '';
        $table[$key]['overtime'] = '';
      }
    }
  }
  return $table;
}

function overtimeColumn($table) {
  if (isset($table)) {
    foreach ($table as $key => $value) {
      if ($table[$key]['weekday'] != 'Sat' && $table[$key]['weekday'] != 'Sun') {
        if(strtotime($table[$key]['total']) >= strtotime($table[$key]['schedule'])){
          $table[$key]['overtime'] = date('H:i', (strtotime($table[$key]['total']) - 3600) - strtotime($table[$key]['schedule']));
        } else {
          $table[$key]['overtime'] = '- '. date('H:i', strtotime($table[$key]['schedule']) - (strtotime($table[$key]['total']) + 3600));
        }
      } else {
        $table[$key]['overtime'] = '';
      }
    }
  }
  return $table;
}

function buttonizeColumn3($table, $colname, $action1, $url1, $action2, $url2, $action3, $url3) {
  if (isset($table)) {
    foreach ($table as $key => $value) {
      $links = buttonizeCellSmall($action1, $url1 . $value['id']) . ' ';
      $links .= buttonizeCellSmall($action2, $url2 . $value['id']) . ' ';
      $links .= buttonizeCellSmall($action3, $url3 . $value['id']);
      $table[$key][$colname] = $links;
    }
  }
  return $table;
}

function labelizeCell($value) {
  switch (strtolower($value)) {
    case "approved":
    case "active":
      $value = '<span class="label label-success">' . $value . '</span>';
      break;
    case "pending":
    case "disabled":
      $value = '<span class="label label-warning">' . $value . '</span>';
      break;
    case "declined":
    case "deactivated":
      $value = '<span class="label label-danger">' . $value . '</span>';
      break;
  }
  return $value;
}

function buttonizeCellLarge($action, $link) {
  switch ($action) {
    case "approve":
      $action = '<a href=' . ROOT . $link . ' class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span> ' . $action . '</a>';
      break;
    case "decline":
      $action = '<a href=' . ROOT . $link . ' class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> ' . $action . '</a>';
      break;
    case "edit":
      $action = '<a href=' . ROOT . $link . ' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span> ' . $action . '</a>';
      break;
    case "view":
      $action = '<a href=' . ROOT . $link . ' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-search"></span> ' . $action . '</a>';
      break;
  }
  return $action;
}

function buttonizeCellSmall($action, $link) {
  switch ($action) {
    case "approve":
      $action = '<a href=' . ROOT . $link . ' class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></a>';
      break;
    case "decline":
      $action = '<a href=' . ROOT . $link . ' class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a>';
      break;
    case "edit":
      $action = '<a href=' . ROOT . $link . ' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></a>';
      break;
    case "view":
      $action = '<a href=' . ROOT . $link . ' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-search"></span></a>';
      break;
  }
  return $action;
}
