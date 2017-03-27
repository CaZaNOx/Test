<script src="<?php echo ROOT . "assets/js/highcharts.js"; ?>"></script>
<script src="<?php echo ROOT . "assets/js/highcharts-more.js"; ?>"></script>

<div class="row">
  <div class="col-md-5 text-right"><a href="<?php echo $this->lastYearUrl; ?>"><span
        class="glyphicon glyphicon-chevron-left nav-arrow"></span></a></div>
  <div class="col-md-2 text-center">
    <h3><?php echo $this->year; ?></h3>

    <p><?php echo $this->firstDayOfYear . ' - ' . $this->lastDayOfYear; ?></p>
  </div>
  <div class="col-md-5 text-left">
    <a href="<?php echo $this->nextYearUrl; ?>"><span
        class="glyphicon glyphicon-chevron-right nav-arrow"></span>
    </a>
    <div class="pull-right" style="padding-top: 42px">
      <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Department <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li><a href="<?php echo ROOT . 'team'; ?>">All</a></li>
          <li class="divider"></li>
          <?php
            foreach($this->departments as $department){
              echo '<li><a href="' . ROOT . 'team/show/' . strtolower($department->name) . '">' . $department->name . '</a></li>';
            }
          ?>
        </ul>
      </div>
    </div>
  </div>

</div>

<div class="row">
  <div class="well">
    <div id="chart"></div>
  </div>
</div>

<script>
  $(function () {
    $('#chart').highcharts({
      chart: {
        type: 'columnrange',
        renderTo: 'container',
        height: <?php echo count($this->team)*25+50?>,
        backgroundColor: 'rgba(255, 255, 255, 0.1)',
        inverted: true
      },
      title: {
        text: null
      },
      xAxis: {
        categories: [<?php echo "'" . join("', '", $this->team) . "'"; ?>],
        max: <?php echo count($this->team)-1; ?>
      },
      yAxis: {
        type: 'datetime',
        title: {
          text: null
        },
        min: Date.UTC(<?php $year = $this->year; echo --$year; ?>, 11),
        max: Date.UTC(<?php $year = $this->year; echo ++$year; ?>, 0),
        plotBands: {
          color: 'rgba(68, 170, 213, 0.5)',
          value: Date.now(),
          width: '5'
        }
      },
      credits: {
        enabled: false
      },
      exporting: {
        enabled: false
      },
      plotOptions: {
        columnrange: {
          grouping: false
        }
      },

      legend: {
        enabled: false
      },
      tooltip:{
        formatter: function() {
          return '<b>'+ this.x +' - ' +this.series.name +'</b><br/>'+
          Highcharts.dateFormat('%e %B ',this.point.low)+
          ' - ' +Highcharts.dateFormat('%B %e ',this.point.high)+'<br/>';
        }
      },

      series: [{
        pointWidth: 20,
        name: 'Holidays',
        data:[
          <?php
          if(isset($this->absences['Holiday'])){
            foreach($this->absences['Holiday'] as $holiday){
              echo "{";
              echo "x: ". array_search($holiday['name'], $this->team) . ",";
              echo "low: Date.parse('" . $holiday['begin'] . "'), ";
              echo "high: Date.parse('" . $holiday['end'] . "')";
              echo "}, ";
            }
          }
          ?>

        ]
      },
        {
          pointWidth: 20,
          name: 'Training',
          data:[
            <?php
            if(isset($this->absences['Training'])){
              foreach($this->absences['Training'] as $training){
              echo "{";
              echo "x: ". array_search($training['name'], $this->team) . ",";
              echo "low: Date.parse('" . $training['begin'] . "'), ";
              echo "high: Date.parse('" . $training['end'] . "')";
              echo "}, ";
              }
            }
            ?>

          ]
        },
        {
          pointWidth: 20,
          name: 'Sickness',
          data:[
            <?php
            if(isset($this->absences['Sickness'])){
            foreach($this->absences['Sickness'] as $sickness){
              echo "{";
              echo "x: ". array_search($sickness['name'], $this->team) . ",";
              echo "low: Date.parse('" . $sickness['begin'] . "'), ";
              echo "high: Date.parse('" . $sickness['end'] . "')";
              echo "}, ";
            }
          }
          ?>

          ]
        },
        {
          pointWidth: 20,
          name: 'Maternity',
          data:[
            <?php
            if(isset($this->absences['Maternity'])){
            foreach($this->absences['Maternity'] as $maternity){
                 echo "{";
              echo "x: ". array_search($maternity['name'], $this->team) . ",";
              echo "low: Date.parse('" . $maternity['begin'] . "'), ";
              echo "high: Date.parse('" . $maternity['end'] . "')";
              echo "}, ";
            }
          }
          ?>

          ]
        }
      ]

    });

  });
</script>




