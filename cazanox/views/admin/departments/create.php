<div class="well row top-row">
  <h3>Create Department</h3>
  <br/>

  <form role="form" action="<?php echo ROOT . 'admin/create/department'; ?>" method="post">

    <div class="form-group">
      <label for="name">Name</label>
      <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" required>
    </div>

    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Create
    </button>
    <a class="btn btn-default" type="button" href="<?php echo ROOT . 'admin/departments'; ?>"><span
        class="glyphicon glyphicon-remove"></span> Cancel</a>
  </form>
</div>
</div>
