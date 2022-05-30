<?php
//Assign MasterID to variable
$masterID = $_GET['masterID'];

//Query to call sp for Check Sheet Record
$query = "SELECT * FROM View_IncomingRecordByID WHERE RecordID = ? ";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $masterID);
$stmt->execute();


//Assign Result for query into variable
while ($jobRecord = $stmt->fetch()) {
?>

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Incoming Printing Form</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Edit Printing Form</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->

  <div class="container-fluid">

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
              <p><?php echo date('d/m/Y h:i A', strtotime($jobRecord['InspectionDateTime'])); ?></p>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label>Item</label>
              <p><?php echo $jobRecord['ItemName']; ?></p>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label>Job Number</label>
              <p><?php echo $jobRecord['JobNumber']; ?></p>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label>Supplier</label>
              <p><?php echo $jobRecord['SupplierName']; ?></p>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label>DO Number</label>
              <p><?php echo $jobRecord['DONumber']; ?></p>
            </div>
            <!-- /.form-group -->
          </div>
          <!--/.col -->
          <div class="col-md-6">
            <!--/.col -->
            <div class="form-group">
              <!-- /.form-group -->
              <label>Job Quantity</label>
              <p><?php echo $jobRecord['JobQuantity']; ?></p>
            </div>
            <div class="form-group">
              <!-- /.form-group -->
              <label>DO Quantity</label>
              <p><?php echo $jobRecord['DOQuantity']; ?></p>
            </div>
            <div class="form-group">
              <!-- /.form-group -->
              <label>Report Number</label>
              <p><?php echo $jobRecord['ReportNumber']; ?></p>
            </div>
            <div class="form-group">
              <!-- /.form-group -->
              <label>EP Code</label>
              <p><?php echo $jobRecord['EPCode']; ?></p>
            </div>
            <div class="form-group">
              <!-- /.form-group -->
              <label>Received Date</label>
              <p><?php echo date('d/m/Y ', strtotime($jobRecord['DateReceived'])); ?></p>
            </div>
            <!-- /.form-group -->
          </div>
          <!--/.col -->
        </div>
        <!--/.row -->

      </div>
      <!--/.card body -->
      <script src="../dist/js/autocalculatefinish.js"></script>
      <!-- Form Start -->
      <form id="print7" action="../includes/transaction.php?masterID=<?php echo $masterID . '&incomingID=' . $incomingID; ?>" method="post">

        <?php
        //Query statements to select Pallet Details
        $query = "SELECT * FROM View_PrintInspectRecordByID WHERE RecordID = ? AND IncomingResultID = ?";
        $stmt1 = $conn->prepare($query);
        $stmt1->bindParam(1, $masterID);
        $stmt1->bindParam(2, $incomingID);

        $stmt1->execute();
        //Loop every row from query
        while ($palletRecord = $stmt1->fetch()) {

          //Include file to calculate Sample Size, Acceptance & Rejectance
          include('../includes/autocalculatefinish.php');
        ?>

          <!-- Inspection -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Printing Inspection</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Size</label>
                    <select name="sizeRatioSelect" class="form-control select2" style="width: 100%;">
                      <option value="">Select Size</option>
                      <?php
                      //Loop every Size row
                      foreach ($fetchSize as $size) {
                      ?>
                        <option value="<?php echo $size['SizeKey']; ?>" <?php if ($palletRecord['SizeCode'] == $size['SizeCode']) {
                                                                          echo 'selected';
                                                                        } ?>><?php echo $size['SizeCode'];
                                                                                                                                                  } ?></option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Size Lot:</label>
                    <input type="text" name="sizeNo" value="<?php echo $palletRecord['ItemNumber']; ?>" class="form-control" placeholder="Item Number" required>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Sample Size</label>
                    <input type="text" value="<?php echo $sample; ?>" class="form-control" id="sample" readonly>
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
                        <option value="<?php echo $aql['AQLKey']; ?>" onchange="calcSampleAccRej()" <?php if ($palletRecord['AQLValue'] == $aql['AQLValue']) {
                                                                                                      echo 'selected';
                                                                                                    } ?>><?php echo $aql['AQLValue'];
                                                                                                                                                                            } ?></option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group" style="margin-top: 52px">
                    <br /><br />
                    <label>Acceptance</label>
                    <input type="text" value="<?php echo $acc; ?>" class="form-control" id="acceptance" readonly>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" name="qty" value="<?php echo $palletRecord['Quantity']; ?>" class="form-control" id="qty" onkeyup="calcSampleAccRej()" placeholder="Quantity">
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group" style="margin-top: 52px">
                    <br /><br />
                    <label>Rejectance</label>
                    <input type="text" value="<?php echo $rej; ?>" class="form-control" id="rejectance" readonly>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Position Layout</label>
                    <input type="text" name="postLay" value="<?php echo $palletRecord['Position Layout']; ?>" class="form-control defect " onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Registration</label>
                    <input type="text" name="rest" value="<?php echo $palletRecord['Registration']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Sticking</label>
                    <input type="text" name="stick" value="<?php echo $palletRecord['Sticking']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Mixed Size</label>
                    <input type="text" name="mixed" value="<?php echo $palletRecord['Mixed Size']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Spot Varnish</label>
                    <input type="text" name="spotVar" value="<?php echo $palletRecord['Spot Varnish']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Incomplete Printing</label>
                    <input type="text" name="incomp" value="<?php echo $palletRecord['Incomplete Printing']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Verification of Printed Text</label>
                    <input type="text" name="verify" value="<?php echo $palletRecord['Verification of Printed Text']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>Total Defects</label>
                    <input type="text" value=<?php echo $palletRecord['TotalDefects']; ?> class="form-control" id="totalDefects" readonly>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Color Variation</label>
                    <input type="text" name="colorVar" value="<?php echo $palletRecord['Color Variation']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Dirt/ Ink Smearing</label>
                    <input type="text" name="dirt" value="<?php echo $palletRecord['Dirt/Ink Smearing']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Barcode</label>
                    <input type="text" name="bar" value="<?php echo $palletRecord['Barcode']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Lot No / Part No</label>
                    <input type="text" name="lot" value="<?php echo $palletRecord['Lot No./Part No']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Doubling</label>
                    <input type="text" name="doub" value="<?php echo $palletRecord['Doubling']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Water Mark</label>
                    <input type="text" name="water" value="<?php echo $palletRecord['Water Mark']; ?>" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0">
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" id="status" value="<?php echo $palletRecord['Status']; ?>" class="form-control" readonly>
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


                      <option value=0 <?php if ($palletRecord['RejectDisposition'] == 0) {
                                        echo 'selected';
                                      } ?>>Hold for Screening</option>
                      <option value=1 <?php if ($palletRecord['RejectDisposition'] == 1) {
                                        echo 'selected';
                                      } ?>>Return to Sender</option>
                      <option value=2 <?php if ($palletRecord['RejectDisposition'] == 2) {
                                        echo 'selected';
                                      } ?>>N/A</option>
                    </select>
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Inspection Progress</label>
                    <select name="progressSelect" class="form-control select2" style="width: 70%;">
                      <option value="0" <?php if ($palletRecord['InspectionProgress'] == 'Incomplete') {
                                          echo 'selected';
                                        } ?>>Ongoing</option>
                      <option value="1" <?php if ($palletRecord['InspectionProgress'] == 'Completed') {
                                          echo 'selected';
                                        } ?>>Completed</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Overall Status</label>
                    <select name="overallSelect" class="form-control select2" style="width: 70%;">

                      <option value="0" <?php if ($palletRecord['OverallResult'] == '0') {
                                          echo 'selected';
                                        } ?>>Fail</option>
                      <option value="1" <?php if ($palletRecord['OverallResult'] == '1') {
                                          echo 'selected';
                                        } ?>>Pass</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group" style="width: 70%;">
                    <label>Checked By</label>
                    <input type="text" class="form-control" value="<?php echo $palletRecord['CheckedBy'];
                                                                  }
                                                                } ?>" readonly>

                    <!-- 1st php curly braces for $palletRecord, 2nd curly braces for $jobRecord -->
                  </div>
                  <!-- /.form-group -->

                </div>

              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <center>

                <button type="submit" name="editprintInspectSubmit" class="btn btn-primary">Update</button>


              </center>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->


      </form>
      <!-- /.form -->

    </div>
    <!-- /.container-fluid -->