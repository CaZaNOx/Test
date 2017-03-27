<div class="row top-row">
  <div class="col-md-2">
  </div>
  <div class="col-md-10">
    <div class="pull-right">
      <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Show <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li><a href="<?php echo ROOT . 'manage/pending'; ?>">Pending</a></li>
          <li class="divider"></li>
          <li><a href="<?php echo ROOT . 'manage/all'; ?>">All</a></li>
          <li><a href="<?php echo ROOT . 'manage/approved'; ?>">Approved</a></li>
          <li><a href="<?php echo ROOT . 'manage/declined'; ?>">Declined</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading text-capitalize"><h3 class="panel-title"><?php echo $this->status?> Absences</h3></div>
      <table class="table table-striped">
        <thead>
        <tr>
          <th><?php echo $this->getSortingLinks('creation', 'manage/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
          <th><?php echo $this->getSortingLinks('firstname', 'manage/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
          <th><?php echo $this->getSortingLinks('lastname', 'manage/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
          <th><?php echo $this->getSortingLinks('type', 'manage/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
          <th><?php echo $this->getSortingLinks('begin', 'manage/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
          <th><?php echo $this->getSortingLinks('end', 'manage/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
          <th><?php echo $this->getSortingLinks('status', 'manage/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
          <?php
            if($this->status == 'pending'){
              echo '<th>action</th>';
            }
          ?>
        </tr>
        </thead>
        <?php
        foreach($this->absences as $absence){
          echo '<tr>';
          echo '<td>' . $absence->creation . '</td>';
          echo '<td>' . $absence->firstname . '</td>';
          echo '<td>' . $absence->lastname . '</td>';
          echo '<td>' . $absence->type . '</td>';
          echo '<td>' . $absence->begin . '</td>';
          echo '<td>' . $absence->end . '</td>';
          echo '<td>' . $this->addLabel($absence->status) . '</td>';
          if($this->status == 'pending'){
            echo '<td>';
            echo $this->addButtonShort('view', 'manage/view/' . $absence->id) . ' ';
            echo $this->addButtonShort('approve', 'manage/approve/' . $absence->id) . ' ';
            echo $this->addButtonShort('decline', 'manage/decline/' . $absence->id);
            echo '</td>';
          }
          echo '</tr>';
        }
        ?>
      </table>
    </div>
    <!-- panel -->
  </div>
</div>
