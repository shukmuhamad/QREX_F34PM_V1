<?php


//Assign MasterID to variable
$masterID = $_GET['masterID'];

//Query to call sp for  Record
$query = 'SELECT * FROM View_IncomingRecordByID WHERE RecordID = ?';
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $masterID);
$stmt->execute();

$fetchCSRecord = $stmt->fetchAll();

//Assign Result for query into variable
foreach ($fetchCSRecord as $record) {
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Incoming Finishing Form</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Edit Finishing Form</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <form id="editForm" action="../includes/transaction.php?masterID=<?php echo $masterID;?>" method="post">
   
      <!-- Type of Finishing -->
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
                <select name="finishingSelect" class="form-control select2" style="width: 100%;">
                  <?php
                  //Loop every Item row
                  foreach ($fetchFinishing as $finish) {
                  ?>

                    <option value="<?php echo $finish['FinishingKey']; ?>" <?php if ($finish['FinishingName'] == $finish['FinishingName']) {
                                                                            echo 'selected';
                                                                          } ?>><?php echo $finish['FinishingName'];
                                                                                                                                                          } ?></option>
                </select>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <!-- Finished Goods Details Card for Incoming forms -->
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
                <label>Inspection Date</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" value="<?php echo date('d/m/Y h:i A', strtotime($record['InspectionDateTime'])); ?>" readonly>
                </div>
                <!-- /.input-group -->
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Item Name</label>
                <select name="itemSelect" class="form-control select2"  style="width: 100%;">
                  <option value="">Select Item</option>
                  <?php
                  //Loop every Item Name row
                  foreach ($fetchItem as $item) {
                  ?>
                    <option value="<?php echo $item['ItemKey']; ?>" <?php if ($record['ItemName'] == $item['ItemName']) {
                                                                      echo 'selected';
                                                                    } ?>><?php echo $item['ItemName'];
                                                                                                                                      } ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Job Number</label>
                <span id="check-jobnumber"></span>
                <input type="text" name="jobNumber" value="<?php echo $record['JobNumber']; ?>" class="form-control" placeholder="JobNumber" onInput="checkJobNumber()" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Supplier</label>
                <select name="supplierSelect" class="form-control select2" n style="width: 100%;">
                  <option value="">Select Supplier</option>
                  <?php
                  //Loop every Size Code row
                  foreach ($fetchSupplier as $sup) {
                  ?>
                    <option value="<?php echo $sup['Supplierkey']; ?>" <?php if ($record['SupplierName'] == $sup['SupplierName']) {
                                                                              echo 'selected';
                                                                            } ?>><?php echo $sup['SupplierName'];
                                                                                                                                                          } ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>DO Number</label>
                <input type="text" name="doNumber" value="<?php echo $record['DONumber']; ?>" class="form-control" placeholder="DONumber">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->

            <div class="col-md-6">
              <div class="form-group">
                <label>Job Quantity</label>
                <input type="text" name="jobQuantity" value="<?php echo $record['JobQuantity']; ?>" class="form-control" placeholder="Job Qauntity(pcs)">
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>DO Quantity</label>
                <input type="number" name="doQuantity" id="doQuantity" value="<?php echo $record['DOQuantity']; ?>" class="form-control" placeholder="DO Quantity (pcs)">
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Report Number</label>
                <input type="text" name="reportNumber" value="<?php echo $record['ReportNumber']; ?>" class="form-control" readonly>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>EP Code</label>
                <input type="text" name="epCode" value="<?php echo $record['EPCode']; ?>" class="form-control" placeholder="EP Code">
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label>Date Received </label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" name="receivedDate" class="form-control" id="receivedDate"  value="<?php echo date('d/m/Y ', strtotime($record['DateReceived'])); ?>" readonly>
                </div>
                <!-- /.input-group -->
              </div>
              <!-- /.form-group -->


            </div>
            <!-- /.col -->
          </div>
          <div class="card-footer">
            <center>
              <button type="submit" name="editjobSubmit" class="btn btn-primary">Update</button>
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