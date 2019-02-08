<?php require_once '../../global.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap.min.css'); ?>">

    <title>Hello, world!</title>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url('assets/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('common.js'); ?>"></script>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="#">Evaluation System</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-toggler">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar-toggler">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a href="<?php echo base_url('view/'); ?>">My Evaluation Results</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('view/teacher/myaccount.php'); ?>">My Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Logout</a>
          </li>
        </ul>
      </div>
    </nav>