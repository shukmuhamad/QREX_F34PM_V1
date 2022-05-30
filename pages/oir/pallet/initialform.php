<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Search Outgoing Inspection Record Form</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">OIR Initial Form</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <!-- Form Start -->
    <form id="initialForm" action="../includes/transaction.php" method="post">

      <!-- Initial Job Details -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Initial Job Details</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Job Number</label>
                <input type="text" name="jobNumber" id="jobNumber" class="form-control" placeholder="JobNumber">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label>OIR Number</label>
                <input type="text" name="oirNumber" id="oirNumber" class="form-control" >
              </div>
              <!-- /.form-group --> 
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <center>  
            <button type="submit" name="initialSubmit" class="btn btn-primary">Next</button>
          </center>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </form>
    <!-- /.form -->

  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->


<!-- for reference mana yang nak cari -->
<!--If OIR Number is not empty
    if($_POST['oirNumber']!='OIR/__/__/___/_'){

      $oirNumber = $_POST['oirNumber'];

      //Query statements to check Job Record
      $query = "SELECT MasterID FROM ViewOIRJobRecordByID WHERE JobNumber = ? AND OIRNumber = ? AND InspectionType = 'Reinspection' AND InspectionProgress = 'Incomplete'";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $jobNumber);
      $stmt->bindParam(2, $oirNumber);

    }//If just Job Number is inputted
    else{

      //Query statements to check Job Record
      $query = "SELECT MasterID FROM ViewOIRJobRecordByID WHERE JobNumber = ? AND InspectionType = 'New Inspection' AND InspectionProgress = 'Incomplete'";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $jobNumber);
    }

    -->
  