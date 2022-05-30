     
     <!-- Verify Card for Incoming forms -->
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
                <label>Reject Disposition</label>
                  <select name="rejectSelect" class="form-control select2" style="width: 70%;">
                    <option selected="selected" value="2">N/A</option>
                    <option value="0">Hold for Screening</option>
                    <option value="1">Return to Sender</option>
                  </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Inspection Progress</label>
                  <select name="progressSelect" class="form-control select2" style="width: 70%;">
                    <option selected="selected" value="0">Ongoing</option>
                    <option value="1">Completed</option>
                  </select>
                </div>
                <!-- /.form-group -->
   
            
          </div>
                <div class="col-md-6">
                <div class="form-group" >
                  <label>Overall Status</label>
                  <select name="overallSelect" class="form-control select2" style="width: 70%;">
                    <option selected="selected" value="1"> Pass</option>
                    <option value="0">Fail</option>
                  </select>
                </div>
             </div>
		<div class="col-md-6">
              <div class="form-group" style="width: 70%;">
               <label> Checked By</label > 
               <input type="text" class="form-control" value="<?php echo $_SESSION['name'];?>" readonly>
                </div>
                <!-- /.form-group -->
              </div>
      
              <!-- /.col -->
            </div>
            <!-- /.row -->
         
          <div class="form-group" >
          <div class="card-footer">
            <center>  
            <button type="submit" name="finishSubmit"class="btn btn-primary">Save</button>
            </center>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
              
            