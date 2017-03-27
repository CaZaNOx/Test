<div class="well">
  <h3>Edit Employment Level</h3>
  <br/>

  <form role="form" action="<?php echo ROOT . 'settings/edit/' . $this->employmentLevel->id; ?>" method="post">
    <div class="form-group">
      <label for="employmentLevel" class="control-label">Employment Level</label>
      <select name="level" class="form-control" id="employmentLevel" required>
        <option value="10" <?php echo $this->employmentLevel->level == '10' ? ' selected="selected"' : ''; ?>>10%</option>
        <option value="20" <?php echo $this->employmentLevel->level == '20' ? ' selected="selected"' : ''; ?>>20%</option>
        <option value="30" <?php echo $this->employmentLevel->level == '30' ? ' selected="selected"' : ''; ?>>30%</option>
        <option value="40" <?php echo $this->employmentLevel->level == '40' ? ' selected="selected"' : ''; ?>>40%</option>
        <option value="50" <?php echo $this->employmentLevel->level == '50' ? ' selected="selected"' : ''; ?>>50%</option>
        <option value="60" <?php echo $this->employmentLevel->level == '60' ? ' selected="selected"' : ''; ?>>60%</option>
        <option value="70" <?php echo $this->employmentLevel->level == '70' ? ' selected="selected"' : ''; ?>>70%</option>
        <option value="80" <?php echo $this->employmentLevel->level == '80' ? ' selected="selected"' : ''; ?>>80%</option>
        <option value="90" <?php echo $this->employmentLevel->level == '90' ? ' selected="selected"' : ''; ?>>90%</option>
        <option value="100" <?php echo $this->employmentLevel->level == '100' ? ' selected="selected"' : ''; ?>>100%</option>
      </select>
    </div>
    <div class="form-group">
      <label for="begin" class="control-label">Start Date</label>

      <div class="input-group date">
        <input name="begin" value="<?php echo $this->employmentLevel->begin; ?>" type="text" class="form-control" id="begin"
               required>
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
      </div>
    </div>
    <div class="form-group">
      <label for="end" class="control-label">End Date</label>

      <div class="input-group date">
        <input name="end" value="<?php echo $this->employmentLevel->end; ?>" type="text" class="form-control" id="end" required>
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
      </div>
    </div>
    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save
    </button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><span
        class="glyphicon glyphicon-trash"> Delete</button>
    <a class="btn btn-default" type="button" href="<?php echo ROOT . 'settings'; ?>"><span
        class="glyphicon glyphicon-remove"></span> Cancel</a>
  </form>
</div>

</div>
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
            class="sr-only">Close</span></button>
        <h4 class="modal-title">Delete Employment Level</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this Employment Level?</p>
      </div>
      <div class="modal-footer">
        <form role="form" action="<?php echo ROOT . 'settings/delete/' . $this->employmentLevel->id; ?>" method="post">
          <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"> Cancel
          </button>
          <button name="submit" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"> Delete
          </button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
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