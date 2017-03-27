<div class="content-nav">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href=<?php echo ROOT . "reports/week"; ?>>Week</a></li>
    <li role="presentation" class="active"><a href=<?php echo ROOT . "reports/month"; ?>>Month</a></li>
    <li role="presentation"><a href=<?php echo ROOT . "reports/year"; ?>>Year</a></li>
  </ul>
</div>

<div class="row">
  <div class="col-md-5 text-right"><a href="<?php echo $this->get('lastMonthUrl'); ?>"><span
        class="glyphicon glyphicon-chevron-left nav-arrow"></span></a></div>
  <div class="col-md-2 text-center">
    <h3><?php echo $this->get('monthName'); ?></h3>

    <p><?php echo $this->get('firstDayOfMonth') . ' - ' . $this->get('lastDayOfMonth'); ?></p>
  </div>
  <div class="col-md-5 text-left"><a href="<?php echo $this->get('nextMonthUrl'); ?>"><span
        class="glyphicon glyphicon-chevron-right nav-arrow"></span></a></div>
</div>
<div class="row">
  <div class="panel panel-default">
    <table class="table table-striped">
    <thead>
    <tr>
      <th>weekday</th>
      <th>date</th>
      <th>worked</th>
      <th>schedule</th>
      <th>absence</th>
      <th></th>
      <th class="text-right">total</th>
      <th class="text-right">overtime</th>
    </tr>
    </thead>
    <?php
    $overtimeColumn = Array();
    $totalSum = '00:00';
    $overtimeSum = '00:00';
    foreach($this->reports as $report){
      $total = $this->timeSum($report->worked, $report->absenceTime);
      $overtime = $this->timeDifference($total, $report->schedule);
      $totalSum = $this->timeSum($totalSum, $total);
      $OvertimeSum = $this->timeSum($overtimeSum, $overtime);
      $time = floatval(str_replace(':','.',$overtime));
      array_push($overtimeColumn, $time);
      echo '<tr>';
      echo '<td>' . $report->weekday . '</td>';
      echo '<td>' . $report->date . '</td>';
      echo '<td>' . $report->worked . '</td>';
      echo '<td>' . $report->schedule . '</td>';
      echo '<td>' . $report->absence . '</td>';
      echo '<td>' . $report->absenceTime . '</td>';
      echo '<td class="text-right">' . ($report->weekday != 'Sun' ? $total : '') . '</td>';
      echo '<td class="text-right">' . ($report->weekday != 'Sun' ? $overtime : '') . '</td>';
      echo '</tr>';
    }
    ?>
    </table>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-6">
          <strong>Total/Month</strong> <br />
          <strong>Overtime/Month</strong>
        </div>
        <div class="col-md-6 text-right">
          <strong><?php echo $totalSum; ?></strong><br />
          <strong><?php echo $overtimeSum; ?></strong>
        </div>
      </div>
    </div>
  </div>
</div>

