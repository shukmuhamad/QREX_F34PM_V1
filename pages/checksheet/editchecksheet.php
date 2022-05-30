<?php
include('../includes/database.php');

//Assign MasterID to variable
$masterID = $_GET['masterID'];

//Query to call sp for Check Sheet Record
$query = 'SELECT * FROM View_CheckSheetRecordByID WHERE RecordID= ?';
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $masterID);
$stmt->execute();

$fetchCSRecord = $stmt->fetchAll();

//Assign Result for query into variable
foreach ($fetchCSRecord as $record) {



?>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="editrepeater.js" type="text/javascript"></script>
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit QC Check Sheet Form</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Edit Check Sheet Form</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Form Start -->
      <form id="1checksheetForm" action="../includes/transaction.php?masterID=<?php echo $masterID; ?>" method="post">


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
                  <select class="form-control select2" name="customerSelect" style="width: 100%;">
                    <option value="">Select Customer</option>
                    <?php
                    //Loop every Customer Name row
                    foreach ($fetchCustomer as $customer) {
                    ?>
                      <option value="<?php echo $customer['CustomerKey']; ?>" <?php if ($record['CustomerName'] == $customer['CustomerName']) {
                                                                                echo 'selected';
                                                                              } ?>><?php echo $customer['CustomerName'];
                                                                                                                                                            } ?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Item Name</label>
                  <select class="form-control select2" name="itemSelect" style="width: 100%;">
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
                  <label>Quantity Ordered</label>
                  <input type="number" name="quantityOrder" value="<?php echo $record['QuantityOrdered']; ?>" class="form-control" placeholder="Quantity Ordered (pcs)">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>OIR Number</label>
                  <input type="text" name="oirNumber" value="<?php echo $record['OIRNumber']; ?>" class="form-control" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Job Number</label>
                  <input type="text" name="jobNumber" value="<?php echo $record['JobNumber']; ?>" class="form-control" placeholder="Job Number">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>EP Code</label>
                  <input type="text" name="epCode" value="<?php echo $record['EPCode']; ?>" class="form-control" placeholder="EP Code">
                </div>
                <!-- /.form-group -->
                <div class="form-group">

                  <label>Inspection Date/ Time</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" value="<?php echo date('d/m/Y h:i A', strtotime($record['InspectionDateTime'])); ?>" readonly>
                  </div>

                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->
                 <span id="success_result"></span>
                <div id="repeater2">

                  <div class="repeater-heading" align="right">
                    <button type="button" class="btn btn-primary repeater-add-btn">Add More Size</button>
                  </div>


                  <?php
                  //Query statements to select Pallet Details
                  $query = "SELECT * FROM View_SizeKey WHERE RecordID = ? ";
                  $stmt = $conn->prepare($query);
                  $stmt->bindParam(1, $masterID);


                  $stmt->execute();
                  //Loop every row from query
                  while ($palletRecord = $stmt->fetch()) {
                  ?>
                   
                    <div class="clearfix"></div>
                    <div class="items" data-group="programming_languages">
                      <div class="item-content">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-9">
                              <label>Select Size Ratio</label>
                              <select data-skip-name="true" data-name="skill2[]" id="select" class="form-control select" style="width: 100%;">
                                <option selected="selected" value="">Select Size Ratio</option>
                                <?php
                                //Loop every Size row
                                foreach ($fetchSize as $size) {
                                ?>
                                  <option value="<?php echo $size['SizeKey']; ?>" <?php if ($palletRecord['SizeCode'] == $size['SizeCode']) {
                                                                                    echo 'selected';
                                                                                  } ?>><?php echo $size['SizeCode'];
                                                                                                                                                          } ?>
                                  </option>

                              </select>

                            </div>

                            <div class="col-md-3" style="margin-top:24px;" align="center">
                              <button id="remove-btn" onclick="$(this).parents('.items').remove()" class="btn btn-danger">Remove</button>

                            </div>

                          </div>

                        </div>

                      </div>



                    </div>
                  <?php
                  }
                  ?>
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
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxToggle" class="checkbox-toggle">
                        <label for="checkboxToggle">
                          Criteria
                        </label>

                      </div>
                    </th>
                    <th style="width: 60%">Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary1" class="checkbox">

                        <label for="checkboxPrimary1">
                          Box Dimension
                        </label>

                      </div>

                    </td>

                    <td>
                      <input type="text" id="boxDimension" name="boxDimension" value="<?php echo $record['Box Dimension']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary2" class="checkbox">
                        <label for="checkboxPrimary2">
                          Printed Text (Top Panel)
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="topPanel" name="topPanel" value="<?php echo $record['Printed Text(Top Panel)']; ?>" class="form-control" placeholder="Any">
                    </td>

                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary3" class="checkbox">
                        <label for="checkboxPrimary3">
                          Printed Text (Side Panel)
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="sidePanel" name="sidePanel" value="<?php echo $record['Printed Text(Side Panel)']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary4" class="checkbox">
                        <label for="checkboxPrimary4">
                          Printed Text (Bottom Panel)
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="bottomPanel" name="bottomPanel" value="<?php echo $record['Printed Text(Bottom Panel)']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary5" class="checkbox">
                        <label for="checkboxPrimary5">
                          Printed Color
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="printedColor" name="printedColor" value="<?php echo $record['Printed Color']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary6" class="checkbox">
                        <label for="checkboxPrimary6">
                          Varnish Area
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="varnishArea" name="varnishArea" value="<?php echo $record['Varnish Area']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary7" class="checkbox">
                        <label for="checkboxPrimary7">
                          Lot No./ Part No
                        </label>
                      </div>
                    </td>
                    <td>

                      <input type="text" id="lotPartNo" name="lotPartNo" class="form-control defect" value="<?php echo $record['Lot No. / Part No']; ?>" placeholder="Any" />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary8" class="checkbox">
                        <label for="checkboxPrimary8">
                          Barcodes
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="barcodes" name="barcodes" value="<?php echo $record['Barcodes']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary9" class="checkbox">
                        <label for="checkboxPrimary9">
                          Size Ratio
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="sizeRatio" name="sizeRatio" value="<?php echo $record['Size Ratio']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary10" class="checkbox">
                        <label for="checkboxPrimary10">
                          Overall Die Cut Design
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="overallDCD" name="overallDCD" value="<?php echo $record['Overall Die Cut Design']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary11" class="checkbox">
                        <label for="checkboxPrimary11">
                          Logo/ Symbol
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="logoSymbol" name="logoSymbol" value="<?php echo $record['Logo/Symbol']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary12" class="checkbox">
                        <label for="checkboxPrimary12">
                          Paper Thickness (Micron Grammage)
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="paperThickness" name="paperThickness" value="<?php echo $record['Paper Thickness (Micron Grammage)']; ?>" class="form-control" placeholder="Any">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary13" class="checkbox">
                        <label for="checkboxPrimary13">
                          Others
                        </label>
                      </div>
                    </td>
                    <td>
                      <input type="text" id="others" name="others" value="<?php echo $record['Others']; ?>" class="form-control" placeholder="Any">
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
              <h3 class="card-title">Checked</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Disposition</label>
                    <select class="form-control select2" name="dispositionSelect" style="width: 100%;">
                      <option value="1" <?php if ($record['Disposition'] == 'Accept') {
                                          echo 'selected';
                                        } ?>>Accept</option>
                      <option value="0" <?php if ($record['Disposition'] == 'Reject') {
                                          echo 'selected';
                                        } ?>>Reject</option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Checked By</label>
                    <input type="text" class="form-control" value="<?php echo $record['CheckedBy'];
                                                                  } ?>" readonly>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <center>
                <button type="submit" name="csUpdate" class="btn btn-primary">Update</button>
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



  <script type="text/javascript">
    $(document).ready(function() {
      $("#boxDimension").keypress(function() {
        $("#checkboxPrimary1").prop("checked", true).val('');

      });

      $("#boxDimension").keydown(function() {
        $("#checkboxPrimary1").prop("checked", false);

      });

      $("#topPanel").keypress(function() {
        $("#checkboxPrimary2").prop("checked", true);
      });

      $("#topPanel").keydown(function() {
        $("#checkboxPrimary2").prop("checked", false);
      });

      $("#sidePanel").keypress(function() {
        $("#checkboxPrimary3").prop("checked", true);
      });

      $("#sidePanel").keydown(function() {
        $("#checkboxPrimary3").prop("checked", false);
      });

      $("#bottomPanel").keypress(function() {
        $("#checkboxPrimary4").prop("checked", true);
      });

      $("#bottomPanel").keydown(function() {
        $("#checkboxPrimary4").prop("checked", false);
      });

      $("#printedColor").keypress(function() {
        $("#checkboxPrimary5").prop("checked", true);
      });

      $("#printedColor").keydown(function() {
        $("#checkboxPrimary5").prop("checked", false);
      });

      $("#varnishArea").keypress(function() {
        $("#checkboxPrimary6").prop("checked", true);
      });

      $("#varnishArea").keydown(function() {
        $("#checkboxPrimary6").prop("checked", false);
      });

      $("#lotPartNo").keypress(function() {
        $("#checkboxPrimary7").prop("checked", true);
      });

      $("#lotPartNo").keydown(function() {
        $("#checkboxPrimary7").prop("checked", false);
      });

      $("#barcodes").keypress(function() {
        $("#checkboxPrimary8").prop("checked", true);
      });

      $("#barcodes").keydown(function() {
        $("#checkboxPrimary8").prop("checked", false);
      });

      $("#sizeRatio").keypress(function() {
        $("#checkboxPrimary9").prop("checked", true);
      });

      $("#sizeRatio").keydown(function() {
        $("#checkboxPrimary9").prop("checked", false);
      });

      $("#overallDCD").keypress(function() {
        $("#checkboxPrimary10").prop("checked", true);
      });

      $("#overallDCD").keydown(function() {
        $("#checkboxPrimary10").prop("checked", false);
      });

      $("#logoSymbol").keypress(function() {
        $("#checkboxPrimary11").prop("checked", true);
      });

      $("#logoSymbol").keydown(function() {
        $("#checkboxPrimary11").prop("checked", false);
      });

      $("#paperThickness").keypress(function() {
        $("#checkboxPrimary12").prop("checked", true);
      });

      $("#paperThickness").keydown(function() {
        $("#checkboxPrimary12").prop("checked", false);
      });

      $("#others").keypress(function() {
        $("#checkboxPrimary13").prop("checked", true);
      });

      $("#others").keydown(function() {
        $("#checkboxPrimary13").prop("checked", false);
      });

      $(".reset").click(function() {
        $("#front").prop("checked", false);
        $("#back").prop("checked", false);
      });

    });
  </script>

  </script>

  <script>
    $(document).ready(function() {

      $('#repeater2').createRepeater();



    });
  </script>