<?php
  include('../includes/header.php');
  include('../includes/session.php');
  include('../includes/database.php');
?>

<body>

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">View Outgoing Inspection Record Form</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">View OIR Form</li>
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
      if(isset($_GET['RecordID'])){

        //Assign InspectionID to variable
        $RecordID = $_GET['RecordID'];

        //Query statements to select from view table
        $query = "SELECT * FROM View_OIRJobRecordByID WHERE RecordID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $RecordID);
        $stmt->execute();
          
        //Loop every row from query
        while ($jobRecord=$stmt->fetch()) {
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
              <p><?php echo $jobRecord['PackagingTypeName'];?></p>
            </div>
            <!-- /.form-group -->              
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer text-right">
        <a class="btn btn-info" href="oirjob.php?RecordID=<?php echo $jobRecord['RecordID']?>" target="_blank">
          <i class="fas fa-pencil-alt">
          </i>
          Edit
        </a>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->

    <?php 
      //Query statements to select from view table
      $query1 = "SELECT * FROM View_OIRPalletRecordByID WHERE RecordID = ?";
      $stmt1 = $conn->prepare($query1);
      $stmt1->bindParam(1, $RecordID);
      $stmt1->execute();
        
      //Loop every row from query
      while ($palletRecord=$stmt1->fetch()) {

        //Include file to calculate Sample Size, Acceptance & Rejectance
        include('../includes/autocalculate.php');
    ?>

    <!-- Pallet Details -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Pallet Number <?php echo $palletRecord['PalletNumber'];?></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">

        <!-- Pallet Details -->
        <div class="info-box bg-light">
          <div class="info-box-content">
            <h4 class="pb-3">Pallet Details</h4>
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label>Checked By</label>
                  <p><?php echo $palletRecord['CheckedBy'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Size</label>
                  <p><?php echo $palletRecord['SizeCode'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Item Number</label>
                  <p><?php echo $palletRecord['ItemNumber'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Batch Size</label>
                  <p><?php echo $palletRecord['BatchSize'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Sample Size</label>
                  <p><?php echo $sample;?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Acceptance</label>
                  <p><?php echo $acc;?></p>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->

              <div class="col-md-6">
                <div class="form-group">
                  <label>Quantity Check 1</label>
                  <p><?php echo $palletRecord['QuantityCheck1'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Quantity Check 2</label>
                  <p><?php echo $palletRecord['QuantityCheck2'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Quantity Check 3</label>
                  <p><?php echo $palletRecord['QuantityCheck3'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Thickness</label>
                  <p><?php echo $palletRecord['Thickness'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Grammage</label>
                  <p><?php echo $palletRecord['GSM'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Rejectance</label>
                  <p><?php echo $rej;?></p>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              
            </div>
            <!-- /.row -->
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

        <!-- Defects -->
        <div class="info-box bg-light">
          <div class="info-box-content">
            <h4 class="pb-3">Defects</h4>
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label>Dirt/ Stain/ Printing Line</label>
                  <p><?php echo $palletRecord['Dirt/ Stain/ Printing Line'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Powder</label>
                  <p><?php echo $palletRecord['Excessive Powder'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Paper Coating</label>
                  <p><?php echo $palletRecord['Paper Coating'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Ink Smearing</label>
                  <p><?php echo $palletRecord['Ink Smearing'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Fungus</label>
                  <p><?php echo $palletRecord['Fungus'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Scratches (Printing)</label>
                  <p><?php echo $palletRecord['Scratches (Printing)'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Water Mark</label>
                  <p><?php echo $palletRecord['Water Mark'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>White Dots</label>
                  <p><?php echo $palletRecord['White Dots'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Color Variation</label>
                  <p><?php echo $palletRecord['Color Variation'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Powder Mark</label>
                  <p><?php echo $palletRecord['Powder Mark'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Discoloration</label>
                  <p><?php echo $palletRecord['Discoloration'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Misregistration</label>
                  <p><?php echo $palletRecord['Misregistration'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Total Defects</label>
                  <p><?php echo $palletRecord['TotalDefects'];?></p>
                </div>
                <!-- /.form-group -->
              </div>

              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>White Patches</label>
                  <p><?php echo $palletRecord['White Patches'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Out of Position</label>
                  <p><?php echo $palletRecord['DC Out of Position'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Over/ Not Enough Pressure</label>
                  <p><?php echo $palletRecord['DC Over/ Not Enough Pressure'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DC Crack</label>
                  <p><?php echo $palletRecord['DC Crack'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Paper Dust</label>
                  <p><?php echo $palletRecord['Excessive Paper Dust'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>No Fibre Tear/ Insufficient glue</label>
                  <p><?php echo $palletRecord['No Fibre Tear/ Insufficient glue'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Scratches (Gluing)</label>
                  <p><?php echo $palletRecord['Scratches (Gluing)'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Mixed Size/ Lot/ Flavour</label>
                  <p><?php echo $palletRecord['Mixed Size/ Lot/ Flavour'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Shortage Quantity</label>
                  <p><?php echo $palletRecord['Shortage Quantity'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Color Abrasion</label>
                  <p><?php echo $palletRecord['Color Abrasion'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Tear/ Damage</label>
                  <p><?php echo $palletRecord['Tear/ Damage'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Excessive Glue</label>
                  <p><?php echo $palletRecord['Excessive Glue'];?></p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Status</label>
                  <p><?php echo $palletRecord['Status'];?></p>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->

            </div>
            <!-- /.row -->
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

        <!-- Remark -->
        <div class="info-box bg-light">
          <div class="info-box-content">
            <h4 class="pb-3">Remark</h4>
            <div class="row">
              <div class="col-md-6">
                <p><?php echo $palletRecord['Remark'];?></p>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
         
      </div>
      <!-- /.card-body -->
      <div class="card-footer text-right">
        <a class="btn btn-info" href="oirpallet.php?RecordID=<?php echo $jobRecord['RecordID'].'&palletID='.$palletRecord['RecordPalletID'];?>" target="_blank">
          <i class="fas fa-pencil-alt">
          </i>
          Edit
        </a>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->

    <?php 
      }//Pallet Record loop
    ?>

    <!-- Verify -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Verify</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Inspection Progress</label>
              <p><?php echo $jobRecord['InspectionProgress'];?></p>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label>Overall Result</label>
              <p><?php echo $jobRecord['OverallResult'];?></p>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="form-group">
              <label>Verified By</label>
              <p><?php echo $jobRecord['VerifiedBy'];?></p>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label>Verify Date/ Time</label>
              <!-- If VerifiedBy column is Not Verified display Not Verified -->
              <!-- Else display Verify DateTime -->
              <p>
                <?php 
                  if($jobRecord['VerifyDateTime']=='Not Verified'){
                    echo $jobRecord['VerifyDateTime'];
                  }else{
                    echo date("d/m/Y h:i A", strtotime($jobRecord['VerifyDateTime']));
                  }
                ?>
              </p>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->

      <?php
            //Assign Job Number & Inspection Progress to variable
            $jobNumber = $jobRecord['JobNumber'];
            $inspectionProgress = $jobRecord['InspectionProgress'];
          }//While loop
        }else{
          
          //Close tab if user load page without MasterID parameter
          echo "<script>window.close();</script>";
        
        }
      ?>

      <!-- Form start -->
      <form method="post">

        <div class="card-footer">
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
              <!-- Print button -->
              <a class="btn btn-secondary" onClick="window.print()"><i class="fas fa-print"></i> Print</a>
              
              <!-- Verify button -->
              <button type="submit" class="btn btn-success float-right" name="verifySubmit">
                <i class="fas fa-user-check"></i> 
                Verify
              </button>
              <!-- Edit button -->
              <button type="submit" class="btn btn-warning float-right"  name="reinspectSubmit" style="margin-right: 5px;">
                <i class="fas fa-file-alt"></i> 
                Reinspect
              </button> 
            </div>
          </div>
        </div>
        <!-- /.card-footer -->

      </form>
      <!-- /.form -->
    </div>
    <!-- /.card -->
      
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

<?php
  //If user logged in as worker then hide Edit & Verify Button
  if($_SESSION['role']!='Staff'){
    echo '<script>$(".btn-info").hide()</script>';
    echo '<script>$(".btn-success").hide()</script>';
  }
?>

<?php
  include('../includes/scripts.php'); 
?>

<?php

  if(isset($_POST['reinspectSubmit'])){

    if($inspectionProgress=='Completed'){

      $query = "SELECT * FROM View_OIRJobRecordByID WHERE InspectionType = 'Reinspection' AND JobNumber = ?";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $jobNumber);
      $stmt->execute();

      //Use fetchAll() before using rowCount()
      $result = $stmt->fetchAll();
      $row = $stmt->rowCount();

      //Check if Job has been Reinspected before
      if($row==1){
        //Toast error message
        echo '<script>toastr.error("This Job has been Reinspected!");</script>';
      }else{
        //If Job is Completed & never been Reinspected, then redirect to reinspection page
        echo '<script>$(location).attr("href", "formoirreinspect.php?RecordID='.$RecordID.'")</script>';
      }

    }else{
       //Else toast error message
       echo '<script>toastr.error("This Job is not completed yet!");</script>';
    }
  }
  
  if(isset($_POST['verifySubmit'])){
    if($_SESSION['role']!='Staff'){

      //If worker click on Verify button, toast error message
      echo '<script>toastr.error("Opps, you are not allowed to Verify!");</script>';

    }elseif($_SESSION['role']=='Staff'){

      if($inspectionProgress=='Completed'){

        //Assign Verifier BadgeID from Session & Verify DateTime into SQL Server format
        $verifiedBy = $_SESSION['userID'];
        $verifyDateTime = date('Y-m-d\TH:i:s');

        //Update statements to insert Verifier BadgeID & DateTime
        $query = "{CALL SP_VerifyRecord(?, ?, ?)}";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $verifiedBy);
        $stmt->bindParam(2, $verifyDateTime);
        $stmt->bindParam(3, $RecordID);

        if($stmt->execute()){
          //If verified, toast success message
          echo '<script>toastr.success("This form is successfully Verified!");</script>';

          //Refresh page after 3 second to display Verifier BadgeID & Verify DateTime
          echo '<meta http-equiv="refresh" content="3">';
        }else{
          //Else toast error message
          echo '<script>toastr.error("There was a problem encountered while Verifying this form!");</script>';
        }

      }else{
        //Else toast error message
        echo '<script>toastr.error("This Job is not completed yet!");</script>';
      }

    }
  }

?>