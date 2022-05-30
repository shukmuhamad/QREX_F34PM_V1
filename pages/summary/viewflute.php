
<body>

<!-- Content Header (Page header) -->
<div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1 class="m-0">QA Incoming Flute Form</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
           <ol class="breadcrumb float-sm-right">
           <li class="breadcrumb-item"><a href="index.php">Home</a></li>
             <li class="breadcrumb-item active"> Flute Form</li>
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

       //Query statements to select from view table
       $query = "SELECT * FROM View_IncomingRecordByID WHERE RecordID = ?";
       $stmt = $conn->prepare($query);
       $stmt->bindParam(1, $masterID);
       $stmt->execute();
         
       //Loop every row from query
       while ($jobRecord=$stmt->fetch()) {
   ?>

<div class="card card-primary">
           <div class="card-header">
             <h3 class="card-title">
               Type of Flute
             </h3>
           </div>
           <div class="card-body">
             <div class="row">
             <div class="col-md-6">
             <div class="form-group">
               <p><?php echo $jobRecord['FluteName'];?></p>
               </div>
               <!-- /.col -->
             </div>
             <!-- /.row -->
           </div>
           <!-- /.card-body -->
         </div>
         <!-- /.card -->
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
               <label>Inspection Date/ Time</label>
               <p><?php echo date('d/m/Y h:i A',strtotime($jobRecord['InspectionDateTime']));?></p>
             </div>
               <!-- /.form-group -->
               <div class="form-group">
                 <label>Item</label>
                 <p><?php echo $jobRecord['ItemName'];?></p>
               </div>
               <!-- /.form-group -->
               <div class="form-group">
                 <label>Job Number</label>
                 <p><?php echo $jobRecord['JobNumber'];?></p>
               </div>
               <!-- /.form-group -->
               <div class="form-group">
                 <label>Supplier</label>
                 <p><?php echo $jobRecord['SupplierName'];?></p>
               </div>
               <!-- /.form-group -->
               <div class="form-group">
                 <label>DO Number</label>
                 <p><?php echo $jobRecord['DONumber'];?></p>
               </div>
               <!-- /.form-group -->
               </div>
               <!--/.col -->
               <div class="col-md-6">
               <!--/.col -->
               <div class="form-group">
               <!-- /.form-group -->
               <label>Job Quantity</label>
               <p><?php echo $jobRecord['JobQuantity'];?></p>
             </div>
             <div class="form-group">
               <!-- /.form-group -->
               <label>DO Quantity</label>
               <p><?php echo $jobRecord['DOQuantity'];?></p>
             </div>
             <div class="form-group">
               <!-- /.form-group -->
               <label>Report Number</label>
               <p><?php echo $jobRecord['ReportNumber'];?></p>
             </div>
             <div class="form-group">
               <!-- /.form-group -->
               <label>EP Code</label>
               <p><?php echo $jobRecord['EPCode'];?></p>
             </div>
             <div class="form-group">
               <!-- /.form-group -->
               <label>Received Date</label>
               <p><?php echo date('d/m/Y ', strtotime($jobRecord['DateReceived']));?></p>
             </div>
              <!-- /.form-group -->
             </div>
              <!--/.col -->
              </div>
              <!--/.row -->

              </div>
              <!--/.card body -->
              </div>
              <!--/.card body -->
     <div class="card-footer text-right">
       <a class="btn btn-info" href="flute.php?masterID=<?php echo $jobRecord['RecordID']?>" target="_blank">
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
     $query1 = "SELECT * FROM View_FluteInspectRecordByID WHERE RecordID = ?";
     $stmt1 = $conn->prepare($query1);
     $stmt1->bindParam(1, $masterID);
     $stmt1->execute();
       
     //Loop every row from query
     while ($palletRecord=$stmt1->fetch()) {

       //Include file to calculate Sample Size, Acceptance & Rejectance
       include('../includes/autocalculatefinish.php');
   ?>

   <!-- Pallet Details -->
        <!-- Inspection -->
        <div class="card card-primary">
           <div class="card-header">
             <h3 class="card-title">Flute Inspection</h3>
           </div>
           <!-- /.card-header -->
     <div class="card-body">

       <!-- Pallet Details -->
     
         <div class="info-box-content">
           <h4 class="pb-3">Inspection Details</h4>
           <div class="row">

             <div class="col-md-4">
               <div class="form-group">
                 <label>Size</label>
                 <p><?php echo $palletRecord['SizeCode'];?></p>
               </div>
               <!-- /.form-group -->
               <div class="form-group">
               <label>Item No</label>
                 <p><?php echo $palletRecord['ItemNumber'];?></p>
               </div>
               <!-- /.form-group -->
               <div class="form-group">
                 <label>Sample Size</label>
                 <p><?php echo $sample;?></p>
               </div>
               <!-- /.form-group -->
         </div>
         <!-- /.col-group -->

         <div class="col-md-4">
                 <div class="form-group">
                   <label>Quantity</label>
                  <p><?php echo $palletRecord['Quantity'];?></p>
                 </div>
                 <!-- /.form-group -->
                 <div class="form-group">
                   <label>Acceptance</label>
                   <p><?php echo $acc;?></p>
                 </div>
                 <!-- /.form-group -->
               </div>
               <!-- /.col -->

               <div class="col-md-4">
               <div class="form-group">
                 <label>AQL </label>
                 <p><?php echo $palletRecord['AQLValue'];?></p>
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
              
       <!-- Defects -->
       <div class="info-box bg-light">
         <div class="info-box-content">
           <h4 class="pb-3">Inspection Details</h4>
           <div class="row">

           <div class="col-md-4">
               <div class="form-group">
               <label>Colour Variation</label>
               <p><?php echo $palletRecord['Color Variation'];?></p>
               </div>
               <div class="form-group">
               <label>Position Layout</label>
               <p><?php echo $palletRecord['Position Layout'];?></p>
               </div>
               <div class="form-group">
               <label>Mixed Size</label>
               <p><?php echo $palletRecord['Mixed Size'];?></p>
               </div>
               <div class="form-group">
               <label>Side Seam Misaligned</label>
               <p><?php echo $palletRecord['Side Seam Misaligned'];?></p>
               </div>
               <!-- /.form-group -->
               <div class="form-group">
               <label>Die-Cut Paper Facing Up/ Down</label>
               <p><?php echo $palletRecord['Die-Cut Paper Facing Up/Down'];?></p>
               </div>
               <!-- /.form-group -->
               <div class="form-group">
               <label>Barcode</label>
               <p><?php echo $palletRecord['Barcode'];?></p>
               </div>
               <!-- /.form-group -->
               <label>Total Defects</label>
               <p><?php echo $palletRecord['TotalDefects'];?></p>
               </div>
               <!-- /.form-group -->
               </div>
               <!-- /.col -->
               </div>
           <!-- /.row -->

           <div class="col-md-6">
                 <div class="form-group">
                   <label>Dirty</label>
                   <p><?php echo $palletRecord['Dirty'];?></p>
                 </div>
                 <!-- /.form-group -->
                 <div class="form-group">
                   <label>Flute Position Out</label>
                   <p><?php echo $palletRecord['Flute Position Out'];?></p>
                 </div>
                 <!-- /.form-group -->
                 <div class="form-group">
                   <label>Side Seam Not Glued/ Stapled</label>
                   <p><?php echo $palletRecord['Side Seam Not Glue/Stapled'];?></p>
                 </div>
                 <!-- /.form-group -->
                 <div class="form-group">
                   <label>Material Torn/ Damage</label>
                   <p><?php echo $palletRecord['Material Torn/Damage'];?></p>
                 </div>
                 <!-- /.form-group -->
                 <div class="form-group">
                   <label>Poor Cut-Edge</label>
                   <p><?php echo $palletRecord['Poor Cut-Edge'];?></p>
                 </div>
                 <!-- /.form-group -->
                 <div class="form-group" >
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
        
     </div>
<!-- /.card-body -->
<div class="card-footer text-right">
       <a class="btn btn-info" href="fluteInspection.php?masterID=<?php echo $jobRecord['RecordID'].'&incomingID='.$palletRecord['IncomingResultID'];?>" target="_blank">
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
<br /> 
<br /> 
<br /> 
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
             <p><?php echo $jobRecord['OverallStatus'];?></p>
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

     }else{
       //Else toast error message
       echo '<script>toastr.error("This Job is not completed yet!");</script>';
     }

   }
 }

?>