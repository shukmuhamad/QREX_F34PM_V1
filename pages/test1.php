<?php
  include('../includes/header.php');
  include('../includes/session.php');
  include('../includes/database.php');
?>

<body>

    
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

    <?php
      if(isset($_GET['masterID'])){

          //Assign MasterID to variable
          $masterID = $_GET['masterID'];

          $query = "SELECT SubcontractorTypeName FROM View_IncomingRecordByID WHERE RecordID = ?";
          $stmt = $conn->prepare($query);
          $stmt->bindParam(1, $masterID);
          $stmt->execute();
          $fetchInspectionType = $stmt->fetch();

          //Check if query returns valid array(There is record in database)
          if(is_array($fetchInspectionType)){

            if($fetchInspectionType['SubcontractorTypeName']=='Finishing'){
              //If Job inspection type is Reinspection, show Edit Job Reinspection Form
              include('summary/viewfinish.php');      
        }
        elseif($fetchInspectionType['SubcontractorTypeName']=='Window Patching'){ 
            include('summary/viewpatching.php');   
    }
    elseif($fetchInspectionType['SubcontractorTypeName']=='Flute'){ 
        include('summary/viewflute.php');   
}
elseif($fetchInspectionType['SubcontractorTypeName']=='Manual Glue/Work'){ 
  include('summary/viewglue.php');   
}
elseif($fetchInspectionType['SubcontractorTypeName']=='Printing'){ 
  include('summary/viewprinting.php');   
}
    else{
      include('summary/viewdiecut.php');
    }
    }}

    ?>