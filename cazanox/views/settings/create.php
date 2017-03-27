<script>
  var showPage0 = function() {
    document.getElementById("page0").style.display = 'block';
    document.getElementById("page1").style.display = 'none';
    document.getElementById("hoursPerWeek").removeAttribute('readonly');
  }

  var showPage1 = function() {
    document.getElementById("page0").style.display = 'none';
    document.getElementById("page1").style.display = 'block';
    document.getElementById("hoursPerWeek").setAttribute('readonly', '');
  }

  var calcTotal = function (){
    var hours = document.getElementsByClassName("hours");
    var minutes = document.getElementsByClassName("minutes");
    var sumHours = 0;
    var sumMinutes = 0;
    for (var i = 0; i < hours.length; i++) {
      sumHours += parseInt(hours[i].value) || 0;
      sumMinutes += parseInt(minutes[i].value) || 0;
    }
    sumHours += Math.floor(sumMinutes / 60);
    sumMinutes %= 60;
    document.getElementById("total").value = sumHours + " h  " + sumMinutes + " min";
  };

  var convertToTimeString = function (number){
    var hours = parseInt(number);
    var minutes = parseInt((number - hours) * 60);
    return hours + " h  " + minutes + " min";
  };

  var calcNominalHours = function (){
    var hours = parseInt(document.getElementById("hoursPerWeek").value) || 0;
    var e = document.getElementById("employmentLevel");
    try {
      var level = e.options[e.selectedIndex].value
      document.getElementById("nominalHoursPerWeek").value = convertToTimeString(hours * level / 100);
      document.getElementById("nominalHoursPerDay").value = convertToTimeString(hours / 5 * level / 100);
    } catch (err) {
      console.log(err);
    }
  };
</script>
<div class="well row top-row">
  <h3>Create New Interval</h3>
  <br/>
  <div class="row">
    <div class="col-md-7">
      <form role="form" action="<?php echo ROOT . 'settings/create' ?>" method="post">
        <div id="page0">

          <div class="form-group">
            <label for="employmentLevel" class="control-label">Employment Level</label>
            <select name="level" class="form-control" id="employmentLevel" onchange="calcNominalHours();" required>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
            <script>document.getElementById("employmentLevel").selectedIndex = -1;</script>
          </div>


          <div class="form-group">
            <label for="begin" class="control-label">Start Date</label>
            <div class="input-group date">
              <input name="begin" type="text" class="form-control" id="begin" required>
              <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            </div>
          </div>

          <div class="form-group">
            <label for="end" class="control-label">End Date</label>
            <div class="input-group date">
              <input name="end" type="text" class="form-control" id="end">
              <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            </div>
          </div>

          <a class="btn btn-default" type="button" href="<?php echo ROOT . 'settings'; ?>">
            <span class="glyphicon glyphicon-remove"></span> Cancel
          </a>
          <a class="btn btn-default" type="button" onclick="showPage1();">
            <span class="glyphicon glyphicon-arrow-right"></span> Next
          </a>
        </div><!-- end page0 -->

        <div id="page1">
          <div class="form-group col-md-4">
            <label class="control-label">Monday</label>
            <div class="form-inline">
              <input name="mondayHours" type="number" min="0" max="24" step="1" class="form-control hours"
                     placeholder="h" onchange="calcTotal();">
              <input name="mondayMinutes" type="number" min="0" max="59" class="form-control minutes" placeholder="min"
                     onchange="calcTotal();">
            </div>
          </div>

          <div class="form-group col-md-4">
            <label class="control-label">Tuesday</label>
            <div class="form-inline">
              <input name="tuesdayHours" type="number" min="0" max="24" step="1" class="form-control hours"
                     placeholder="h" onchange="calcTotal();">
              <input name="tuesdayMinutes" type="number" min="0" max="59" class="form-control minutes" placeholder="min"
                     onchange="calcTotal();">
            </div>
          </div>

          <div class="form-group col-md-4">
            <label class="control-label">Wednesday</label>
            <div class="form-inline">
              <input name="wednesdayHours" type="number" min="0" max="24" step="1" class="form-control hours"
                     placeholder="h" onchange="calcTotal();">
              <input name="wednesdayMinutes" type="number" min="0" max="59" class="form-control minutes" placeholder="min"
                     onchange="calcTotal();">
            </div>
          </div>

          <div class="form-group col-md-4">
            <label class="control-label">Thursday</label>
            <div class="form-inline">
              <input name="thursdayHours" type="number" min="0" max="24" step="1" class="form-control hours"
                     placeholder="h" onchange="calcTotal();">
              <input name="thursdayMinutes" type="number" min="0" max="59" class="form-control minutes" placeholder="min"
                     onchange="calcTotal();">
            </div>
          </div>

          <div class="form-group col-md-4">
            <label class="control-label">Friday</label>
            <div class="form-inline">
              <input name="fridayHours" type="number" min="0" max="24" step="1" class="form-control hours" placeholder="h"
                       onchange="calcTotal();">
              <input name="fridayMinutes" type="number" min="0" max="59" class="form-control minutes" placeholder="min"
                       onchange="calcTotal();">
            </div>
          </div>

          <div class="form-group col-md-4">
            <label class="control-label">Saturday</label>
            <div class="form-inline">
              <input name="saturdayHours" type="number" min="0" max="24" step="1" class="form-control hours" placeholder="h"
                     onchange="calcTotal();">
              <input name="saturdayMinutes" type="number" min="0" max="59" class="form-control minutes" placeholder="min"
                     onchange="calcTotal();">
            </div>
          </div>

          <div class="form-group col-md-3 col-md-offset-8">
            <label for="total" class="control-label">Total</label>
            <input name="total" id="total" type="text" class="form-control" readonly>
          </div>


          <a class="btn btn-default" type="button" href="<?php echo ROOT . 'settings'; ?>">
            <span class="glyphicon glyphicon-remove"></span> Cancel
          </a>
          <a class="btn btn-default" type="button" onclick="showPage0();">
            <span class="glyphicon glyphicon-arrow-left"></span> Back
          </a>
          <button type="submit" name="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-ok"></span> Create
          </button>
        </div><!-- end page1 -->
      </form>
    </div>

    <div class="col-md-4 col-md-offset-1">

      <div class="form-group">
        <label for="hoursPerWeek" class="control-label">Hours per Week (100%)</label>
        <input name="hoursPerWeek" type="text" class="form-control" id="hoursPerWeek" value="42" onblur="calcNominalHours();" required>
      </div>

      <div class="form-group">
        <label for="nominalHoursPerWeek" class="control-label">Nominal Hours per Week</label>
        <input name="begin" type="text" class="form-control" id="nominalHoursPerWeek" readonly>
      </div>

      <div class="form-group">
        <label for="nominalHoursPerDay" class="control-label">Nominal Hours per Day</label>
        <input name="begin" type="text" class="form-control" id="nominalHoursPerDay" readonly>
      </div>

    </div>
  </div>
</div>


</div>
<script>
  showPage0();
  $('.input-group.date').datepicker({
    format: "dd/mm/yyyy",
    weekStart: 1,
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true
  });
</script>