<?php require_once '../../global.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dataTables.bootstrap4.min.css'); ?>">

    <title>Evaluation System</title>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url('assets/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/dataTables.bootstrap4.min.js'); ?>"></script>
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
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbar-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Manage
            </a>
            <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
              <a class="dropdown-item" href="<?php echo base_url('view/admin/index.php'); ?>">Admin</a>
              <a class="dropdown-item" href="<?php echo base_url('view/teacher/index.php'); ?>">Teacher</a>
              <a class="dropdown-item" href="<?php echo base_url('view/student/index.php'); ?>">Student</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php echo base_url('view/yearlevel/index.php'); ?>">Year Level</a>
              <a class="dropdown-item" href="<?php echo base_url('view/department/index.php'); ?>">Department</a>
              <a class="dropdown-item" href="<?php echo base_url('view/course/index.php'); ?>">Course</a>
              <a class="dropdown-item" href="<?php echo base_url('view/section/index.php'); ?>">Section</a>
              <a class="dropdown-item" href="<?php echo base_url('view/subject/index.php'); ?>">Subject</a>
              <a class="dropdown-item" href="<?php echo base_url('view/schedule/index.php'); ?>">Schedule</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php echo base_url('view/question/index.php'); ?>">Question</a>
              <a class="dropdown-item" href="<?php echo base_url('view/rating/index.php'); ?>">Rating</a>
              <!-- <a class="dropdown-item" href="<?php echo base_url('view/evaluation_schedule/index.php'); ?>">Evaluation Schedule</a> -->
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('view/report/index.php'); ?>">View Evaluation Report</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('view/admin/myaccount.php'); ?>">My Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('queries/logout.php') ?>">Logout</a>
          </li>
        </ul>
      </div>
    </nav>