    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">QA Incoming Finishing Form</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Job Number</li>
              <li class="breadcrumb-item active">Finishing Inspection Form</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
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
      
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">
                Type of Finishing
              </h3>
            </div>
            <div class="card-body">
              <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <p><?php echo $oirRecord['FinishingName'];?></p>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

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
               <!--/.card body -->

 <!-- Form Start -->
 <form id="finishInspectForm" action="../includes/transaction.php?masterID=<?php echo $masterID;?>" method="post">
          <!-- Inspection -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Finishing Inspection</h3>
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
                    <label>Position/ Registration</label>
                    <input type="text" name="positionRegistry" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Finishing Effect</label>
                    <input type="text" name="finishEffect" class="form-control defect" onkeyup="calcTotalDefects()"placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Dirty</label>
                    <input type="text"  name ="dirty" class="form-control defect" onkeyup="calcTotalDefects()"placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Side Lay Stacking</label>
                    <input type="text"  name="sideLay" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
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
                    <label>Damages</label>
                    <input type="text"  name="damage" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Sticking</label>
                    <input type="text"  name="sticking" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Mixed Size</label>
                    <input type="text"  name="mixed" class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group" style="margin-top: 102px">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" id="status" readonly>
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

          <?php include('../includes/D_verify.php');?> 
        </form>
        <!-- /.form -->

      </div>
      <!-- /.container-fluid -->

      </section>
  <!-- /.content -->