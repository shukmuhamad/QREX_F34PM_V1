<?php
  include('../includes/header.php');
  include('../includes/session.php');
  include('../includes/database.php');
?>


  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">QC Check Sheet Report</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Check Sheet Report</li>
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
  if(isset($_GET['masterID'])){

    //Assign InspectionID to variable
    $masterID = $_GET['masterID'];

    //Query statements to select from view_1
    $query = "SELECT * FROM View_CheckSheetRecordByID WHERE RecordID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $masterID);
    $stmt->execute();
      
    //Loop every row from query
    while ($row=$stmt->fetch()) {
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
                <label>Customer</label>
                <p><?php echo $row['CustomerName'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Item Name</label>
                <p><?php echo $row['ItemName'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Quantity Ordered</label>
                <p><?php echo $row['QuantityOrdered'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>OIR Number</label>
                <p><?php echo $row['OIRNumber'];?></p>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Job Number</label>
                <p><?php echo $row['JobNumber'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>EP Code</label>
                <p><?php echo $row['EPCode'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Size Ratio</label>
                <p><?php echo $row['SizeCode'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Inspection Date/ Time</label>
                <p><?php echo date('d/m/Y h:i A',strtotime($row['InspectionDateTime']));?></p>
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

      <!-- Inspection Criteria -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            Inspection Criteria Against Customer's Approved Art Work (As Per Packaging Specifications)
          </h3>
        </div>
        <div class="card-body p-0">
          <table class="table criteria">
            <thead>
              <tr>
                <th>
                  <label>
                    Criteria
                  </label>
                </th>
                <th style="width: 60%">Remarks</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <label>
                    Box Dimension
                  </label>
                  </div>
                </td>
                <td>
                  <?php echo $row['Box Dimension'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Printed Text (Top Panel)
                  </label>
                </td>
                <td>
                  <?php echo $row['Printed Text(Top Panel)'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Printed Text (Side Panel)
                  </label>
                </td>
                <td>
                  <?php echo $row['Printed Text(Side Panel)'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Printed Text (Bottom Panel)
                  </label>
                </td>
                <td>
                  <?php echo $row['Printed Text(Bottom Panel)'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Printed Color
                  </label>
                </td>
                <td>
                  <?php echo $row['Printed Color'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Varnish Area
                  </label>
                </td>
                <td>
                  <?php echo $row['Varnish Area'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Lot No. / Part No
                  </label>
                </td>
                <td>
                  <?php echo $row['Lot No. / Part No'];?>
                  
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Barcodes
                  </label>
                </td>
                <td>
                  <?php echo $row['Barcodes'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Size Ratio
                  </label>
                </td>
                <td>
                  <?php echo $row['Size Ratio'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Overall Die-Cut Design
                  </label>
                </td>
                <td>
                  <?php echo $row['Overall Die Cut Design'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Logo/ Symbol
                  </label>
                </td>
                <td>
                  <?php echo $row['Logo/Symbol'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Paper Thickness (Micron Grammage)
                  </label>
                </td>
                <td>
                  <?php echo $row['Paper Thickness (Micron Grammage)'];?>
                </td>
              </tr>
              <tr>
                <td>
                  <label>
                    Others
                  </label>
                </td>
                <td>
                  <?php echo $row['Others'];?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
        
      <!-- Verify -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Checked & Verify</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Disposition</label>
                <p><?php echo $row['Disposition'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Verified By</label>
                <p><?php echo $row['VerifiedBy'];?></p>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Checked By</label>
                <p><?php echo $row['CheckedBy'];?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Verify Date/ Time</label>
                <!-- If VerifiedBy column is Not Verified display Not Verified -->
                <!-- Else display Verify DateTime -->
                <p>
                  <?php 
                    if($row['VerifyDateTime']=='Not Verified'){
                      echo 'Not Verified';
                    }else{
                      echo date("d/m/Y h:i A", strtotime($row['VerifyDateTime']));
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
      <button type="submit" class="btn btn-info float-right"  name="editSubmit" style="margin-right: 5px;">
        <i class="fas fa-pencil-alt"></i> 
        Edit
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

  if(isset($_POST['editSubmit'])){
    if($_SESSION['role']!='Staff'){
      //If worker click on Edit button, toast error message
      echo '<script>toastr.error("Opps, you are not allowed to Edit!");</script>';
    }
    elseif($_SESSION['role']=='Staff'){
      //If staff click on Edit button, redirect to Edit Check Sheet page
      echo '<script>$(location).attr("href", "checksheet.php?masterID='.$masterID.'")</script>';
    }
  }
  
  if(isset($_POST['verifySubmit'])){
    if($_SESSION['role']!='Staff'){

      //If worker click on Verify button, toast error message
      echo '<script>toastr.error("Opps, you are not allowed to Verify!");</script>';

    }elseif($_SESSION['role']=='Staff'){

      //Assign Verifier BadgeID from Session & Verify DateTime into MYSQL Server format
      $verifiedBy = $_SESSION['userID'];
      $verifyDateTime = date('Y-m-d\TH:i:s');
      $masterID = $_GET['masterID'];

      //Update statements to insert Verifier BadgeID & DateTime
      $query = "{CALL SP_VerifyRecord(?, ?, ?)}";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $verifiedBy);
      $stmt->bindParam(2, $verifyDateTime);
      $stmt->bindParam(3, $masterID);

      if($stmt->execute()){
        //If verified, toast success message
        echo '<script>toastr.success("This form is successfully Verified!");</script>';

        //Refresh page after 3 second to display Verifier BadgeID & Verify DateTime
        echo '<meta http-equiv="refresh" content="3">';
      }else{
        //Else toast error message
        echo '<script>toastr.error("There was a problem encountered while Verifying this form!");</script>';
      }
    }
  }

?>
