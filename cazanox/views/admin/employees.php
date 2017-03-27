<div class="content-nav">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href=<?php echo ROOT . "admin/holidays"; ?>>Holidays</a></li>
    <li role="presentation" class="active"><a href=<?php echo ROOT . "admin/employees"; ?>>Employees</a></li>
    <li role="presentation"><a href=<?php echo ROOT . "admin/departments"; ?>>Departments</a></li>
  </ul>
</div>

<div class="row top-row">
  <div class="col-lg-4">
    <a href="<?php echo ROOT . 'admin/create/employee'; ?>" class="btn btn-primary btn-top-right"><span class="glyphicon glyphicon-pushpin"></span> New</a>
  </div>
  <div class="col-lg-2 col-lg-offset-6">
    <input type="text" class="form-control" placeholder="Search" onkeyup="search(this)">
  </div>
</div>

<div class="row">
  <div class="panel panel-default">
    <table id="table" class="table table-striped">
      <thead>
      <tr>
        <th><?php echo $this->getSortingLinks('id', 'admin/employees',  $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('department', 'admin/employees', $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('username', 'admin/employees', $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('firstname', 'admin/employees', $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('lastname', 'admin/employees', $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('accessLevel', 'admin/employees', $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('userCreation', 'admin/employees', $this->sortField, $this->sortOrder); ?></th>
        <th>status</th>
        <th>action</th>
      </tr>
      </thead>
      <?php
      foreach($this->employees as $employee){
        echo '<tr>';
        echo '<td>' . $employee->id . '</td>';
        echo '<td>' . $employee->department . '</td>';
        echo '<td>' . $employee->username . '</td>';
        echo '<td>' . $employee->firstname . '</td>';
        echo '<td>' . $employee->lastname . '</td>';
        echo '<td>' . $employee->accessLevel . '</td>';
        echo '<td>' . $employee->userCreation . '</td>';
        echo '<td>' . $this->addLabel($employee->status) . '</td>';
        echo '<td>' . $this->addButtonLong('edit', 'admin/edit/employee/' . $employee->id) . '</td>';
        echo '</tr>';
      }
      ?>
    </table>
  </div>
</div>

<script>
  function search(searchBox) {
    var word = searchBox.value.toLowerCase();
    var table = document.getElementById('table');
    var element;
    for (var i = 1; i < table.rows.length; i++) {
      element = table.rows[i].innerHTML.replace(/<[^>]+>/g, "");
      if (element.toLowerCase().indexOf(word) >= 0)
        table.rows[i].style.display = '';
      else table.rows[i].style.display = 'none';
    }
  }
</script>