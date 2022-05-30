  
  
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
                    <input type="text" name="inspectionDateTime" class="form-control" value="<?php echo date('d/m/Y h:i A');?>" readonly>
                   
                  </div>
                  <!-- /.input-group -->
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
                    <option value="<?php echo $item['ItemKey'];?>"><?php echo $item['ItemName'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Job Number</label>
                  <input type="text" name="jobNumber" class="form-control" id="jobNumber" placeholder="Job Number">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Supplier</label>
                  <select name="supplierSelect" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="">Select Supplier</option>
                    <?php 
                      //Loop every Supplier row
                      foreach ($fetchSupplier as $supplier) { 
                    ?>
                    <option value="<?php echo $supplier['SupplierKey'];?>"><?php echo $supplier['SupplierName'];}?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DO Number</label>
                  <input type="number" name="doNumber" class="form-control" id="doNumber" placeholder="DO Number" >
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Job Quantity</label>
                  <input type="number" name="jobQuantity" class="form-control" placeholder="Job Quantity (pcs)">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>DO Quantity</label>
                  <input type="number" name="doQuantity" class="form-control" placeholder="DO Quantity (pcs)">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Report Number</label>
                  <input type="text" name="reportNumber" class="form-control" id="reportNumber" data-inputmask='"mask":QAI/99/99/999"' data-mask>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>EP Code</label>
                  <input type="text" name="epCode" class="form-control" id="epCode" placeholder="EP Code">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Date Received</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>

                    <input type="date" name="receivedDate" class="form-control" id="receivedDate"> 
                    
                  </div>
                  <!-- /.input-group -->
                </div>
                <!-- /.form-group -->

                
              </div>
              <!-- /.col -->
            </div>
            <div class="card-footer">
            <center>  
              <button type="submit" name="jobSubmit"class="btn btn-primary">Save</button>
            </center>
          </div>
          <!-- /.card-footer -->
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
 