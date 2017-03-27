<div class="well row top-row">
  <h3>Edit Department</h3>
  <br/>

  <form role="form" action="<?php echo ROOT . 'admin/edit/department/' . $this->department->id; ?>" method="post">

    <div class="form-group">
      <label for="id">Department ID</label>
      <input name="id" type="text" class="form-control" id="id" value="<?php echo $this->department->id; ?>" readonly>
    </div>

    <div class="form-group">
      <label for="name">Name</label>
      <input name="name" type="text" class="form-control" id="name" value="<?php echo $this->department->name; ?>" required>
    </div>

    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save
    </button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><span
        class="glyphicon glyphicon-trash"> Delete</button>
    <a class="btn btn-default" type="button" href="<?php echo ROOT . 'admin/holidays'; ?>"><span
        class="glyphicon glyphicon-remove"></span> Cancel</a>
  </form>
</div>

<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
            class="sr-only">Close</span></button>
        <h4 class="modal-title">Delete Holiday</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this department '<?php echo $this->department->name; ?>'?</p>
      </div>
      <div class="modal-footer">
        <form role="form" action="<?php echo ROOT . 'admin/delete/department/' . $this->department->id; ?>" method="post">
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