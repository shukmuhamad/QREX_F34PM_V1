  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Outgoing Inspection Record Pallet Form</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">OIR Pallet Form</li>
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

      <?php    
        $RecordID = $_GET['RecordID'];
      
        //Query statements to select Job Details
        $query1 = "SELECT * FROM View_OIRJobRecordByID WHERE RecordID = ?";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bindParam(1, $RecordID);
      
        $stmt1->execute();
        //Loop every row from query
        while ($jobRecord=$stmt1->fetch()) {   
      ?>

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
                <p><?php echo $jobRecord['PackagingTypeName'];}?></p>
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
      <form id="palletForm" action="../includes/transaction.php?RecordID=<?php echo $RecordID;?>" method="post">

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
                  <input type="text" name="palletNumber" class="form-control" placeholder="Pallet Number">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Size</label>
                  <select name="sizeSelect" class="form-control select2" style="width: 100%;">
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
                  <label>Item Number</label>
                  <input type="text" name="itemNumber" class="form-control" placeholder="Item Number" data-inputmask='"mask": "99"' data-mask>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Batch Size</label>
                  <input type="text" name="batchSize" class="form-control" id="batchSize" placeholder="Batch Size">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Sample Size</label>
                  <input type="text" class="form-control" id="sample" readonly>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Acceptance</label>
                  <input type="text" class="form-control" id="acceptance" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Quantity Check 1</label>
                  <input type="text" name="quantityCheck1" class="form-control" placeholder="Quantity Check 1">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Quantity Check 2</label>
                  <input type="text" name="quantityCheck2" class="form-control" placeholder="Quantity Check 2">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Quantity Check 3</label>
                  <input type="text" name="quantityCheck3" class="form-control" placeholder="Quantity Check 3">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Thickness</label>
                  <input type="text" name="thickness" class="form-control" placeholder="Thickness (µm)" data-inputmask='"mask": "999.99"' data-mask>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Grammage</label>
                  <input type="text" name="grammage" class="form-control" placeholder="Grammage (gsm)">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Rejectance</label>
                  <input type="text" class="form-control" id="rejectance" readonly>
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
                  <input type="text" name="dirtSPL" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Powder</label>
                  <input type="text" name="excessivePowder" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Paper Coating</label>
                  <input type="text" name="paperCoating" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Ink Smearing</label>
                  <input type="text" name="inkSmearing" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Fungus</label>
                  <input type="text" name="fungus" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Scratches (Printing)</label>
                  <input type="text" name="scrathesPrinting" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Water Mark</label>
                  <input type="text" name="waterMark" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>White Dots</label>
                  <input type="text" name="whiteDots" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Color Variation</label>
                  <input type="text" name="colorVariation" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Powder Mark</label>
                  <input type="text" name="powderMark" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Discoloration</label>
                  <input type="text" name="discoloration" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Misregistration</label>
                  <input type="text" name="misregistration" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Total Defects</label>
                  <input type="text" class="form-control" value="0" id="totalDefects" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>White Patches</label>
                  <input type="text" name="whitePatches" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Out of Position</label>
                  <input type="text" name="dcOOP" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Over/ Not Enough Pressure</label>
                  <input type="text" name="dcONEP" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Crack</label>
                  <input type="text" name="dcCrack" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Paper Dust</label>
                  <input type="text" name="excessivePaperDust" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>No Fibre Tear/ Insufficient glue</label>
                  <input type="text" name="noFTIG" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Scratches (Gluing)</label>
                  <input type="text" name="scrathesGluing" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Mixed Size/ Lot/ Flavour</label>
                  <input type="text" name="mixedSLF" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Shortage Quantity</label>
                  <input type="text" name="shortageQuantity" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Color Abrasion</label>
                  <input type="text" name="colorAbrasion" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Tear/ Damage</label>
                  <input type="text" name="tearDamage" class="form-control defect" placeholder="0">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Glue</label>
                  <input type="text" name="excessiveGlue" class="form-control defect" placeholder="0">
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
                  <input type="text" name="status" class="form-control" id="status" readonly>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Inspection Progress</label>
                  <select name="progressSelect" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="0">Ongoing</option>
                    <option value="1">Completed</option>
                  </select>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Remark <code>(optional)</code></label>
                  <input type="text" class="form-control" name="remark" placeholder="Remark">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Checked By</label>
                  <input type="text" class="form-control" value=<?php echo $_SESSION['name'];?> readonly>
                </div>
                <!-- /.form-group -->
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <center>  
              <button type="submit" name="palletSubmit" class="btn btn-primary">Save</button>
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