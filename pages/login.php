<?php
  include('../includes/header.php');
?>

<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <p class="h1"><b>F34PM</b> QREX</p>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="../includes/transaction.php" method="post">
        <div class="input-group mb-3">
          <input type="text" name="badgeID" class="form-control" placeholder="Badge ID">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-circle"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <button type="submit" name="loginSubmit" class="btn btn-primary btn-block">Sign In</button>
      </form>
 
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<?php
  include('../includes/scripts.php');
?>

<?php
  //Toast message after login attempt
  if(isset($_GET['action'])){
    if($_GET['action']=='incorrect'){
      echo '<script>toastr.error("Badge ID and Password do not match!");</script>';
    }else{
      echo '<script>toastr.error("There was a problem encountered during the database connection!")</script>';
    }
  }
?>