<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

<script src="repeater.js" type="text/javascript"></script>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">QC Check Sheet Form</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Check Sheet Form</li>
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
    <form id="checksheetForm" action="../includes/transaction.php" method="post">

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
                <select name="customerSelect" class="form-control select2" style="width: 100%;">
                  <option selected="selected" value="">Select Customer</option>
                  <?php
                  //Loop every Customer row
                  foreach ($fetchCustomer as $customer) {
                  ?>
                    <option value="<?php echo $customer['CustomerKey']; ?>"><?php echo $customer['CustomerName'];
                                                                          } ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Item Name</label>
                <select name="itemSelect" class="form-control select2" style="width: 100%;">
                  <option selected="selected" value="">Select Item</option>
                  <?php
                  //Loop every Item row
                  foreach ($fetchItem as $item) {
                  ?>
                    <option value="<?php echo $item['ItemKey']; ?>"><?php echo $item['ItemName'];
                                                                  } ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Quantity Ordered</label>
                <input type="number" name="quantityOrder" class="form-control" placeholder="Quantity Ordered (pcs)">
              </div>
              <!-- /.form-group -->
              <div class="form-group" hidden>
                <label>OIR Number</label>
                <input type="text" name="oirNumber" class="form-control" id="oirNumber" placeholder="OIR Number" data-inputmask='"mask": "99/99/"' data-mask>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Job Number</label>
                <input type="text" name="jobNumber" class="form-control" id="jobNumber" placeholder="Job Number">
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>EP Code</label>
                <input type="text" name="epCode" class="form-control" id="epCode" placeholder="EP Code">
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>Inspection Date/ Time</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" name="inspectionDateTime" class="form-control" value="<?php echo date('d/m/Y h:i A'); ?>" readonly>
                </div>
                <!-- /.input-group -->
              </div>
              <!-- /.form-group -->


              <span id="success_result"></span>
              <div id="repeater">

                <div class="repeater-heading" align="right">
                  <button type="button" class="btn btn-primary repeater-add-btn">Add More Size</button>
                </div>
                <div class="clearfix"></div>
                <div class="items" data-group="programming_languages">
                  <div class="item-content">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-9">
                          <label>Select Size Ratio</label>
                          <select data-skip-name="true" data-name="skill[]" id="select" class="form-control select" style="width: 100%;" required>
                            <option selected="selected" value="">Select Size Ratio</option>
                            <?php
                            //Loop every Size row
                            foreach ($fetchSize as $size) {
                            ?>
                              <option value="<?php echo $size['SizeKey']; ?>"><?php echo $size['SizeCode'];
                                                                            } ?></option>
                          </select>
                        </div>
                        <div class="col-md-3" style="margin-top:24px;" align="center">
                          <button id="remove-btn" onclick="$(this).parents('.items').remove()" class="btn btn-danger">Remove</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


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
                  <input type="text" id="boxDimension" name="boxDimension" class="form-control" disabled>
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
                  <input type="text" name="topPanel" class="form-control" disabled>
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
                  <input type="text" name="sidePanel" class="form-control" disabled>
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
                  <input type="text" name="bottomPanel" class="form-control" disabled>
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
                  <input type="text" name="printedColor" class="form-control" disabled>
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
                  <input type="text" name="varnishArea" class="form-control" disabled>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" id="checkboxPrimary7" class="checkbox">
                    <label for="checkboxPrimary7">
                      Lot No. / Part No
                    </label>
                  </div>
                </td>
                <td>
                  <input type="text" name="lotPartNo" class="form-control" disabled>
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
                  <input type="text" name="barcodes" class="form-control" disabled>
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
                  <input type="text" name="sizeRatio" class="form-control" disabled>
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
                  <input type="text" name="overallDCD" class="form-control" disabled>
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
                  <input type="text" name="logoSymbol" class="form-control" disabled>
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
                  <input type="text" name="paperThickness" class="form-control" disabled>
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
                  <input type="text" name="others" class="form-control" disabled>
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
                <select name="dispositionSelect" class="form-control select2" style="width: 100%;">
                  <option selected="selected" value="1">Accept</option>
                  <option value="0">Reject</option>
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Checked By</label>
                <input type="text" name="checkedBy" class="form-control" value="<?php echo $_SESSION['name']; ?>" readonly>
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
            <button type="submit" name="csSubmit" class="btn btn-primary">Save</button>
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




<script>
  $(function() {

    $('#btnAdd').click(function() {
      var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
        newNum = new Number(num + 1), // the numeric ID of the new input field being added
        newElem = $('#testingDiv' + num).clone().attr('id', 'testingDiv' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value

      newElem.find('.test-select').attr('id', 'ID' + newNum + '_select').attr('name', 'ID' + newNum + '_select').val('');
      newElem.find('.test-textarea').val('');
      // insert the new element after the last "duplicatable" input field
      $('#testingDiv' + num).after(newElem);
      // enable the "remove" button
      $('#btnDel').attr('disabled', false);
      // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
      if (newNum == 5) $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
    });

    $('#btnDel').click(function() {
      // confirmation
      if (confirm("Are you sure you wish to remove this section of the form? Any information it contains will be lost!")) {
        var num = $('.clonedInput').length;
        // how many "duplicatable" input fields we currently have
        $('#testingDiv' + num).slideUp('slow', function() {
          $(this).remove();
          // if only one element remains, disable the "remove" button
          if (num - 1 === 1) $('#btnDel').attr('disabled', true);
          // enable the "add" button
          $('#btnAdd').attr('disabled', false).prop('value', "[ + ] add to this form");
        });
      }
      return false;
      // remove the last element

      // enable the "add" button
      $('#btnAdd').attr('disabled', false);
    });

    $('#btnDel').attr('disabled', true);

    //Enable/ disable textbox if checkbox checked & empty texboxt if checkbox unchecked
    $(".checkbox").click(function() {
      $(this).parent().parent().next().find(".form-control").prop("disabled", !$(this).prop("checked")).val("").removeClass('is-invalid')
    })

    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function() {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('input[type="checkbox"]').prop('checked', true)
        //Disable all textbox & empty all textbox & remove invalid class
        $('.criteria input[type=\'text\']').prop("disabled", false).val("").removeClass('is-invalid')
      } else {
        //Check all checkboxes
        $('input[type="checkbox"]').prop('checked', false)
        //Enable all textbox
        $('.criteria input[type=\'text\']').prop("disabled", true)
      }
      $(this).data('clicks', !clicks)
    })


    //Click Checkbox Toggle checkbox to enable all Remarks fields
    $('#checkboxToggle').click()


  })
</script>
<script>
  $(document).ready(function() {

    $('#repeater').createRepeater();



  });
</script>