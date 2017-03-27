<form class="form-signin" role="form" action="<?php echo ROOT . 'user/login'?>" method="post">
  <h2 class="form-signin-heading">Please sign in</h2>
  <?php if(Session::getMessage('error')): ?>
    <div class="alert alert-danger flash" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign"></span>
      <?php echo Session::getMessage('error'); Session::removeMessage('error'); ?>
    </div>
  <?php endif; ?>
  <?php if(Session::getMessage('warning')): ?>
    <div class="alert alert-info flash" role="alert">
      <span class="glyphicon glyphicon-info-sign"></span>
      <?php echo Session::getMessage('warning'); Session::removeMessage('warning'); ?>
    </div>
  <?php endif; ?>
  <input type="text" name="username"class="form-control" placeholder="Username" required autofocus>
  <input type="password" name="password"class="form-control" placeholder="Password" required>
  <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
</form>
