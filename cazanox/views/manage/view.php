<div class="well row top-row">
  <h3>View Absence</h3>
  <br/>

  <div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><span class="glyphicon glyphicon-paperclip"></span>
        ID <?php echo $this->absence->id; ?></h3></div>
    <ul class="list-group">
      <li class="list-group-item">
        <strong>From:</strong><br/><?php echo $this->absence->firstname . ' ' . $this->absence->lastname; ?></li>
      <li class="list-group-item"><strong>Type:</strong><br/><?php echo $this->absence->type; ?></li>
      <li class="list-group-item"><strong>Creation:</strong><br/><?php echo $this->absence->creation; ?></li>
      <li class="list-group-item">
        <strong>Period:</strong><br/><?php echo $this->absence->begin . ' - ' . $this->absence->end; ?></li>
      <li class="list-group-item"><strong>Message:</strong><br/><?php echo $this->absence->notes; ?><br/></li>
    </ul>
  </div>
  <a href="<?php echo ROOT . 'manage/approve/' . $this->absence->id; ?>" class="btn btn-success"><span
      class="glyphicon glyphicon-ok"></span> Approve</a>
  <a href="<?php echo ROOT . 'manage/decline/' . $this->absence->id; ?>" class="btn btn-danger"><span
      class="glyphicon glyphicon-remove"></span> Decline</a>
  <a href="<?php echo ROOT . 'manage'; ?>" class="btn btn-default"><span class="glyphicon glyphicon-share-alt"></span>
    Cancel</a>
</div>
</div>