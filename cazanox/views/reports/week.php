<script src="<?php echo ROOT . "assets/js/highcharts.js"; ?>"></script>
<script src="<?php echo ROOT . "assets/js/highcharts-more.js"; ?>"></script>


<div class="content-nav">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href=<?php echo ROOT . "reports/week"; ?>>Week</a></li>
    <li role="presentation"><a href=<?php echo ROOT . "reports/month"; ?>>Month</a></li>
    <li role="presentation"><a href=<?php echo ROOT . "reports/year"; ?>>Year</a></li>
  </ul>
</div>

<div class="row">
  <div class="col-md-5 text-right"><a href="<?php echo $this->get('lastWeekUrl'); ?>"><span
        class="glyphicon glyphicon-chevron-left nav-arrow"></span></a></div>
  <div class="col-md-2 text-center">
    <h3><?php echo 'Week ' . $this->get('week'); ?></h3>

    <p><?php echo $this->get('firstDayOfWeek') . ' - ' . $this->get('lastDayOfWeek'); ?></p>
  </div>
  <div class="col-md-5 text-left"><a href="<?php echo $this->get('nextWeekUrl'); ?>"><span
        class="glyphicon glyphicon-chevron-right nav-arrow"></span></a></div>
</div>
<div class="row">





  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    </ol>

    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Overtime per Week</h3>
          </div>
          <div class="panel-body">
            <div id="overtime"></div>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Working Periods</h3>
          </div>
          <div class="panel-body">
            <div id="workingHours"></div>
          </div>
        </div>
      </div>
    </div>

    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>




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
        echo '<td class="text-right">' . $total . '</td>';
        echo '<td class="text-right">' . $overtime . '</td>';
        echo '</tr>';

      }
      ?>
    </table>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-6">
          <strong>Total/Week</strong> <br />
          <strong>Overtime/Week</strong>
        </div>
        <div class="col-md-6 text-right">
          <strong><?php echo $totalSum; ?></strong><br />
          <strong><?php echo $overtimeSum; ?></strong>
        </div>
      </div>
    </div>
    </div>
  </div>

</div>


<script>
  $('.carousel').carousel({
    interval: false
  })

  $(function () {
    $('#overtime').highcharts({
      chart: {
        type: 'area',
        backgroundColor: 'rgba(255, 255, 255, 0.1)',
        height: 300,
        width: 1108
      },
      title: {
        text: null
      },
      xAxis: {
        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
      },
      yAxis: {
        max: 8,
        min: -8,
        title: {
          text: 'Hours'
        }
      },
      credits: {
        enabled: false
      },
      series: [{
        type: 'area',
        color: "#7cb5ec",
        threshold: 0,
        negativeColor: '#f7a35c',
        showInLegend: false,
        data: [<?php echo join($overtimeColumn, ',') ?>]
      }]
    });
  });

  $(function () {
    $('#workingHours').highcharts({

      chart: {
        type: 'columnrange',
        backgroundColor: 'rgba(255, 255, 255, 0.1)',
        height: 300,
        width: 1108
      },

      title: {
        text: null
      },

      credits: {
        enabled: false
      },

      tooltip: {
        enabled: false
      },

      xAxis: {
        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        max: 5,
        min: 0
      },

      yAxis: {
        title: {
          text: 'Time'
        },
        type: 'datetime',
        tickInterval: 3600 * 1000,
        reversed: true,
        min: Date.UTC(1970, 0, 1, 5, 0),
        max: Date.UTC(1970, 0, 1, 20, 0)
      },
      legend: {
        enabled: false
      },

      series: [{
        name: 'Period',
        data: [
          <?php
            if(isset($this->data->workingPeriods)){
              foreach($this->data->workingPeriods as $period){
              echo "{";
              echo "x: ". $period['weekday'] . ",";
              echo "low: Date.parse('" . $period['end'] . "'), ";
              echo "high: Date.parse('" . $period['begin'] . "')";
              echo "}, ";
            }
          }
          ?>

        ]
      }]

    });

  });
</script>
