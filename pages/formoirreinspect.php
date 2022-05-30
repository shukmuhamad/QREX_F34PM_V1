<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');
?>

<?php 
  //Call sp to view  Customer, Item, InspectionSection, AQL, PackingType
  $query = "SELECT InspectionSectionKey, InspectionSectionName 
	FROM M_InspectionSection ";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  
  $fetchInspectionSection = $stmt->fetchAll();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Outgoing Inspection Record Reinspection Form</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">OIR Reinspection Form</li>
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
          if(isset($_GET['RecordID'])){

            //Assign MasterID to variable
            $RecordID = $_GET['RecordID'];

            //Query to call sp for Check Sheet Record
            $query1 = "SELECT * FROM View_OIRJobRecordByID WHERE RecordID = ?";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(1, $RecordID);
            $stmt1->execute();
            
            $fetchJobRecord = $stmt1->fetchAll();
            
            //Assign Result for query into variable
            foreach ($fetchJobRecord as $record) {}
        ?>

        <!-- Form Start -->
        <form id="reinspectionForm" action="../includes/transaction.php" method="post">

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
                  <!-- /.form-group -->
                  <div class="form-group" style="padding-top:14px;">
                    <label>Customer</label>
                    <input type="text" name="customer" value="<?php echo $record['CustomerName'];?>" class="form-control" readonly>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Item</label>
                    <input type="text" name="item" value="<?php echo $record['ItemName'];?>" class="form-control" readonly>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Quantity per Bundle</label>
                    <input type="text" name="quantityPerBundle" value="<?php echo $record['QuantityPerBundle'];?>" class="form-control" readonly>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Quantity per Packing</label>
                    <input type="text" name="quantityPerPacking" value="<?php echo $record['QuantityPerPacking'];?>" class="form-control" readonly>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Inspection Section</label>
                    <select name="inspectionSectionSelect" class="form-control select2" style="width: 100%;">
                      <option selected="selected" value="">Select Inspection Section</option>
                      <?php 
                        //Loop every InspectionSection row
                        foreach ($fetchInspectionSection as $inspectionSection) { 
                      ?>
                      <option value="<?php echo $inspectionSection['InspectionSectionKey'];?>"><?php echo $inspectionSection['InspectionSectionName'];}?></option>
                    </select>
                  </div>
                  <!-- /.form-group -->  
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Inspection Date/ Time</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" name="inspectionDateTime" class="form-control" value="<?php echo date('d/m/Y h:i A');?>" readonly>
                    </div>
                    <!-- /.input-group -->
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>OIR Number</label>
                    <input type="text" name="oirNumber" value="<?php echo $record['OIRNumber']."/A";?>" class="form-control" readonly>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Job Number</label>
                    <input type="text" name="jobNumber" value="<?php echo $record['JobNumber'];?>" class="form-control" readonly>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>EP Code</label>
                    <input type="text" name="epCode" value="<?php echo $record['EPCode'];?>" class="form-control" readonly>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>AQL</label>
                    <input type="text" name="aql" value="<?php echo $record['AQLValue'];?>" class="form-control" readonly>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Packing Type</label>
                    <input type="text" name="packingType" value="<?php echo $record['PackagingTypeName'];?>" class="form-control" readonly>
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

          <!-- Checked Criteria -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Checked Criteria</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table">
                <tr>
                  <td>
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimary1" name="destructiveTest" <?php if($record['Destructive Test']=='1'){echo 'checked';}?>>
                      <label for="checkboxPrimary1">
                        Destructive Test
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimary2" name="dimension" <?php if($record['Dimension']=='1'){echo 'checked';}?>>
                      <label for="checkboxPrimary2">
                        Dimension
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimary3" name="barcode" <?php if($record['Barcodes']=='1'){echo 'checked';}?>>
                      <label for="checkboxPrimary3">
                        Barcode
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimary4" name="sticker" <?php if($record['Sticker']=='1'){echo 'checked';}?>>
                      <label for="checkboxPrimary4">
                        Sticker
                      </label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimary5" name="lotNo" <?php if($record['Lot No. / Part No']=='1'){echo 'checked';}?>>
                      <label for="checkboxPrimary5">
                        Lot No.
                      </label>
                    </div>
                  </td> 
                  <td>
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimary6" name="paperGrainDirection" <?php if($record['Paper Grain Direction']=='1'){echo 'checked';}?>>
                      <label for="checkboxPrimary6">
                        Paper Grain Direction
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimary7" name="paperThickness" <?php if($record['Paper Thickness (Micron Grammage)']=='1'){echo 'checked';}?>>
                      <label for="checkboxPrimary7">
                        Paper Thickness
                      </label>
                    </div>
                  </td>
                  <td>
                  </td>
                </tr>        
              </table>
              <!-- /.table -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <center>  
                <button type="submit" name="reinspectionSubmit" class="btn btn-primary">Save</button>
              </center>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->

        </form>
        <!-- /.form -->

        <?php  
          }//If else statement
        ?>

      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

<?php
  include('../includes/footer.php');
  include('../includes/scripts.php'); 
?>

<script>
  $(function () {

    //On success validation insert into database
    $.validator.setDefaults({
      submitHandler: function (form) {
        $.ajax({
          type: form.attr('method'),
          url: form.attr('action'),
          data: form.serialize()
        })
      }
    })

    //Validate Reinspection Form
    $('#reinspectionForm').validate({
      rules: {
        inspectionSectionSelect: {
          required: true
        }
      },
      messages: {
        inspectionSectionSelect: {
          required: "Please select an Inspection Section."
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback')
        element.closest('.form-group').append(error)
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid')
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid')
      }
    })
  })
</script>