<script>
  var validateInput = function(form){
    var inputFields = form.getElementsByClassName('inline-input');
    for(var i = 0; i < inputFields.length; i +=2){
      var begin = inputFields[i];
      var end = inputFields[i+1];
      if(begin.value > end.value && end.value != ''){
        begin.style.backgroundColor = '#ebccd1';
        begin.style.borderColor = '#a94442';
        end.style.backgroundColor = '#ebccd1';
        end.style.borderColor = '#a94442';
      } else {
        begin.style.backgroundColor = '';
        begin.style.borderColor = '#ccc';
        end.style.backgroundColor = '';
        end.style.borderColor = '#ccc';
      }
    }
  }
</script>
<!-- BEGIN: Top -->
<div class="row top-row">
  <div class="col-md-4">
    <div class="btn-group">
      <a href="<?php echo $this->get('urls')[0]; ?>" class="btn btn-default  btn-sm"><span
          class="glyphicon glyphicon-chevron-left"></span></a>
      <a href="<?php echo $this->get('urls')[1]; ?>" class="btn btn-default  btn-sm"><span
          class="glyphicon glyphicon-home"></span></a>
      <a href="<?php echo $this->get('urls')[2]; ?>" class="btn btn-default  btn-sm"><span
          class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
  </div>
  <div class="col-md-4">
    <h3 class="text-center">Week <?php echo $this->get('week') ?></h3>
    <!-- <p><?php echo $this->get('period') ?></p> -->
  </div>
</div>
<!-- END: Top -->

<!-- BEGIN: Body -->
<div class="row">
  <?php
  for ($i = 1; $i <= 6; $i++):
    $date = strtotime($this->year . "W" . sprintf("%02d", $this->week) . $i);
    ?>
    <div class="col-md-2 panel panel-default">
      <div class="panel-heading">
        <h4><?php echo date('l', $date); ?></h4>
        <h5><?php echo date('d/m/Y', $date); ?></h5>
      </div>
      <div class="panel-body">
        <form role="form" action="<?php echo ROOT . 'calendar/save/'; ?>" method='post' onkeyup="validateInput(this);">
          <div class="form-group">
            <p>Hours</p>
            <?php for ($j = 1; $j <= $this->settings->numOfPeriods; $j++): ?>
              <?php
              if (isset($this->get('periods')[date('Y-m-d', $date)])) {
                $period = array_shift($this->periods[date('Y-m-d', $date)]);
              } else {
                $period = null;
              }
              ?>
              <div>
                <input value="<?php echo $period['begin']; ?>" type="text" class="form-control inline-input"
                       name="<?php echo 'b' . $j; ?>">
                <input value="<?php echo $period['end']; ?>" type="text" class="form-control inline-input"
                       name="<?php echo 'e' . $j; ?>">
              </div>
            <?php endfor; ?>
          </div>
          <?php if ($this->settings->showNotes == 'Yes'): ?>
            <div class="form-group">
              <p>Notes</p>
              <textarea name="notes" class="form-control" rows="3"><?php
                foreach ($this->get('notes') as $note) {
                  if ($note['date'] == date('Y-m-d', $date)) {
                    echo $note['note'];
                  }
                }
                ?></textarea>
            </div>
          <?php endif; ?>
          <input type="hidden" name="date" value="<?php echo date('Y-m-d', $date); ?>">
          <button type="submit" name="submit" class="btn btn-default btn-primary"><span
              class="glyphicon glyphicon-pencil"></span> Save
          </button>
        </form>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-6"><p><strong>Total</strong></p></div>
          <div class="col-md-6">
            <p class="text-right">
            <?php
            foreach ($this->sum as $row) {
              if ($row['date'] == date('Y-m-d', $date)) {
                echo $row['sum'];
              }
            }
            ?>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6"><p><strong>Schedule</strong><p></div>
          <div class="col-md-6 pull-right">
            <p class="text-right">
            <?php
            foreach ($this->schedule as $row) {
              if ($row['date'] == date('Y-m-d', $date)) {
                echo $row['schedule'];
              }
            }
            ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  <?php endfor; ?>
</div>
<!-- END: Body -->