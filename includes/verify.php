  <!-- Verify Card for Incoming forms -->
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
                  <label>Reject Disposition</label>
                  <select name="dispositionSelect" class="form-control select2" style="width: 100%;" id="select">
                    <option selected="selected" value="1">Return to Sender</option>
                    <option value="0">Hold for Screening</option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Checked By</label>
                  <input type="text" class="form-control" value="<?php echo $_SESSION['badgeID'];?>" readonly>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Overall Status</label>
                  <select name="overallStatus" class="form-control select2" style="width: 100%;">
                  <option selected="selected" value="1">Pass</option>
                    <option value="0">Fail</option>
                  </select>
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
              <button type="submit" name="jobSubmit"class="btn btn-primary">Save</button>
            </center>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->