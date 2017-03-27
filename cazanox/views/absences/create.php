<div class="well row top-row">
  <h3>Create New Absence</h3>
  <br />
  <form role="form" action="<?php echo ROOT . 'absences/create'; ?>" method="post">
    <div class="form-group">
      <label for="absence" class="control-label">Type</label>
      <select name="type" class="form-control" id="absence" required>
        <option>Holiday</option>
        <option>Sickness</option>
        <option>Training</option>
        <option>Maternity</option>
      </select>
      <script>document.getElementById("absence").selectedIndex = -1;</script>
    </div>
    <div class="form-group">
      <label for="begin" class="control-label">Start Date</label>
      <div class="input-group date">
        <input type="text" name="begin" class="form-control" id="begin" required>
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
      </div>
    </div>
    <div class="form-group">
      <label for="end" class="control-label">End Date</label>
      <div class="input-group date">
        <input type="text" name="end" class="form-control" id="end" required>
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
      </div>
    </div>
    <div class="form-group">
      <label for="notes" class="control-label">Notes</label>
      <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
    </div>
    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save</button>
    <a class="btn btn-default" type="button" href="<?php echo ROOT . 'absences'; ?>"><span class="glyphicon glyphicon-remove"></span> Cancel</a>
  </form>
</div>

<script>
  $('.input-group.date').datepicker({
      format: "dd/mm/yyyy",
      weekStart: 1,
      calendarWeeks: true,
      autoclose: true,
      todayHighlight: true
  });
</script>
