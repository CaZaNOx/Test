<div class="content-nav">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href=<?php echo ROOT . "admin/holidays"; ?>>Holidays</a></li>
    <li role="presentation"><a href=<?php echo ROOT . "admin/employees"; ?>>Employees</a></li>
    <li role="presentation" class="active"><a href=<?php echo ROOT . "admin/departments"; ?>>Departments</a></li>
  </ul>
</div>

<div class="row top-row">
  <div class="col-lg-4">
    <a href="<?php echo ROOT . 'admin/create/department'; ?>" class="btn btn-primary btn-top-right"><span class="glyphicon glyphicon-pushpin"></span> New</a>
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
        <th><?php echo $this->getSortingLinks('id', 'admin/departments',  $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('name', 'admin/departments', $this->sortField, $this->sortOrder); ?></th>
        <th>action</th>
      </tr>
      </thead>
      <?php
      foreach($this->departments as $department){
        echo '<tr>';
        echo '<td>' . $department->id . '</td>';
        echo '<td>' . $department->name . '</td>';
        echo '<td>' . $this->addButtonLong('edit', 'admin/edit/department/' . $department->id) . '</td>';
        echo '</tr>';
      }
      ?>
    </table>
  </div>
</div>

<script>
  var search = function (searchBox){
    var word = searchBox.value.toLowerCase();
    var table = document.getElementById('table');
    var element;
    for (var i = 1; i < table.rows.length; i++){
      element = table.rows[i].innerHTML.replace(/<[^>]+>/g,"");
      if (element.toLowerCase().indexOf(word)>=0 )
        table.rows[i].style.display = '';
      else table.rows[i].style.display = 'none';
    }
  }
</script>