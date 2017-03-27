<div class="row top-row">
  <div class="col-md-2">
  <a href="<?php echo ROOT . 'absences/create'; ?>" class="btn btn-primary btn-top-right"><span
      class="glyphicon glyphicon-pushpin"></span> New</a>
  </div>
  <div class="col-md-10">
    <div class="pull-right">
      <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Status <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li><a href="<?php echo ROOT . 'absences'; ?>">All</a></li>
          <li class="divider"></li>
          <li><a href="<?php echo ROOT . 'absences/pending'; ?>">Pending</a></li>
          <li><a href="<?php echo ROOT . 'absences/approved'; ?>">Approved</a></li>
          <li><a href="<?php echo ROOT . 'absences/declined'; ?>">Declined</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-capitalize"><?php echo $this->status ?> absences</h3>
      </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th><?php echo $this->getSortingLinks('creation', 'absences/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
              <th><?php echo $this->getSortingLinks('type', 'absences/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
              <th><?php echo $this->getSortingLinks('begin', 'absences/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
              <th><?php echo $this->getSortingLinks('end', 'absences/' . $this->status, $this->sortField, $this->sortOrder); ?></th>
              <th><?php echo $this->getSortingLinks('days', 'absences/'  . $this->status, $this->sortField, $this->sortOrder); ?></th>
              <th><?php echo $this->getSortingLinks('status', 'absences/'  . $this->status, $this->sortField, $this->sortOrder); ?></th>
              <th>action</th>
            </tr>
          </thead>
            <?php
            foreach($this->absences as $absence){
              echo '<tr>';
              echo '<td>' . $absence->creation . '</td>';
              echo '<td>' . $absence->type . '</td>';
              echo '<td>' . $absence->begin . '</td>';
              echo '<td>' . $absence->end . '</td>';
              echo '<td>' . $absence->days . '</td>';
              echo '<td>' . $this->addLabel($absence->status) . '</td>';
              echo '<td>' . $this->addButtonLong('edit', 'absences/edit/' . $absence->id) . '</td>';
              echo '</tr>';
            }
            ?>
        </table>
    </div>
  </div>
</div>
