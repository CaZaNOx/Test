<div class="well row top-row">
  <h3>Create Employee</h3>
  <br/>

  <form role="form" action="<?php echo ROOT . 'admin/create/employee'; ?>" method="post">

    <div class="form-group">
      <label for="role" class="control-label">Role</label>
      <select name="accessLevel" class="form-control" id="role" required>
        <option value="10">User</option>
        <option value="100">Manager</option>
        <option value="1000">Admin</option>
      </select>
    </div>

    <div class="form-group">
      <label for="department" class="control-label">Department</label>
      <select name="idDepartment" class="form-control" id="department" required>
        <?php foreach ($this->departments as $department): ?>
          <option value="<?php echo $department->id ?>"><?php echo $department->name ?></option>
        <?php endforeach; ?>
      </select>
      <script>document.getElementById("department").selectedIndex = -1;</script>
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input name="username" type="text" class="form-control" id="username" placeholder="Enter Username" required>
    </div>

    <div class="form-group">
      <label for="firstname">Firstname</label>
      <input name="firstname" type="text" class="form-control" id="firstname" placeholder="Enter Firstname" required>
    </div>

    <div class="form-group">
      <label for="lastname">Lastname</label>
      <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Enter Lastname" required>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input name="password" value="<?php echo generatePassword(); ?>" type="text" class="form-control" id="password"
             placeholder="Enter Password" required>
    </div>

    <div class="form-group">
      <label for="status" class="control-label">Status</label>
      <select name="status" class="form-control" id="status" required>
        <option>Active</option>
        <option selected="selected">Disabled</option>
      </select>
    </div>

    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Create
    </button>
    <a class="btn btn-default" type="button" href="<?php echo ROOT . 'admin/employees'; ?>"><span
        class="glyphicon glyphicon-remove"></span> Cancel</a>
  </form>
</div>

<?php
function generatePassword($length = 7) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $password = '';
  for ($i = 0; $i < $length; $i++) {
    $password .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $password;
}

?>