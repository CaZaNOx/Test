<div class="well row top-row">
  <h3>Edit Employee</h3>
  <br/>

  <form role="form" action="<?php echo ROOT . 'admin/edit/employee/' . $this->id; ?>" method="post">
    <div class="form-group">
      <label for="id">Employee ID</label>
      <input name="id" type="text" class="form-control" id="id" value="<?php echo $this->employee->id; ?>" readonly>
    </div>

    <div class="form-group">
      <label for="role" class="control-label">Role</label>
      <select name="accessLevel" class="form-control" id="role" required>
        <option value="10" <?php echo $this->employee->accessLevel == '10' ? ' selected="selected"' : ''; ?>>User</option>
        <option value="100" <?php echo $this->employee->accessLevel == '100' ? ' selected="selected"' : ''; ?>>Manager</option>
        <option value="1000" <?php echo $this->employee->accessLevel == '1000' ? ' selected="selected"' : ''; ?>>Admin</option>
      </select>
    </div>

    <div class="form-group">
      <label for="firstname">Firstname</label>
      <input name="firstname" type="text" class="form-control" id="firstname"
             value="<?php echo $this->employee->firstname; ?>" required>
    </div>

    <div class="form-group">
      <label for="lastname">Lastname</label>
      <input name="lastname" type="text" class="form-control" id="lastname"
             value="<?php echo $this->employee->lastname; ?>" required>
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input name="username" type="text" class="form-control" id="username"
             value="<?php echo $this->employee->username; ?>" required>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input name="password" type="password" class="form-control" id="password"
             value="<?php echo $this->employee->password; ?>" required>
    </div>

    <div class="form-group">
      <label for="department" class="control-label">Department</label>
      <select name="idDepartment" class="form-control" id="department" required>
        <option value="">none</option>
        <?php foreach ($this->departments as $department): ?>
          <option
            value="<?php echo $department->id ?>" <?php echo $this->employee->department == $department->name ? ' selected="selected"' : '' ?>><?php echo $department->name ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="status" class="control-label">Status</label>
      <select name="status" class="form-control" id="status" required>
        <option<?php echo $this->employee->status == 'Active' ? ' selected="selected"' : ''; ?>>Active</option>
        <option<?php echo $this->employee->status == 'Disabled' ? ' selected="selected"' : ''; ?>>Disabled</option>
        <option<?php echo $this->employee->status == 'Deleted' ? ' selected="selected"' : ''; ?>>Deleted</option>
      </select>
    </div>

    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save
    </button>
    <a class="btn btn-default" type="button" href="<?php echo ROOT . 'admin/employees'; ?>"><span
        class="glyphicon glyphicon-remove"></span> Cancel</a>
  </form>
</div>