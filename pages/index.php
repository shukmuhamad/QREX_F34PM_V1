<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
?>
<style>
  .card-header {
    background-color: #6c39a959;
    border-bottom: 1px solid rgba(0,0,0,.125);
    padding: .75rem 1.25rem;
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}
img {
    
    border-style: none;
    margin: auto;
    display: block;
}
  .card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
    font: unset;
    /* background-color:; */
}

  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
      
     
                
            <h1 class="m-0">Welcome to <?php echo $_SESSION['role'];?> page</h1>
    

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
      <center>
    <p> "You're going to go through tough times – that's life. But I say, ‘nothing happens to you, it happens for you."</p>
</center>
<center> <p> 
- Joel Osteen.</p></center>
</div>
        <!-- Main row -->
        <div class="row">
        <div class="col-sm-6">
          <!-- Left col -->
          <section class="col-lg-11 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="	fa fa-bar-chart mr-1"></i>
                  TOP GLOVE
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
              <img src="../dist/img/Top_Glove_logo.png" alt="Top Glove logo" width="450" height="300">
              </div><!-- /.card-body -->
</div>
</section>
            </div>
            <!-- /.card -->
            <div class="col-sm-6">
            <section class="col-lg-11 connectedSortable">
         
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="	fa fa-bar-chart mr-1"></i>
                  F34PM QREX
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
              <img src="../dist/img/F34PMLogoMain.jpg" alt="Top Glove logo" width="450" height="300">
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
         

            </section>

        
        </div>
        <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
   
  </div>
  <!-- /.content-wrapper -->
  
 
<?php
  include('../includes/footer.php');
  include('../includes/scripts.php'); 
?>

