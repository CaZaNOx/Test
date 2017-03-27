<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <!-- Navigation Left -->
        <li class="pull-left logo"><a href=<?php echo ROOT; ?>>fleXtime</a></li>
        <!-- Navigation Center -->
        <li<?php echo $controller->name == 'calendar' ? ' class="active"' : ''; ?>>
          <a href=<?php echo ROOT . "calendar"; ?>>
            <span class="glyphicon glyphicon-calendar"></span> Calendar</a>
        </li>
        <li<?php echo $controller->name == 'absences' ? ' class="active"' : ''; ?>>
          <a href=<?php echo ROOT . "absences"; ?>>
            <span class="glyphicon glyphicon-flag"></span> Absences</a>
        </li>
        <li<?php echo $controller->name == 'team' ? ' class="active"' : ''; ?>>
          <a href=<?php echo ROOT . "team"; ?>>
            <span class="glyphicon glyphicon-user"></span> Team</a>
        </li>
        <li<?php echo $controller->name == 'reports' ? ' class="active"' : ''; ?>>
          <a href=<?php echo ROOT . "reports"; ?>>
            <span class="glyphicon glyphicon-stats"></span> Reports</a>
        </li>
        <?php if ($_SESSION['accessLevel'] >= 100): ?>
          <li<?php echo $controller->name == 'manage' ? ' class="active"' : ''; ?>>
            <a href=<?php echo ROOT . "manage"; ?>>
              <span class="glyphicon glyphicon-paperclip"></span> Manage</a>
          </li>
        <?php endif; ?>
        <li<?php echo $controller->name == 'settings' ? ' class="active"' : ''; ?>>
          <a href=<?php echo ROOT . "settings"; ?>>
            <span class="glyphicon glyphicon-cog"></span> Settings</a>
        </li>
        <?php if ($_SESSION['accessLevel'] >= 1000): ?>
          <li<?php echo $controller->name == 'admin' ? ' class="active"' : ''; ?>>
            <a href=<?php echo ROOT . "admin"; ?>>
              <span class="glyphicon glyphicon-tower"></span> Admin</a>
          </li>
        <?php endif; ?>
        <!-- Navigation Right -->
        <li class="pull-right"><a href=<?php echo ROOT . "user/logout"; ?>><span
              class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
