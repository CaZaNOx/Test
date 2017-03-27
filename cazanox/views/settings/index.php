<div class="well row top-row">
  <h3>Basic Settings</h3>

  <form role="form" action="<?php echo ROOT . 'settings/save'; ?>" method="post">
    <div class="form-group">
      <label for="periods" class="control-label">Number of Periods</label>
      <select name="periods" class="form-control" id="periods" required>
        <option<?php echo $this->user->numOfPeriods == '2' ? ' selected="selected"' : ''; ?>>2</option>
        <option<?php echo $this->user->numOfPeriods == '3' ? ' selected="selected"' : ''; ?>>3</option>
        <option<?php echo $this->user->numOfPeriods == '4' ? ' selected="selected"' : ''; ?>>4</option>
      </select>
    </div>
    <div class="form-group">
      <label for="notes" class="control-label">Show Notes</label>
      <select name="notes" class="form-control" id="notes" required>
        <option<?php echo $this->user->showNotes == 'Yes' ? ' selected="selected"' : ''; ?>>Yes</option>
        <option<?php echo $this->user->showNotes == 'No' ? ' selected="selected"' : ''; ?>>No</option>
      </select>
    </div>
    <div class="form-group">
      <label for="messages" class="control-label">Show Messages</label>
      <select name="messages" class="form-control" id="messages" required>
        <option<?php echo $this->user->showMessages == 'Yes' ? ' selected="selected"' : ''; ?>>Yes</option>
        <option<?php echo $this->user->showMessages == 'No' ? ' selected="selected"' : ''; ?>>No</option>
      </select>
    </div>
    <button name="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save
    </button>
  </form>
  <br/>

  <h3>Password</h3>
  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal"> Change Password</button>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
              class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Change Password</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="<?php echo ROOT . 'settings/changePassword'; ?>" method="post">
            <div class="form-group">
              <label for="currentPassword">Current Password</label>
              <input name="currentPassword" type="password" class="form-control" id="currentPassword"
                     placeholder="Enter current password">
            </div>
            <div class="form-group">
              <label for="newPassword">New Password</label>
              <input name="newPassword" type="password" class="form-control" id="newPassword"
                     placeholder="Enter new password">
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <input name="confirmPassword" type="password" class="form-control" id="confirmPassword"
                     placeholder="Confirm new password"
                     onkeyup="checkPassword()">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="submit" type="submit" class="btn btn-primary">Change</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <br/>
  <br/>

  <h3>Employment Level</h3>

  <div class="panel panel-default">
    <table class="table table-striped">
      <thead>
      <tr>
        <th><?php echo $this->getSortingLinks('begin', 'settings/sort', $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('end', 'settings/sort', $this->sortField, $this->sortOrder); ?></th>
        <th><?php echo $this->getSortingLinks('level', 'settings/sort', $this->sortField, $this->sortOrder); ?></th>
        <th>action</th>
      </tr>
      </thead>
      <?php
      foreach($this->employmentLevels as $employmentLevel){
        echo '<tr>';
        echo '<td>' . $employmentLevel->begin . '</td>';
        echo '<td>' . $employmentLevel->end . '</td>';
        echo '<td>' . $employmentLevel->level . '</td>';
        echo '<td>' . $this->addButtonLong('edit', 'settings/edit/' . $employmentLevel->id) . '</td>';
        echo '</tr>';
      }
      ?>
    </table>
  </div>
  <!-- panel -->
  <a href="<?php echo ROOT . 'settings/create'; ?>" type="create" class="btn btn-primary"><span
      class="glyphicon glyphicon-pushpin"></span> New</a>
</div>

<script>
  function checkPassword() {
    var pass1 = document.getElementById('newPassword');
    var pass2 = document.getElementById('confirmPassword');
    if (pass1.value == pass2.value) {
      pass2.style.backgroundColor = "#dff0d8";
    } else {
      pass2.style.backgroundColor = "#f2dede";
    }
  }
</script>
