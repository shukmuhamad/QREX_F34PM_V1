<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Outgoing Inspection Record Summary</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">OIR Summary</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- Summary OIR -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Summary OIR</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <form method="post">
                  <!-- Date range -->
                  <div class="form-group">
                    <label>Inspection Date Range:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" name="dateRange" class="form-control float-right" id="daterange" readonly>
                      <span class="input-group-append">
                        <button type="submit" name="oirSummarySubmit" class="btn btn-success btn-flat">Search</button>
                      </span>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                </form>
                <!-- /.form -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table -->
            <table id="table" class="table table-bordered table-striped nowrap">
              <thead>
              <tr>
                <th>Action</th>
                <th>OIR Number</th>
                <th>Inspection Date</th>
                <th>Job Number</th>
                <th>Item</th>
                <th>CheckedBy</th>
                <th>Inspection Type</th>
                <th>Completion Status</th>
                <th>Overall Result</th>
                <th>Verified By</th>
                <th>RecordID</th>
              </tr>
              </thead>
              <tbody>

              <?php 
                if(isset($_POST['oirSummarySubmit'])){

                  //Slicing the start and end date from daterange into sql server format
                  $startDate = date('Y-m-d', strtotime(str_replace("/","-",substr($_POST['dateRange'],0,10))));
                  $endDate = date('Y-m-d', strtotime(str_replace("/","-",substr($_POST['dateRange'],13,26))));

                  //Query statements to select from view_1
                  $query = "{CALL SP_OIRTrackingLog(?, ?)}";
                  $stmt = $conn->prepare($query);
                  $stmt->bindParam(1, $startDate);
                  $stmt->bindParam(2, $endDate);
                    
                  if($stmt->execute()){
                    //Toast success message
                    echo '<script>toastr.success("Data has been fetched from the database successfully!");</script>';
                  }else{
                    //Toast error message
                    echo '<script>toastr.error("There was a problem encountered when fetching data from the database!")</script>';
                  }
    
                  //Loop every row from query
                  while ($row=$stmt->fetch()) {
              ?>

              <tr>
                <td>
                  <a class="btn btn-primary btn-sm" href="viewoir.php?RecordID=<?php echo $row['RecordID']?>" target="_blank">
                    <i class="fas fa-eye">
                    </i>
                    View
                  </a>
                  
                </td>
                <td>
                  <?php echo $row['OIRNumber'];?>
                </td>
                <td>
                  <?php echo date('d/m/Y h:i A',strtotime($row['InspectionDateTime']));?>
                </td>
                <td>
                  <?php echo $row['JobNumber'];?>
                </td>
                <td>
                  <?php echo $row['ItemName'];?>
                </td>
                <td>
                  <?php 
                  $checkby_arr = explode(',', $row['CheckedBy']);
                  $checkby_arr = array_unique($checkby_arr);
                   $checkby_str = implode(',', $checkby_arr);
                    echo $checkby_str;
                    ?>
                </td>
                <td>
                  <?php echo $row['InspectionType'];?>
                </td>
                <td>
                  <?php echo $row['InspectionProgress'];?>
                </td>
                <td>
                  <?php echo $row['OverallResult'];?>
                </td>
                <td>
                  <?php echo $row['VerifiedBy'];?>
                </td>
                <td>
                  <?php echo $row['RecordID'];}}?>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->  

      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <?php
  //If user logged in as worker then hide Edit Button
  if($_SESSION['role']!='Staff'){
    echo '<script>$(".btn-info").hide()</script>';
  }

?>
<?php
  include('../includes/footer.php');
  include('../includes/scripts.php'); 
?>

<script>
  $(function () {
    //Table functions
    $("#table").DataTable({ 
      autoWidth: false, 
      lengthChange: false, 
      scrollX: true, 
      pageLength: 10,
      fixedColumns: {
        leftColumns: 2
      },
      buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8,9,10]
                }
            }, "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)')

    //Date range picker
    $('#daterange').daterangepicker({
      locale: {
        format: 'DD/MM/YYYY'
      }
    })
  })
</script>