<div class="well row top-row">
  <h3>Create Holiday</h3>
  <br/>

  <form role="form" action="<?php echo ROOT . 'admin/create/holiday'; ?>" method="post">

    <div class="form-group">
      <label for="name">Name</label>
      <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" required>
    </div>
    <div class="form-group">
      <label for="date">Date</label>

      <div class="input-group date">
        <input name="date" type="text" class="form-control" id="date" placeholder="Enter Date" required>
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
      </div>
    </div>

    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Create
    </button>
    <a class="btn btn-default" type="button" href="<?php echo ROOT . 'admin/departments'; ?>"><span
        class="glyphicon glyphicon-remove"></span> Cancel</a>
  </form>
</div>
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