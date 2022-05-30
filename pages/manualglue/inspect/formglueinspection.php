
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">QA Incoming Manual Glue/Work Inspection Form</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Job Number</li>
              <li class="breadcrumb-item active"> Manual Glue/Work Inspection Form</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


      <div class="container-fluid">
<?php    
  $masterID = $_GET['masterID'];

  //Query statements to select Job Details
  $query1 = "SELECT * FROM View_IncomingRecordByID WHERE RecordID = ?";
  $stmt1 = $conn->prepare($query1);
  $stmt1->bindParam(1, $masterID);

  $stmt1->execute();
  //Loop every row from query
  while ($oirRecord=$stmt1->fetch()) {   
?>

     <!-- Finished Goods Details -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Finished Goods Details</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
        <div class="form-group">
          <label>Inspection Date/ Time</label>
          <p><?php echo date('d/m/Y h:i A',strtotime($oirRecord['InspectionDateTime']));?></p>
        </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label>Item</label>
            <p><?php echo $oirRecord['ItemName'];?></p>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label>Job Number</label>
            <p><?php echo $oirRecord['JobNumber'];?></p>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label>Supplier</label>
            <p><?php echo $oirRecord['SupplierName'];?></p>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label>DO Number</label>
            <p><?php echo $oirRecord['DONumber'];?></p>
          </div>
          <!-- /.form-group -->
          </div>
          <!--/.col -->
          <div class="col-md-6">
          <!--/.col -->
          <div class="form-group">
          <!-- /.form-group -->
          <label>Job Quantity</label>
          <p><?php echo $oirRecord['JobQuantity'];?></p>
        </div>
        <div class="form-group">
          <!-- /.form-group -->
          <label>DO Quantity</label>
          <p><?php echo $oirRecord['DOQuantity'];?></p>
        </div>
        <div class="form-group">
          <!-- /.form-group -->
          <label>Report Number</label>
          <p><?php echo $oirRecord['ReportNumber'];?></p>
        </div>
        <div class="form-group">
          <!-- /.form-group -->
          <label>EP Code</label>
          <p><?php echo $oirRecord['EPCode'];?></p>
        </div>
        <div class="form-group">
          <!-- /.form-group -->
          <label>Received Date</label>
          <p><?php echo date('d/m/Y ', strtotime($oirRecord['DateReceived']));}?></p>
        </div>
         <!-- /.form-group -->
        </div>
         <!--/.col -->
         </div>
         <!--/.row -->

         </div>
            <!-- /.card-body -->


<!-- form start -->
<form id="glueInspectForm" action="../includes/transaction.php?masterID=<?php echo $masterID;?>" method="post">
            
   <!-- Inspection -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Manual Glue/Work Inspection</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                  <label>Size </label>
                  <select name="sizeRatioSelect" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">Select Size</option>
                    <?php 
                      //Loop every Size row
                      foreach ($fetchSize as $size) { 
                    ?>
                    <option value="<?php echo $size['SizeKey'];?>"><?php echo $size['SizeCode'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                <label>Size Lot:</label>
                    <input type="text" class="form-control" name="sizeNo" id="sizeNo" placeholder="Item No" required> 
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Sample</label>
                    <input type="text" class="form-control" id="sample" readonly>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                <div class="form-group">
                  <label>AQL</label>
                  <select name="aqlSelect" id="aql" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">Select AQL</option>
                    <?php 
                      //Loop every AQL row
                      foreach ($fetchAQL as $aql) { 
                    ?>
                    <option value="<?php echo $aql['AQLKey'];?>"><?php echo $aql['AQLValue'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                  <div class="form-group" style="margin-top: 52px">
                  <br /><br />
                    <label>Acceptance</label>
                    <input type="text"  class="form-control" id="acceptance" readonly >
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" name="qty" id="qty" class="form-control" placeholder="Quantity">
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group" style="margin-top: 52px">
                  <br /><br />
                    <label>Rejectance</label>
                    <input type="text" class="form-control" id="rejectance" readonly>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                <label>Position - Sticking of Promotion Items</label>
               <input type="text" name="stickPosition" class="form-control defect " placeholder="0" />
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Side Seam Misaligned</label>
                  <input type="text" name="sideSeam" class="form-control defect" placeholder="0" />
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive glue</label>
                  <input type="text" name="exGlue" class="form-control defect" placeholder="0" />
                </div>
                <!-- /.form-group -->
                
                <div class="form-group">
                  <label>Total Defects</label>
                <input type="text" class="form-control" id="totalDefects" readonly>                
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Side Seam Not Glued/ Stapled</label>
                  <input type="text"  name="sideStap" class="form-control defect" placeholder="0" />
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Material Torn/ Damaged</label>
                  <input type="text"  name="matDamn" class="form-control defect" placeholder="0" />
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>No String</label>
                  <input type="text"  name="noStri" class="form-control defect" placeholder="0" />
                </div>
                <!-- /.form-group -->
                <div class="form-group" >
                  <label>Status</label>
                  <input type="text" name="status" id="status" class="form-control" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

  <!-- Verify Card for Incoming forms -->
        <!-- Verify -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Checked</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                <label>Reject Disposition</label>
                  <select name="rejectSelect" class="form-control select2" style="width: 70%;">
                    <option selected="selected" value="2">N/A</option>
                    <option value="0">Hold for Screening</option>
                    <option value="1">Return to Sender</option>
                  </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Inspection Progress</label>
                  <select name="progressSelect" class="form-control select2" style="width: 70%;">
                    <option selected="selected" value="0">Ongoing</option>
                    <option value="1">Completed</option>
                  </select>
                </div>
                <!-- /.form-group -->
   
            
          </div>
                <div class="col-md-6">
                <div class="form-group" >
                  <label>Overall Status</label>
                  <select name="overallSelect" class="form-control select2" style="width: 70%;">
                    <option selected="selected" value="1"> Pass</option>
                    <option value="0">Fail</option>
                  </select>
                </div>
             </div>
		<div class="col-md-6">
              <div class="form-group" style="width: 70%;">
               <label> Checked By</label > 
               <input type="text" class="form-control" value="<?php echo $_SESSION['name'];?>" readonly>
                </div>
                <!-- /.form-group -->
              </div>
      
              <!-- /.col -->
            </div>
            <!-- /.row -->
         
          <div class="form-group" >
          <div class="card-footer">
            <center>  
            <button type="submit" name="glueInspectSubmit"class="btn btn-primary">Save</button>
            </center>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.container-fluid -->



    
    


