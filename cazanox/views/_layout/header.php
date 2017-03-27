<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
  <link href="<?php echo ROOT . "assets/css/bootstrap.css"; ?>" rel="stylesheet">
  <link href="<?php echo ROOT . "assets/css/datepicker3.css"; ?>" rel="stylesheet">
  <link href="<?php echo ROOT . "assets/css/bootstrap-select.css"; ?>" rel="stylesheet">
  <link href="<?php echo ROOT . "assets/css/custom.css"; ?>" rel="stylesheet">

  <script src="<?php echo ROOT . "assets/js/jquery-2.1.1.js"; ?>"></script>
  <script src="<?php echo ROOT . "assets/js/datepicker.js"; ?>"></script>
  <script src="<?php echo ROOT . "assets/js/bootstrap.min.js"; ?>"></script>
  <script src="<?php echo ROOT . "assets/js/fade.js"; ?>"></script>

  <title>fleXtime</title>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <?php if (Session::getMessage('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <span class="glyphicon glyphicon-remove"></span>
          <strong><?php echo Session::getMessage('error') ?></strong>
        </div>
        <?php Session::removeMessage('error'); endif; ?>
      <?php if (Session::getMessage('success')): ?>
        <?php if (Session::getMessage('showMessages') == 'Yes'): ?>
          <div class="alert alert-success  alert-dismissible flash" role="alert">
            <button type="button" class="close" data-dismiss="alert">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
            </button>
            <span class="glyphicon glyphicon-ok"></span>
            <strong> <?php echo Session::getMessage('success'); ?></strong>
          </div>
        <?php endif; ?>
        <?php Session::removeMessage('success'); endif; ?>
    </div>
  </div>