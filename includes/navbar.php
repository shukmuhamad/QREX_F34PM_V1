<?php 
  //Include session in navbar so all pages has session included
  include('session.php');
?>

<!-- Navbar & Sidebar -->
<body class="sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="form-inline ml-3">QA Inspection Record</li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="form-inline ml-3"><?php echo $_SESSION['name'];?></li>
      <!-- User -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu">
          <!-- Logout -->
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            Logout
          </a>
        </div>
      </li> 
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../dist/img/F34PMLogo.jpg" alt="F34PM QREX Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">F34PM QREX</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    <!-- SidebarSearch Form -->
      <div class="mt-3">
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <!-- QC Check Sheet -->
          <li class="nav-header">QC CHECK SHEET</li>
          <li class="nav-item">
            <a href="checksheet.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Check Sheet Form
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="summarychecksheet.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Check Sheet Summary
              </p>
            </a>
          </li>

          <!-- QA Incoming -->
          <li class="nav-header">QA INCOMING</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Incoming Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="finish.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> New Finishing</p>
                </a>
              </li>
            
	          	<li class="nav-item">
                <a href="finishInspection.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ongoing Finishing</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="patching.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Window Patching</p>
                </a>
              </li>
		<li class="nav-item">
                <a href="patchingInspection.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ongoing Window Patching </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="flute.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Flute</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="fluteInspection.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ongoing Flute</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manualglue.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Manual Glue/Work</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manualInspection.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ongoing Manual Glue/Work </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="print.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Printing</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="printInspection.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ongoing Printing</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="diecut.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Die Cut</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="dieInspection.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ongoing Die Cut</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="summaryincoming.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Incoming Summary
              </p>
            </a>
          </li>

          <!-- OIR -->
          <li class="nav-header">OIR</li>
          <li class="nav-item">
            <a href="oirjob.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
               New OIR
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="oirpallet.php" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Ongoing OIR 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="summaryoir.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                OIR Summary
              </p>
            </a>
          </li>
       

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <form action="../includes/transaction.php" method="POST"> 
            <button type="submit" name="logoutSubmit" class="btn btn-primary">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>