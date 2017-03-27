<div class="well row top-row">
  <h3>Edit Absence</h3>
  <br/>
  <form role="form" action="<?php echo ROOT . 'absences/edit/' . $this->absence->id; ?>" method="post">
    <div class="form-group">
      <label for="absence" class="control-label">Type</label>
      <select name="type" class="form-control" id="absence" required>
        <option <?php echo $this->absence->type == 'Holidays' ? ' selected="selected"' : ''; ?>>Holiday</option>
        <option <?php echo $this->absence->type == 'Sickness' ? ' selected="selected"' : ''; ?>>Sickness</option>
        <option <?php echo $this->absence->type == 'Training' ? ' selected="selected"' : ''; ?>>Training</option>
        <option <?php echo $this->absence->type == 'Maternity' ? ' selected="selected"' : ''; ?>>Maternity</option>
      </select>
    </div>
    <div class="form-group">
      <label for="begin" class="control-label">Start Date</label>
      <div class="input-group date">
        <input name="begin" type="text" class="form-control" id="begin" value="<?php echo $this->absence->begin; ?>" required>
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
      </div>
    </div>
    <div class="form-group">
      <label for="end" class="control-label">End Date</label>
      <div class="input-group date">
        <input name="end" type="text" class="form-control" id="end" value="<?php echo $this->absence->end; ?>" required>
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
      </div>
    </div>
    <div class="form-group">
      <label for="notes" class="control-label">Notes</label>
      <textarea id="notes" name="notes" class="form-control" rows="3"><?php echo $this->absence->notes; ?></textarea>
    </div>
    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save</button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><span
        class="glyphicon glyphicon-trash"> Delete</button>
    <a class="btn btn-default" type="button" href="<?php echo ROOT . 'absences'; ?>"><span class="glyphicon glyphicon-remove"></span> Cancel</a>
  </form>
</div>

<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Delete Absence</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this absence?</p>
      </div>
      <div class="modal-footer">
        <form role="form" action="<?php echo ROOT . 'absences/delete/' . $this->absence->id; ; ?>" method="post">
          <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"> Cancel</button>
          <button name="submit" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"> Delete</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  $('.input-group.date').datepicker({
    format: "dd/mm/yyyy",
    weekStart: 1,
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true
  });
</script> 