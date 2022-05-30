<?php 


  //Assign MasterID & PalletID to variable
  $RecordID = $_GET['RecordID'];

  //Query statements to select Job Details
  $query1 = "SELECT * FROM View_OIRJobRecordByID WHERE RecordID = ?";
  $stmt1 = $conn->prepare($query1);
  $stmt1->bindParam(1, $RecordID);
  $stmt1->execute();

  //Loop every row from query
  while ($jobRecord=$stmt1->fetch()){  
?>

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Outgoing Inspection Record Pallet Form</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Edit OIR Pallet Form</li>
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
      
      <!-- Job Details -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Job Details</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-6">
          <div class="form-group">
                  <label>Inspection Plan</label>
                  <p>WI 8.6-01</p>
                </div>
            
              <div class="form-group">
                <label>Customer</label>
                <p><?php echo $jobRecord['CustomerName'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Item</label>
                <p><?php echo $jobRecord['ItemName'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Quantity per Bundle</label>
                <p><?php echo $jobRecord['QuantityPerBundle'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Quantity per Packing</label>
                <p><?php echo $jobRecord['QuantityPerPacking'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Inspection Section</label>
                <p><?php echo $jobRecord['InspectionSectionName'];?></p>
              </div>
              <!-- /.form-group --> 
              <div class="form-group">
                <label>Inspection Type</label>
                <p><?php echo $jobRecord['InspectionType'];?></p>
              </div>
              <!-- /.form-group --> 
            </div>
            <!-- /.col -->

            <div class="col-md-6">
              <div class="form-group">
                <label>Inspection Date/ Time</label>
                <p><?php echo date('d/m/Y h:i A',strtotime($jobRecord['InspectionDateTime']));?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>OIR Number</label>
                <p><?php echo $jobRecord['OIRNumber'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Job Number</label>
                <p><?php echo $jobRecord['JobNumber'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>EP Code</label>
                <p><?php echo $jobRecord['EPCode'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>AQL</label>
                <p id="aql"><?php echo $jobRecord['AQLValue'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Packing Type</label>
                <p><?php echo $jobRecord['PackagingTypeName'];?></p>
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

      <!-- Form Start -->
      <form id="palletForm" action="../includes/transaction.php?RecordID=<?php echo $RecordID.'&palletID='.$palletID;?>" method="post">

        <?php
          //Query statements to select Pallet Details
          $query2 = "SELECT * FROM View_OIRPalletRecordByID WHERE RecordID = ? AND RecordPalletID = ?";
          $stmt2 = $conn->prepare($query2);
          $stmt2->bindParam(1, $RecordID);
          $stmt2->bindParam(2, $palletID);

          $stmt2->execute();
          //Loop every row from query
          while ($palletRecord=$stmt2->fetch()) {

            //Include file to calculate Sample Size, Acceptance & Rejectance
            include('../includes/autocalculate.php');
        ?>

        <!-- Pallet Details -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Pallet Details</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Pallet Number</label>
                  <input type="text" name="palletNumber" value="<?php echo $palletRecord['PalletNumber'];?>" class="form-control" placeholder="Pallet Number">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Size</label>
                  <select name="sizeSelect" class="form-control select2" style="width: 100%;">
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
                  <label>Item Number</label>
                  <input type="text" name="itemNumber" value="<?php echo $palletRecord['ItemNumber'];?>" class="form-control" placeholder="Item Number"  data-inputmask='"mask": "99"' data-mask>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Batch Size</label>
                  <input type="text" name="batchSize" value="<?php echo $palletRecord['BatchSize'];?>" class="form-control" id="batchSize" placeholder="Batch Size">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Sample Size</label>
                  <input type="text" value="<?php echo $sample;?>" class="form-control"  id="sample" readonly>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Acceptance</label>
                  <input type="text" value="<?php echo $acc;?>" class="form-control" id="acceptance" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Quantity Check 1</label>
                  <input type="text" name="quantityCheck1" value="<?php echo $palletRecord['QuantityCheck1'];?>" class="form-control" placeholder="Quantity Check 1">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Quantity Check 2</label>
                  <input type="text" name="quantityCheck2" value="<?php echo $palletRecord['QuantityCheck2'];?>" class="form-control" placeholder="Quantity Check 2">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Quantity Check 3</label>
                  <input type="text" name="quantityCheck3" value="<?php echo $palletRecord['QuantityCheck3'];?>" class="form-control" placeholder="Quantity Check 3">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Thickness</label>
                  <input type="text" name="thickness" value="<?php echo $palletRecord['Thickness'];?>" class="form-control" placeholder="Thickness (µm)" data-inputmask='"mask": "999.99"' data-mask>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Grammage</label>
                  <input type="text" name="grammage" value="<?php echo $palletRecord['GSM'];?>" class="form-control" placeholder="Grammage (gsm)">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Rejectance</label>
                  <input type="text" value="<?php echo $rej;?>" class="form-control" id="rejectance" readonly>
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

        <!-- Defects -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Defects</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Dirt/ Stain/ Printing Line</label>
                  <input type="text" name="dirtSPL" value="<?php echo $palletRecord['Dirt/ Stain/ Printing Line'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Powder</label>
                  <input type="text" name="excessivePowder" value="<?php echo $palletRecord['Excessive Powder'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Paper Coating</label>
                  <input type="text" name="paperCoating" value="<?php echo $palletRecord['Paper Coating'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Ink Smearing</label>
                  <input type="text" name="inkSmearing" value="<?php echo $palletRecord['Ink Smearing'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Fungus</label>
                  <input type="text" name="fungus" value="<?php echo $palletRecord['Fungus'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Scratches (Printing)</label>
                  <input type="text" name="scrathesPrinting" value="<?php echo $palletRecord['Scratches (Printing)'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Water Mark</label>
                  <input type="text" name="waterMark" value="<?php echo $palletRecord['Water Mark'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>White Dots</label>
                  <input type="text" name="whiteDots" value="<?php echo $palletRecord['White Dots'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Color Variation</label>
                  <input type="text" name="colorVariation" value="<?php echo $palletRecord['Color Variation'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Powder Mark</label>
                  <input type="text" name="powderMark" value="<?php echo $palletRecord['Powder Mark'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Discoloration</label>
                  <input type="text" name="discoloration" value="<?php echo $palletRecord['Discoloration'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Misregistration</label>
                  <input type="text" name="misregistration" value="<?php echo $palletRecord['Misregistration'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Total Defects</label>
                  <input type="text" class="form-control" value="<?php echo $palletRecord['TotalDefects'];?>" id="totalDefects" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>White Patches</label>
                  <input type="text" name="whitePatches" value="<?php echo $palletRecord['White Patches'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Out of Position</label>
                  <input type="text" name="dcOOP" value="<?php echo $palletRecord['DC Out of Position'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Over/ Not Enough Pressure</label>
                  <input type="text" name="dcONEP" value="<?php echo $palletRecord['DC Over/ Not Enough Pressure'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Crack</label>
                  <input type="text" name="dcCrack" value="<?php echo $palletRecord['DC Crack'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Paper Dust</label>
                  <input type="text" name="excessivePaperDust" value="<?php echo $palletRecord['Excessive Paper Dust'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>No Fibre Tear/ Insufficient glue</label>
                  <input type="text" name="noFTIG" value="<?php echo $palletRecord['No Fibre Tear/ Insufficient glue'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Scratches (Gluing)</label>
                  <input type="text" name="scrathesGluing" value="<?php echo $palletRecord['Scratches (Gluing)'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Mixed Size/ Lot/ Flavour</label>
                  <input type="text" name="mixedSLF" value="<?php echo $palletRecord['Mixed Size/ Lot/ Flavour'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Shortage Quantity</label>
                  <input type="text" name="shortageQuantity" value="<?php echo $palletRecord['Shortage Quantity'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Color Abrasion</label>
                  <input type="text" name="colorAbrasion" value="<?php echo $palletRecord['Color Abrasion'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Tear/ Damage</label>
                  <input type="text" name="tearDamage" value="<?php echo $palletRecord['Tear/ Damage'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Glue</label>
                  <input type="text" name="excessiveGlue" value="<?php echo $palletRecord['Excessive Glue'];?>" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

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
                  <label>Status</label>
                  <input type="text" name="status" value="<?php echo $palletRecord['Status'];?>" class="form-control" id="status" readonly>
                </div>
                <!-- /.form-group -->
                
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Remark <code>(optional)</code></label>
                  <input type="text" class="form-control" name="remark" value="<?php echo $palletRecord['Remark'];?>" placeholder="Remark">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
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
              <button type="submit" name="palletUpdate" class="btn btn-primary">Update</button>
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