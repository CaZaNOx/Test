<script src="<?php echo ROOT . "assets/js/highcharts.js"; ?>"></script>
<script src="<?php echo ROOT . "assets/js/highcharts-more.js"; ?>"></script>

<div class="content-nav">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href=<?php echo ROOT . "reports/week"; ?>>Week</a></li>
    <li role="presentation"><a href=<?php echo ROOT . "reports/month"; ?>>Month</a></li>
    <li role="presentation" class="active"><a href=<?php echo ROOT . "reports/year"; ?>>Year</a></li>
  </ul>
</div>

<div class="row">
  <div class="col-md-5 text-right"><a href="<?php echo $this->get('lastYearUrl'); ?>"><span
        class="glyphicon glyphicon-chevron-left nav-arrow"></span></a></div>
  <div class="col-md-2 text-center">
    <h3><?php echo $this->get('year'); ?></h3>

    <p><?php echo $this->get('firstDayOfYear') . ' - ' . $this->get('lastDayOfYear'); ?></p>
  </div>
  <div class="col-md-5 text-left"><a href="<?php echo $this->get('nextYearUrl'); ?>"><span
        class="glyphicon glyphicon-chevron-right nav-arrow"></span></a></div>
</div>

<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Hours per Day</h3>
    </div>
    <div class="panel-body">
      <div id="lineChart"></div>
    </div>
  </div>
</div>

<?php
  $total = Array();
  foreach($this->timeSeries as $time){
    $time = empty($time->total) ? '00.00' : str_replace(':', '.', $time->total);
    array_push($total, floatval($time));
  }
?>

<script>
  $(function () {
    $('#lineChart').highcharts({
      chart: {
        zoomType: 'x',
        backgroundColor: 'rgba(255, 255, 255, 0.1)',
        height: 300
      },
      credits: {
        enabled: false
      },
      title: {
        text: '',
        style: {
          display: 'none'
        }
      },
      xAxis: {
        type: 'datetime',
        minRange: 14 * 24 * 3600000
      },
      yAxis: {
        title: {
          text: 'Hours'
        },
        min: 0,
        max: 10
      },
      legend: {
        enabled: false
      },
      plotOptions: {
        area: {
          fillColor: {
            linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
            stops: [
              [0, Highcharts.getOptions().colors[0]],
              [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
            ]
          },
          marker: {
            radius: 2
          },
          lineWidth: 1,
          states: {
            hover: {
              lineWidth: 1
            }
          },
          threshold: null
        }
      },

      series: [{
        type: 'column',
        name: 'Hours',
        pointInterval: 24 * 3600 * 1000,
        pointStart: Date.UTC(<?php echo $this->get('year'); ?>, 0, 1),
        data: [<?php echo join($total, ',') ?>]
      }]
    });
  });


  var cal = new CalHeatMap();
  cal.init({});

</script>
