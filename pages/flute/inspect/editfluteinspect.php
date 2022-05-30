
<?php
   //Assign MasterID & PalletID to variable
   $masterID = $_GET['masterID'];

   //Query statements to select Job Details
   $query = "SELECT * FROM View_IncomingRecordByID WHERE RecordID = ?";
   $stmt = $conn->prepare($query);
   $stmt->bindParam(1, $masterID);
   $stmt->execute();
 
   //Loop every row from query
   while ($jobRecord=$stmt->fetch()){  
  
?>


  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit QA Incoming Flute Form</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Edit Flute Inspection Form</li>
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
  
    <div class="container-fluid">

  <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">
                Type of Flute
              </h3>
            </div>
            <div class="card-body">
              <div class="row">
              <div class="col-md-6">
              <div class="form-group">
             <option>   <p><?php echo $jobRecord['FluteName'];?></p> </option>
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
                <p><?php echo date('d/m/Y h:i A',strtotime($jobRecord['InspectionDateTime']));?></p>
              </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Item</label>
                  <p><?php echo $jobRecord['ItemName'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Job Number</label>
                  <p><?php echo $jobRecord['JobNumber'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Supplier</label>
                  <p><?php echo $jobRecord['SupplierName'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DO Number</label>
                  <p><?php echo $jobRecord['DONumber'];?></p>
                </div>
                <!-- /.form-group -->
                </div>
                <!--/.col -->
                <div class="col-md-6">
                <!--/.col -->
                <div class="form-group">
                <!-- /.form-group -->
                <label>Job Quantity</label>
                <p><?php echo $jobRecord['JobQuantity'];?></p>
              </div>
              <div class="form-group">
                <!-- /.form-group -->
                <label>DO Quantity</label>
                <p><?php echo $jobRecord['DOQuantity'];?></p>
              </div>
              <div class="form-group">
                <!-- /.form-group -->
                <label>Report Number</label>
                <p><?php echo $jobRecord['ReportNumber'];?></p>
              </div>
              <div class="form-group">
                <!-- /.form-group -->
                <label>EP Code</label>
                <p><?php echo $jobRecord['EPCode'];?></p>
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
 <form id="fluteInspect" action="../includes/transaction.php?masterID=<?php echo $masterID.'&incomingID='.$incomingID;?>" method="post">

 <?php
          //Query statements to select Pallet Details
          $query = "SELECT * FROM View_FluteInspectRecordByID WHERE RecordID = ? AND IncomingResultID = ?";
          $stmt1 = $conn->prepare($query);
          $stmt1->bindParam(1, $masterID);
          $stmt1->bindParam(2, $incomingID);

          $stmt1->execute();
          //Loop every row from query
          while ($palletRecord=$stmt1->fetch()) {

            //Include file to calculate Sample Size, Acceptance & Rejectance
            include('../includes/autocalculatefinish.php');
        ?>

          <!-- Inspection -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Flute Inspection</h3>
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
                    <option value="<?php echo $size['SizeKey'];?>" <?php if($palletRecord['SizeCode']==$size['SizeCode']){ echo 'selected';}?>><?php echo $size['SizeCode'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                <label>Size Lot:</label>
                <input type="text" name="sizeNo" value="<?php echo $palletRecord['ItemNumber'];?>" class="form-control" placeholder="Item Number" required >
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                  <label>Sample Size</label>
                  <input type="text" value="<?php echo $sample;?>" class="form-control"  id="sample" readonly>
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
                     <option  value="<?php echo $aql['AQLKey'];?>" onchange="calcSampleAccRej()"<?php if($palletRecord['AQLValue']==$aql['AQLValue']){ echo 'selected';}?>><?php echo $aql['AQLValue'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                  <div class="form-group" style="margin-top: 52px">
                  <br /><br />
                  <label>Acceptance</label>
                  <input type="text" value="<?php echo $acc;?>" class="form-control" id="acceptance" readonly>
                </div>
                <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                <div class="form-group">
                <label>Quantity</label>
                    <input type="text" name="qty" value="<?php echo $palletRecord['Quantity'];?>" class="form-control" id="qty" onkeyup="calcSampleAccRej()" placeholder="Quantity">
                  </div>
                  <!-- /.form-group -->
               
                  <div class="form-group" style="margin-top: 52px">
                  <br /><br />
                    <label>Rejectance</label>
                     <input type="text" value="<?php echo $rej;?>" class="form-control" id="rejectance" readonly>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                <div class="form-group">
                    <label>Colour Variation</label>
                    <input type="text" name="colorVar"value= "<?php echo $palletRecord['Color Variation'];?>"  class="form-control defect " onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Position Layout</label>
                    <input type="text" name="postLay" value= "<?php echo $palletRecord['Position Layout'];?>"  class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Mixed Size</label>
                    <input type="text"  name ="mixed" value= "<?php echo $palletRecord['Mixed Size'];?>"  class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Side Seam Misaligned</label>
                    <input type="text"  name="sideSeam" value= "<?php echo $palletRecord['Side Seam Misaligned'];?>"  class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Die-Cut Paper Facing Up/ Down</label>
                    <input type="text"  name="dieCut" value= "<?php echo $palletRecord['Die-Cut Paper Facing Up/Down'];?>"  class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Barcode</label>
                    <input type="text"  name="barcode"  value= "<?php echo $palletRecord['Barcode'];?>"  class="form-control defect" onkeyup="calcTotalDefects()"  placeholder="0" />
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>Total Defects</label>
                    <input type="text" value= <?php echo $palletRecord['TotalDefects'];?>  class="form-control" id="totalDefects" readonly>
                  </div>
  <!-- /.form-group -->
  </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Dirty</label>
                    <input type="text"  name="dirty" value= "<?php echo $palletRecord['Dirty'];?>"  class="form-control defect" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Flute Position Out</label>
                    <input type="text"  name="flutepost" value= "<?php echo $palletRecord['Flute Position Out'];?>"  class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Side Seam Not Glued/ Stapled</label>
                    <input type="text"  name="sideGlued" value= "<?php echo $palletRecord['Side Seam Not Glue/Stapled'];?>"  class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Material Torn/ Damage</label>
                    <input type="text"  name="matThorn" value="<?php echo $palletRecord['Material Torn/Damage'];?>"  class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Poor Cut-Edge</label>
                    <input type="text"  name="poorCut" value= "<?php echo $palletRecord['Poor Cut-Edge'];?>"  class="form-control defect" onkeyup="calcTotalDefects()" placeholder="0" />
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group" style="margin-top: 102px">
                    <label>Status</label>
                    <input type="text" name="status" value= <?php echo $palletRecord['Status'];?>  class="form-control" id="status" readonly>
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
                 
                 
                  <option value=0 <?php if($palletRecord['RejectDisposition']==0){echo 'selected';}?>>Hold for Screening</option>
                  <option value=1 <?php if($palletRecord['RejectDisposition']==1){echo 'selected';}?>>Return to Sender</option>
                  <option value=2 <?php if($palletRecord['RejectDisposition']==2){echo 'selected';}?>>N/A</option>
                  </select>
                </div>

                </div>
                <div class="col-md-6">
     <div class="form-group">
                  <label>Inspection Progress</label>
                  <select name="progressSelect" class="form-control select2" style="width: 70%;">
                    <option value="0" <?php if($jobRecord['InspectionProgress']=='Incomplete'){echo 'selected';}?>>Ongoing</option>
                    <option value="1" <?php if($jobRecord['InspectionProgress']=='Completed'){echo 'selected';}?>>Completed</option>
                  </select>
                </div>
                <!-- /.form-group -->
            
          </div>
                <div class="col-md-6">
                <div class="form-group" >
                  <label>Overall Status</label>
                  <select name="overallSelect" class="form-control select2" style="width: 70%;">
                  <option value="0" <?php if($palletRecord['OverallResult']=='0'){echo 'selected';}?>>Fail</option>
                  <option value="1" <?php if($palletRecord['OverallResult']=='1'){echo 'selected';}?>>Pass</option>
                  </select>
                  </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group" style="width: 70%;">
                  <label>Checked By</label>
           
                  <input type="text" class="form-control" value="<?php echo $palletRecord['CheckedBy'];}}?>" readonly>
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
              
              <button type="submit" name="editfluteUpdate" class="btn btn-primary">Update</button>
         
            </center>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
              

        </form>
        <!-- /.form -->

        </div>
    <!-- /.container-fluid -->
