

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Outgoing Inspection Record Form</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">OIR Job Form</li>
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

      <!-- OIR Job Form -->
      <form id=jobForm action="../includes/transaction.php" method="Post">

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
                  <select name="customerSelect" class="form-control select2" style="width: 100%;">
                    <option value="">Select Customer</option>
                    <?php 
                      //Loop every Customer row
                      foreach ($fetchCustomer as $customer) { 
                    ?>
                    <option value="<?php echo $customer['CustomerKey'];?>"><?php echo $customer['CustomerName'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Item</label>
                  <select name="itemSelect" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">Select Item</option>
                    <?php 
                      //Loop every Item row
                      foreach ($fetchItem as $item) { 
                    ?>
                    <option value="<?php echo $item['ItemKey'];?>"><?php echo $item['ItemName'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Quantity per Bundle</label>
                  <input type="number" name="quantityPerBundle" class="form-control" placeholder="Quantity per Bundle (pcs)">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Quantity per Packing</label>
                  <input type="number" name="quantityPerPacking" class="form-control" placeholder="Quantity per Packing (pcs)">
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
                <div class="form-group" hidden>
                  <label>OIR Number</label>
                  <input type="text" name="oirNumber" id="oirNumber" class="form-control" data-inputmask='"mask": "OIR/99/99/"' data-mask>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Job Number</label>
                  <span id="check-jobnumber"></span>
                  <input type="text" name="jobNumber" id="jobNumber"  class="form-control" placeholder="JobNumber" onInput="checkJobNumber()" required>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>EP Code</label>
                  <input type="text" name="epCode" id="epCode" class="form-control" placeholder="EP Code">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>AQL</label>
                  <select name="aqlSelect" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">Select AQL</option>
                    <?php 
                      //Loop every AQL row
                      foreach ($fetchAQL as $aql) { 
                    ?>
                    <option value="<?php echo $aql['AQLKey'];?>"><?php echo $aql['AQLValue'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Packing Type</label>
                  <select name="packingTypeSelect" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">Select Packing Type</option>
                    <?php 
                      //Loop every Packing Type row
                      foreach ($fetchPackingType as $packingType) { 
                    ?>
                    <option value="<?php echo $packingType['PackagingTypeKey'];?>"><?php echo $packingType['PackagingTypeName'];}?></option>
                  </select>
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
                    <input type="checkbox" id="checkboxPrimary1" name="destructiveTest">
                    <label for="checkboxPrimary1">
                      Destructive Test
                    </label>
                  </div>
                </td>
                <td>
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" id="checkboxPrimary2" name="dimension">
                    <label for="checkboxPrimary2">
                      Dimension
                    </label>
                  </div>
                </td>
                <td>
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" id="checkboxPrimary3" name="barcode">
                    <label for="checkboxPrimary3">
                      Barcode
                    </label>
                  </div>
                </td>
                <td>
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" id="checkboxPrimary4" name="sticker">
                    <label for="checkboxPrimary4">
                      Sticker
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" id="checkboxPrimary5" name="lotNo">
                    <label for="checkboxPrimary5">
                      Lot No.
                    </label>
                  </div>
                </td> 
                <td>
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" id="checkboxPrimary6" name="paperGrainDirection">
                    <label for="checkboxPrimary6">
                      Paper Grain Direction
                    </label>
                  </div>
                </td>
                <td>
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" id="checkboxPrimary7" name="paperThickness">
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
              <button type="submit" name="oirSubmit"class="btn btn-primary">Save</button>
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


