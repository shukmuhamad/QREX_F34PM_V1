<?php
  //Including database file doesn't work with this plugin
  try{
    $conn = new PDO("sqlsrv:Server= 172.16.10.61\QAPQC; Database=QAF34PM", "pqcapp", "TGQApqcQrex");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch (Exception $e){
    die(print_r( $e->getMessage()));
  }

  if(isset($_GET["jobNumber"])){

    $jobNumber = $_GET["jobNumber"];

    //Call query to check if Job Number existed
    $query = "{CALL SP_GetCheckSheetJobNumber(?)}";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $jobNumber);
    $stmt->execute();

    $row=$stmt->fetch();

    if($row["count"]!= 0){
      //If Job Number exist return false
      echo "false";
    }else{
      //Else true
      echo "true";
    }
  }
   
?>