<?php
include('database.php');

//Login page
if (isset($_POST['loginSubmit'])) {

  $badgeID = $_POST['badgeID'];
  $password = $_POST['password'];

  //Query statements
  $query = "{CALL spLoginInfo(?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $badgeID);
  $stmt->bindParam(2, $password);

  if ($stmt->execute()) {

    //$result in array of array
    $result = $stmt->fetchAll();

    //Get rowcount for query result
    $row = $stmt->rowCount();

    if ($row == 1) {
      session_start();
      //Assign user info from $result
      $_SESSION['userID'] = $result[0][0];
      $_SESSION['role'] = $result[0][1];
      $_SESSION['badgeID'] = $result[0][2];
      $_SESSION['name'] = $result[0][3];
      $_SESSION['password'] = $result[0][4];


      //If 1 row returned redirect to index.php
      header('Location: ../pages/index.php');
    } else {
      //If Badge ID and Password do not match redirect with error message
      header('Location: ../pages/login.php?action=incorrect');
    }
  } else {
    //If query fail to execute redirect with error message
    header('Location: ../pages/login.php?action=error');
  }
} //Logout
elseif (isset($_POST['logoutSubmit'])) {

  //Destroy session
  session_start();
  session_destroy();

  //Redirect to login
  header('Location: ../pages/login.php');
} //Check Sheet Form
elseif (isset($_POST['logoutSubmit'])) {

  //Destroy session
  session_start();
  session_destroy();

  //Redirect to login
  header('Location: ../pages/login.php');
} //Check Sheet Form
elseif (isset($_POST['csSubmit'])) {

  $query = "{CALL SP_View_OIR_ReportNum()}";
  $stmt = $conn->prepare($query);
  $stmt->execute();

  $fetchCheckSheet = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchOIRJob = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchIncoming = $stmt->fetchAll();

  foreach ($fetchCheckSheet as $item) {

    $datedb = $item[''];
    $tarikhdb = substr($datedb, 0, 6);
    echo $tarikhdb;
   
    $substract = substr($datedb,6);
    $mins =  $substract + 1;
   // $minus = number_format($substract+1);
   echo $mins;
  }
 


  echo "<br />";
  //Start session to access UserID
  session_start();

  // Return current date from the remote server
  $datesekarang = date('y/m/');
  echo "<br />";
  echo "<br />";
  echo $datesekarang;
  //   $now = new DateTime();
  //    $now->format('Y/m/');
  //  //echo $tesr = substr($now, 0, 6);

  echo "<br />";
  echo "<br />";

   $oirNumber = $_POST['oirNumber'];
   echo $oirNumber;
  // //separate follow on digit
  // echo "<br />";
  // echo "<br />";
  // $sub = substr($oirNumber, 0, 6);
  // echo $sub;

  $i = 1;
  if ($datesekarang == $tarikhdb) {

    //  $oirNumber = $_POST['oirNumber']. $i;
    //  echo "tak dak lagi";
    // echo $oirNumber;

    $oirNumber = $oirNumber.$mins;
    echo "dah ada tambah 1 je";

    echo $oirNumber;
  } else {

    //if ()
    // $oirNumber = $_POST['oirNumber']. $cal;
    // echo "dah ada tambah 1 je";

    //  echo $oirNumber;
    // $i = 1;
    $oirNumber = $oirNumber . 1;
    echo "tak dak lagi";
    echo $oirNumber;
   
  
  }


  $customerSelect = $_POST['customerSelect'];
  $itemSelect = $_POST['itemSelect'];
  $quantityOrder = $_POST['quantityOrder'];
 // $oirNumber = $_POST['oirNumber'];
  $jobNumber = $_POST['jobNumber'];
  $epCode = $_POST['epCode'];

  //  $sizeRatioSelect = $_POST['sizeRatioSelect'];
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));


  //Inspection Criteria Against Customer's Approved Art Work (As Per Packaging Specifications)
  $boxDimension = isset($_POST['boxDimension']) ? $_POST['boxDimension'] : NULL;
  $topPanel = isset($_POST['topPanel']) ? $_POST['topPanel'] : NULL;
  $sidePanel = isset($_POST['sidePanel']) ? $_POST['sidePanel'] : NULL;
  $bottomPanel = isset($_POST['bottomPanel']) ? $_POST['bottomPanel'] : NULL;
  $printedColor = isset($_POST['printedColor']) ? $_POST['printedColor'] : NULL;
  $varnishArea = isset($_POST['varnishArea']) ? $_POST['varnishArea'] : NULL;
  $lotPartNo = isset($_POST['lotPartNo']) ? $_POST['lotPartNo'] : NULL;
  $barcodes = isset($_POST['barcodes']) ? $_POST['barcodes'] : NULL;
  $sizeRatio = isset($_POST['sizeRatio']) ? $_POST['sizeRatio'] : NULL;
  $overallDCD = isset($_POST['overallDCD']) ? $_POST['overallDCD'] : NULL;
  $logoSymbol = isset($_POST['logoSymbol']) ? $_POST['logoSymbol'] : NULL;
  $paperThickness = isset($_POST['paperThickness']) ? $_POST['paperThickness'] : NULL;
  $others = isset($_POST['others']) ? $_POST['others'] : NULL;
  //Verify
  $dispositionSelect = $_POST['dispositionSelect'];
  $checkedBy = $_SESSION['userID'];

  //Query statements to insert Check Sheet Record
  $query = "{CALL SP_AddCheckSheetRecord(?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $epCode);
  $stmt->bindParam(4, $inspectionDateTime);
  $stmt->bindParam(5, $checkedBy);

  $stmt->bindParam(6, $customerSelect);
  $stmt->bindParam(7, $quantityOrder);
  $stmt->bindParam(8, $oirNumber);
  $stmt->bindParam(9, $dispositionSelect);
  $stmt->bindParam(10, $boxDimension);
  $stmt->bindParam(11, $topPanel);
  $stmt->bindParam(12, $sidePanel);
  $stmt->bindParam(13, $bottomPanel);
  $stmt->bindParam(14, $printedColor);
  $stmt->bindParam(15, $varnishArea);
  $stmt->bindParam(16, $lotPartNo);
  $stmt->bindParam(17, $barcodes);
  $stmt->bindParam(18, $sizeRatio);
  $stmt->bindParam(19, $overallDCD);
  $stmt->bindParam(20, $logoSymbol);
  $stmt->bindParam(21, $paperThickness);
  $stmt->bindParam(22, $others);

  if ($stmt->execute()) {

    $value = $_POST['skill'];
    foreach ($value as $value1) {

      $saja = $value1;


      $query = "{CALL SP_AddMultipleSize(?)}";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $saja);
      $stmt->execute();
    }
    echo $saja;
    //Redirect with success message
    header("Location: ../pages/checksheet.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/checksheet.php?action=error");
  }
}  //Edit Check Sheet Form
elseif (isset($_POST['csUpdate'])) {

  //Start session to access UserID
  session_start();

  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];

  //Finished Goods Details
  $customerSelect = $_POST['customerSelect'];
  $itemSelect = $_POST['itemSelect'];
  $quantityOrder = $_POST['quantityOrder'];
  $oirNumber = $_POST['oirNumber'];
  $jobNumber = $_POST['jobNumber'];
  $epCode = $_POST['epCode'];
  // $sizeRatioSelect = $_POST['sizeRatioSelect'];
  // $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/","-",$_POST['inspectionDateTime'])));

  //Inspection Criteria Against Customer's Approved Art Work (As Per Packaging Specifications)


  $boxDimension = $_POST['boxDimension'];

  if (empty($boxDimension)) {
    $boxDimension =  NULL;
  }

  $topPanel = $_POST['topPanel'];

  if (empty($topPanel)) {
    $topPanel =  NULL;
  }

  $sidePanel = $_POST['sidePanel'];

  if (empty($sidePanel)) {
    $sidePanel = NULL;
  }

  $bottomPanel = $_POST['bottomPanel'];

  if (empty($bottomPanel)) {
    $bottomPanel = NULL;
  }

  $printedColor = $_POST['printedColor'];

  if (empty($printedColor)) {
    $printedColor = NULL;
  }

  $printedColor = $_POST['printedColor'];

  if (empty($printedColor)) {
    $printedColor = NULL;
  }

  $varnishArea = $_POST['varnishArea'];

  if (empty($varnishArea)) {
    $varnishArea = NULL;
  }

  $lotPartNo = $_POST['lotPartNo'];

  if (empty($lotPartNo)) {
    $lotPartNo = NULL;
  }

  $barcodes = $_POST['barcodes'];

  if (empty($barcodes)) {
    $barcodes = NULL;
  }

  $sizeRatio = $_POST['sizeRatio'];

  if (empty($sizeRatio)) {
    $sizeRatio = NULL;
  }

  $overallDCD = $_POST['overallDCD'];

  if (empty($overallDCD)) {
    $overallDCD = NULL;
  }

  $logoSymbol = $_POST['logoSymbol'];

  if (empty($logoSymbol)) {
    $logoSymbol = NULL;
  }

  $paperThickness = $_POST['paperThickness'];

  if (empty($paperThickness)) {
    $paperThickness = NULL;
  }

  $others = $_POST['others'];

  if (empty($others)) {
    $others = NULL;
  }

  //Verify
  $dispositionSelect = $_POST['dispositionSelect'];
 // $checkedBy = $_SESSION['userID'];

  //Query statements to update Check Sheet Record
  $query = "{CALL SP_EditCheckSheetRecord(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $epCode);
  $stmt->bindParam(4, $masterID);
  $stmt->bindParam(5, $customerSelect);
  $stmt->bindParam(6, $quantityOrder);
  $stmt->bindParam(7, $oirNumber);
  $stmt->bindParam(8, $dispositionSelect);
  $stmt->bindParam(9, $boxDimension);
  $stmt->bindParam(10, $topPanel);
  $stmt->bindParam(11, $sidePanel);
  $stmt->bindParam(12, $bottomPanel);
  $stmt->bindParam(13, $printedColor);
  $stmt->bindParam(14, $varnishArea);
  $stmt->bindParam(15, $lotPartNo);
  $stmt->bindParam(16, $barcodes);
  $stmt->bindParam(17, $sizeRatio);
  $stmt->bindParam(18, $overallDCD);
  $stmt->bindParam(19, $logoSymbol);
  $stmt->bindParam(20, $paperThickness);
  $stmt->bindParam(21, $others);

 
 
  if ($stmt->execute()) {

  
    $masterID = $_GET['masterID']; 
    echo $masterID;
  echo "<br />";
      $query="{CALL SP_DeleteCheckSheetSizeRatio(?)}";
     $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $masterID);
       $stmt->execute();



   $value2 = $_POST['skill2'];
    
    foreach ($value2 as $value3) {
    
      $sampah = $value3;

      
        $query = "{CALL SP_EditMultipleSize(?,?)}";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $masterID);
     $stmt->bindParam(2, $sampah);
      $stmt->execute();
    echo $sampah;
    echo "<br />";
    }
   
    // //Redirect with success message
     header("Location: ../pages/checksheet.php?action=success");
   } 
  else {
     //Redirect with error message
    header("Location: ../pages/checksheet.php?action=error");
   }
} //Edit Check Sheet Form
//Finishing Form
elseif (isset($_POST['jobSubmit'])) {

  //session start

 // session_start();
 $query = "{CALL SP_View_OIR_ReportNum()}";
 $stmt = $conn->prepare($query);
 $stmt->execute();

 $fetchCheckSheet = $stmt->fetchAll();
 $stmt->nextRowset();
 $fetchOIRJob = $stmt->fetchAll();
 $stmt->nextRowset();
 $fetchIncoming = $stmt->fetchAll();

 foreach ($fetchIncoming as $income) {

   $datedb = $income[''];
   $tarikhdb = substr($datedb, 0, 10);
   echo $tarikhdb;
 // echo "HI";
   $substract = substr($datedb,10);
   $mins =  $substract + 1;
  // $minus = number_format($substract+1);
//  echo $mins;
 }



 echo "<br />";
 //Start session to access UserID
 session_start();

 // Return current date from the remote server
 $datesekarang = 'QAI/'.date('y/m/');

 echo "<br />";
 echo "<br />";
 echo $datesekarang;
 //   $now = new DateTime();
 //    $now->format('Y/m/');
 //  //echo $tesr = substr($now, 0, 6);

 echo "<br />";
 echo "<br />";

  $reportNumber = $_POST['reportNumber'];
  echo $reportNumber;
 // //separate follow on digit
 // echo "<br />";
 // echo "<br />";
 // $sub = substr($oirNumber, 0, 6);
 // echo $sub;

 $i = 1;
 if ($datesekarang == $tarikhdb) {

   //  $oirNumber = $_POST['oirNumber']. $i;
   //  echo "tak dak lagi";
   // echo $oirNumber;

   $reportNumber = $reportNumber.$mins;
   echo "dah ada tambah 1 je";

   echo $reportNumber;
 } else {

   //if ()
   // $oirNumber = $_POST['oirNumber']. $cal;
   // echo "dah ada tambah 1 je";

   //  echo $oirNumber;
    $i = 1;
   $reportNumber = $reportNumber . $i;
   echo "tak dak lagi";
   echo $reportNumber;
  
 
 }

  //Type of finishing

  $finishingSelect = $_POST['finishingSelect'];

  //Finised Good Details
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
 // $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];
  $sqlDate = date("Y-m-d ", strtotime($_POST['receivedDate']));
  $date_start = date('Y-m-d', strtotime($sqlDate));


  //Query statements to insert Finish Record
  $query = "{CALL SP_AddFinishingForm(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $finishingSelect);
  $stmt->bindParam(2, $inspectionDateTime);
  $stmt->bindParam(3, $itemSelect);
  $stmt->bindParam(4, $jobNumber);
  $stmt->bindParam(5, $supplierSelect);
  $stmt->bindParam(6, $doNumber);
  $stmt->bindParam(7, $jobQuantity);
  $stmt->bindParam(8, $doQuantity);
  $stmt->bindParam(9, $reportNumber);
  $stmt->bindParam(10, $epCode);
  $stmt->bindParam(11, $date_start);
 

   if ($stmt->execute()) {

     //Fetch result
    $result = $stmt->fetch();
      //Assign Master ID to variable
      $masterID = $result['masterID'];

      //Redirect to Finish Form with success message
      header("Location: ../pages/finishInspection.php?action=success&masterID=" . $masterID . "");
    } else {
      //Redirect with error message
      header("Location: ../pages/finishInspection.php?action=error");
    }
} //Edit Finishing Form
elseif (isset($_POST['editjobSubmit'])) {


  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];


  //Type of finishing

  $finishingSelect = $_POST['finishingSelect'];

  //Finished Good Details
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
  $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];

  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditFinishingForm(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $finishingSelect);
  $stmt->bindParam(2, $itemSelect);
  $stmt->bindParam(3, $jobNumber);
  $stmt->bindParam(4, $supplierSelect);
  $stmt->bindParam(5, $doNumber);
  $stmt->bindParam(6, $jobQuantity);
  $stmt->bindParam(7, $doQuantity);
  $stmt->bindParam(8, $reportNumber);
  $stmt->bindParam(9, $epCode);
  $stmt->bindParam(10, $masterID);


  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/finish.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/finish.php?action=error");
  }
}

//Edit Printing Form
elseif (isset($_POST['editprintingSubmit'])) {


  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];


  //Finished Good Details
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
  $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];

  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditPrintingForm( ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $supplierSelect);
  $stmt->bindParam(4, $doNumber);
  $stmt->bindParam(5, $jobQuantity);
  $stmt->bindParam(6, $doQuantity);
  $stmt->bindParam(7, $reportNumber);
  $stmt->bindParam(8, $epCode);
  $stmt->bindParam(9, $masterID);


  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/print.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/print.php?action=error");
  }
}
//Window Patching Form
elseif (isset($_POST['patchingSubmit'])) {

  
  //Start session to access UserID
  session_start();


  $query = "{CALL SP_View_OIR_ReportNum()}";
  $stmt = $conn->prepare($query);
  $stmt->execute();

  $fetchCheckSheet = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchOIRJob = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchIncoming = $stmt->fetchAll();

  foreach ($fetchIncoming as $income) {

    $datedb = $income[''];
    $tarikhdb = substr($datedb, 0, 10);
    echo $tarikhdb;
  // echo "HI";
    $substract = substr($datedb,10);
    $mins =  $substract + 1;
   // $minus = number_format($substract+1);
 //  echo $mins;
  }
 


  echo "<br />";
  //Start session to access UserID
  session_start();

  // Return current date from the remote server
  $datesekarang = 'QAI/'.date('y/m/');

  echo "<br />";
  echo "<br />";
  echo $datesekarang;
  //   $now = new DateTime();
  //    $now->format('Y/m/');
  //  //echo $tesr = substr($now, 0, 6);

  echo "<br />";
  echo "<br />";

   $reportNumber = $_POST['reportNumber'];
   echo $reportNumber;
  // //separate follow on digit
  // echo "<br />";
  // echo "<br />";
  // $sub = substr($oirNumber, 0, 6);
  // echo $sub;

  $i = 1;
  if ($datesekarang == $tarikhdb) {

    //  $oirNumber = $_POST['oirNumber']. $i;
    //  echo "tak dak lagi";
    // echo $oirNumber;

    $reportNumber = $reportNumber.$mins;
    echo "dah ada tambah 1 je";

    echo $reportNumber;
  } else {

    //if ()
    // $oirNumber = $_POST['oirNumber']. $cal;
    // echo "dah ada tambah 1 je";

    //  echo $oirNumber;
     $i = 1;
    $reportNumber = $reportNumber . $i;
    echo "tak dak lagi";
    echo $reportNumber;
   
  
  }

  //Finished Goods Details
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
 // $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];
  $sqlDate = date("Y-m-d ", strtotime($_POST['receivedDate']));
  $date_start = date('Y-m-d', strtotime($sqlDate));



  //Query statements to insert Finish Record
  $query = "{CALL SP_AddPatchingForm( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $epCode);
  $stmt->bindParam(4, $inspectionDateTime);
  $stmt->bindParam(5, $supplierSelect);
  $stmt->bindParam(6, $doNumber);
  $stmt->bindParam(7, $jobQuantity);
  $stmt->bindParam(8, $doQuantity);
  $stmt->bindParam(9, $reportNumber);
  $stmt->bindParam(10, $date_start);

  if ($stmt->execute()) {

    //Fetch result
    $result = $stmt->fetch();
    //Assign Master ID to variable
    $masterID = $result['masterID'];

    //Redirect to Finish Form with success message
    header("Location: ../pages/patchingInspection.php?action=success&masterID=" . $masterID . "");
  } else {
    //Redirect with error message
    header("Location: ../pages/patchingInspection.php?action=error");
  }
}

//Edit Patching Form
elseif (isset($_POST['editpatchSubmit'])) {


  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];


  //Finished Good Details
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
  $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];


echo $itemSelect;
echo $jobNumber;
echo $supplierSelect;
echo $doNumber;
echo $jobQuantity;
echo $doQuantity;
echo $reportNumber;
echo $epCode;


  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditPatchingForm(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $supplierSelect);
  $stmt->bindParam(4, $doNumber);
  $stmt->bindParam(5, $jobQuantity);
  $stmt->bindParam(6, $doQuantity);
  $stmt->bindParam(7, $reportNumber);
  $stmt->bindParam(8, $epCode);
  $stmt->bindParam(9, $masterID);


  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/patching.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/patching.php?action=error");
  }
}
//Finishing Form
elseif (isset($_POST['fluteSubmit'])) {

  //session start

  session_start();


  $query = "{CALL SP_View_OIR_ReportNum()}";
  $stmt = $conn->prepare($query);
  $stmt->execute();

  $fetchCheckSheet = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchOIRJob = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchIncoming = $stmt->fetchAll();

  foreach ($fetchIncoming as $income) {

    $datedb = $income[''];
    $tarikhdb = substr($datedb, 0, 10);
    echo $tarikhdb;
  // echo "HI";
    $substract = substr($datedb,10);
    $mins =  $substract + 1;
   // $minus = number_format($substract+1);
 //  echo $mins;
  }
 


  echo "<br />";
  //Start session to access UserID
  session_start();

  // Return current date from the remote server
  $datesekarang = 'QAI/'.date('y/m/');

  echo "<br />";
  echo "<br />";
  echo $datesekarang;
  //   $now = new DateTime();
  //    $now->format('Y/m/');
  //  //echo $tesr = substr($now, 0, 6);

  echo "<br />";
  echo "<br />";

   $reportNumber = $_POST['reportNumber'];
   echo $reportNumber;
  // //separate follow on digit
  // echo "<br />";
  // echo "<br />";
  // $sub = substr($oirNumber, 0, 6);
  // echo $sub;

  $i = 1;
  if ($datesekarang == $tarikhdb) {

    //  $oirNumber = $_POST['oirNumber']. $i;
    //  echo "tak dak lagi";
    // echo $oirNumber;

    $reportNumber = $reportNumber.$mins;
    echo "dah ada tambah 1 je";

    echo $reportNumber;
  } else {

    //if ()
    // $oirNumber = $_POST['oirNumber']. $cal;
    // echo "dah ada tambah 1 je";

    //  echo $oirNumber;
     $i = 1;
    $reportNumber = $reportNumber . $i;
    echo "tak dak lagi";
    echo $reportNumber;
   
  
  }


  //Type of flute

  $flutetype = $_POST['flutetype'];

  //Finised Good Details
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
 // $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];
  $sqlDate = date("Y-m-d ", strtotime($_POST['receivedDate']));
  $date_start = date('Y-m-d', strtotime($sqlDate));

  //Query statements to insert Flute Record
  $query = "{CALL SP_AddFluteForm( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $flutetype);
  $stmt->bindParam(2, $inspectionDateTime);
  $stmt->bindParam(3, $itemSelect);
  $stmt->bindParam(4, $jobNumber);
  $stmt->bindParam(5, $supplierSelect);
  $stmt->bindParam(6, $doNumber);
  $stmt->bindParam(7, $jobQuantity);
  $stmt->bindParam(8, $doQuantity);
  $stmt->bindParam(9, $reportNumber);
  $stmt->bindParam(10, $epCode);
  $stmt->bindParam(11, $date_start);

  if ($stmt->execute()) {

    //Fetch result
    $result = $stmt->fetch();
    //Assign Master ID to variable
    $masterID = $result['masterID'];

    //Redirect to Finish Form with success message
    header("Location: ../pages/fluteInspection.php?action=success&masterID=" . $masterID . "");
  } else {
    //Redirect with error message
    header("Location: ../pages/fluteInspection.php?action=error");
  }
}
//Edit Flute Form
elseif (isset($_POST['editfluteSubmit'])) {


  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];


  //Type of finishing

  $flutetype = $_POST['flutetype'];

  //Finished Good Details
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
  $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];

  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditFluteForm(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $flutetype);
  $stmt->bindParam(2, $itemSelect);
  $stmt->bindParam(3, $jobNumber);
  $stmt->bindParam(4, $supplierSelect);
  $stmt->bindParam(5, $doNumber);
  $stmt->bindParam(6, $jobQuantity);
  $stmt->bindParam(7, $doQuantity);
  $stmt->bindParam(8, $reportNumber);
  $stmt->bindParam(9, $epCode);
  $stmt->bindParam(10, $masterID);


  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/flute.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/flute.php?action=error");
  }
}

//OIR Job Form
elseif (isset($_POST['oirSubmit'])) {

  $query = "{CALL SP_View_OIR_ReportNum()}";
  $stmt = $conn->prepare($query);
  $stmt->execute();

  $fetchCheckSheet = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchOIRJob = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchIncoming = $stmt->fetchAll();

  foreach ($fetchOIRJob as $item) {

    $datedb = $item[''];
    $tarikhdb = substr($datedb, 0, 10);
    echo $tarikhdb;
  // echo "HI";
    $substract = substr($datedb,10);
    $mins =  $substract + 1;
   // $minus = number_format($substract+1);
 //  echo $mins;
  }
 


  echo "<br />";
  //Start session to access UserID
  session_start();

  // Return current date from the remote server
  $datesekarang = 'OIR/'.date('y/m/');

  echo "<br />";
  echo "<br />";
  echo $datesekarang;
  //   $now = new DateTime();
  //    $now->format('Y/m/');
  //  //echo $tesr = substr($now, 0, 6);

  echo "<br />";
  echo "<br />";

   $oirNumber = $_POST['oirNumber'];
   echo $oirNumber;
  // //separate follow on digit
  // echo "<br />";
  // echo "<br />";
  // $sub = substr($oirNumber, 0, 6);
  // echo $sub;

  $i = 1;
  if ($datesekarang == $tarikhdb) {

    //  $oirNumber = $_POST['oirNumber']. $i;
    //  echo "tak dak lagi";
    // echo $oirNumber;

    $oirNumber = $oirNumber.$mins;
    echo "dah ada tambah 1 je";

    echo $oirNumber;
  } else {

    //if ()
    // $oirNumber = $_POST['oirNumber']. $cal;
    // echo "dah ada tambah 1 je";

    //  echo $oirNumber;
     $i = 1;
    $oirNumber = $oirNumber . $i;
    echo "tak dak lagi";
    echo $oirNumber;
   
  
  }

  //Job Details
  $customerSelect = $_POST['customerSelect'];
  $itemSelect = $_POST['itemSelect'];
  $quantityPerBundle = $_POST['quantityPerBundle'];
  $quantityPerPacking = $_POST['quantityPerPacking'];
  $inspectionSectionSelect = $_POST['inspectionSectionSelect'];
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));
 // $oirNumber = $_POST['oirNumber'];
  $jobNumber = $_POST['jobNumber'];
  $epCode = $_POST['epCode'];
  $aqlSelect = $_POST['aqlSelect'];
  $packingTypeSelect = $_POST['packingTypeSelect'];

  //Checked Criteria
  $destructiveTest = isset($_POST['destructiveTest']) ? 1 : 0;
  $dimension = isset($_POST['dimension']) ? 1 : 0;
  $barcode = isset($_POST['barcode']) ? 1 : 0;
  $sticker = isset($_POST['sticker']) ? 1 : 0;
  $lotNo = isset($_POST['lotNo']) ? 1 : 0;
  $paperGrainDirection = isset($_POST['paperGrainDirection']) ? 1 : 0;
  $paperThickness = isset($_POST['paperThickness']) ? 1 : 0;

  //Query statements to add OIR Job Record
  $query = "{CALL SP_AddOIRJobRecord(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $epCode);
  $stmt->bindParam(4, $inspectionDateTime);
  $stmt->bindParam(5, $customerSelect);
  $stmt->bindParam(6, $aqlSelect);
  $stmt->bindParam(7, $inspectionSectionSelect);
  $stmt->bindParam(8, $packingTypeSelect);
  $stmt->bindParam(9, $oirNumber);
  $stmt->bindParam(10, $quantityPerBundle);
  $stmt->bindParam(11, $quantityPerPacking);
  $stmt->bindParam(12, $destructiveTest);
  $stmt->bindParam(13, $dimension);
  $stmt->bindParam(14, $barcode);
  $stmt->bindParam(15, $sticker);
  $stmt->bindParam(16, $lotNo);
  $stmt->bindParam(17, $paperGrainDirection);
  $stmt->bindParam(18, $paperThickness);

  if ($stmt->execute()) {

    //Fetch result
    $result = $stmt->fetch();
    //Assign Master ID to variable
    $RecordID = $result['masterID'];

    //Redirect to Pallet Form with success message
    header("Location: ../pages/oirpallet.php?action=success&RecordID=" . $RecordID . "");
  } else {
    //Redirect with error message
    header("Location: ../pages/oirpallet.php?action=error");
  }
} //Edit OIR Job Form
elseif (isset($_POST['jobUpdate'])) {

  //Get MasterID from url parameter
  $RecordID = $_GET['RecordID'];

  //Job Details
  $customerSelect = $_POST['customerSelect'];
  $itemSelect = $_POST['itemSelect'];
  $quantityPerBundle = $_POST['quantityPerBundle'];
  $quantityPerPacking = $_POST['quantityPerPacking'];
  $inspectionSectionSelect = $_POST['inspectionSectionSelect'];
  $oirNumber = $_POST['oirNumber'];
  $jobNumber = $_POST['jobNumber'];
  $epCode = $_POST['epCode'];
  $aqlSelect = $_POST['aqlSelect'];
  $packingTypeSelect = $_POST['packingTypeSelect'];
  $progressSelect = $_POST['progressSelect'];

  //Checked Criteria
  $destructiveTest = isset($_POST['destructiveTest']) ? 1 : 0;
  $dimension = isset($_POST['dimension']) ? 1 : 0;
  $barcode = isset($_POST['barcode']) ? 1 : 0;
  $sticker = isset($_POST['sticker']) ? 1 : 0;
  $lotNo = isset($_POST['lotNo']) ? 1 : 0;
  $paperGrainDirection = isset($_POST['paperGrainDirection']) ? 1 : 0;
  $paperThickness = isset($_POST['paperThickness']) ? 1 : 0;

  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditOIRJobRecord(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $epCode);
  $stmt->bindParam(4, $RecordID);
  $stmt->bindParam(5, $customerSelect);
  $stmt->bindParam(6, $aqlSelect);
  $stmt->bindParam(7, $inspectionSectionSelect);
  $stmt->bindParam(8, $packingTypeSelect);
  $stmt->bindParam(9, $oirNumber);
  $stmt->bindParam(10, $quantityPerBundle);
  $stmt->bindParam(11, $quantityPerPacking);
  $stmt->bindParam(12, $progressSelect);
  $stmt->bindParam(13, $destructiveTest);
  $stmt->bindParam(14, $dimension);
  $stmt->bindParam(15, $barcode);
  $stmt->bindParam(16, $sticker);
  $stmt->bindParam(17, $lotNo);
  $stmt->bindParam(18, $paperGrainDirection);
  $stmt->bindParam(19, $paperThickness);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/oirjob.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/oirjob.php?action=error");
  }
} //OIR Reinspection Form
elseif (isset($_POST['reinspectionSubmit'])) {

  //Job Details
  $customer = $_POST['customer'];
  $item = $_POST['item'];
  $quantityPerBundle = $_POST['quantityPerBundle'];
  $quantityPerPacking = $_POST['quantityPerPacking'];
  $inspectionSectionSelect = $_POST['inspectionSectionSelect'];
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));
  $oirNumber = $_POST['oirNumber'];
  $jobNumber = $_POST['jobNumber'];
  $epCode = $_POST['epCode'];
  $aql = $_POST['aql'];
  $packingType = $_POST['packingType'];

  //Checked Criteria
  $destructiveTest = isset($_POST['destructiveTest']) ? 1 : 0;
  $dimension = isset($_POST['dimension']) ? 1 : 0;
  $barcode = isset($_POST['barcode']) ? 1 : 0;
  $sticker = isset($_POST['sticker']) ? 1 : 0;
  $lotNo = isset($_POST['lotNo']) ? 1 : 0;
  $paperGrainDirection = isset($_POST['paperGrainDirection']) ? 1 : 0;
  $paperThickness = isset($_POST['paperThickness']) ? 1 : 0;

  //Query statements to add OIR Job Record
  $query = "{CALL SP_AddOIRReinspectionRecord(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $item);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $epCode);
  $stmt->bindParam(4, $inspectionDateTime);
  $stmt->bindParam(5, $customer);
  $stmt->bindParam(6, $aql);
  $stmt->bindParam(7, $inspectionSectionSelect);
  $stmt->bindParam(8, $packingType);
  $stmt->bindParam(9, $oirNumber);
  $stmt->bindParam(10, $quantityPerBundle);
  $stmt->bindParam(11, $quantityPerPacking);
  $stmt->bindParam(12, $destructiveTest);
  $stmt->bindParam(13, $dimension);
  $stmt->bindParam(14, $barcode);
  $stmt->bindParam(15, $sticker);
  $stmt->bindParam(16, $lotNo);
  $stmt->bindParam(17, $paperGrainDirection);
  $stmt->bindParam(18, $paperThickness);

  if ($stmt->execute()) {

    //Fetch result
    $result = $stmt->fetch();
    //Assign Master ID to variable
    $RecordID = $result['masterID'];

    //Redirect to Pallet Form with success message
    header("Location: ../pages/oirpallet.php?action=success&RecordID=" . $RecordID . "");
  } else {
    //Redirect with error message
    header("Location: ../pages/oirjob.php?action=error");
  }
} //Edit OIR Reinspection Form
elseif (isset($_POST['reinspectionUpdate'])) {

  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];

  //Job Details
  $inspectionSectionSelect = $_POST['inspectionSectionSelect'];
  $progressSelect = $_POST['progressSelect'];

  //Query statements to edit OIR Job Reinspection Record
  $query = "{CALL SP_EditOIRReinspectionRecord(?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $inspectionSectionSelect);
  $stmt->bindParam(3, $progressSelect);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/oirjob.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/oirjob.php?action=error");
  }
} //QA Incming Job Number Form
elseif (isset($_POST['incomingSubmit'])) {

  $jobNumber = $_POST['jobNumber'];

  //If just Job Number is inputted

  //Query statements to check Job Record
  $query = "SELECT * FROM View_IncomingRecordByID WHERE JobNumber = ? AND SubcontractorTypeName= 'Finishing' AND InspectionProgress = 'Incomplete'";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $jobNumber);


  if ($stmt->execute()) {

    //$results in array of array
    $result = $stmt->fetchAll();

    //Get rowcount for query result
    $row = $stmt->rowCount();

    if ($row == 1) {
      //Assign MasterID to variable
      $masterID = $result[0][0];

      //Redirect to Pallet Form with parameters
      header("Location: ../pages/finishInspection.php?masterID=" . $masterID . "");
    } else {
      header("Location: ../pages/finishInspection.php?action=invalid");
    }
  } else {
    //Redirect with error message
    header("Location: ../pages/finishInspection.php?action=error");
  }
}

//QA Incming Job Number Form
elseif (isset($_POST['windowpatchingSubmit'])) {

  $jobNumber = $_POST['jobNumber'];

  //If just Job Number is inputted

  //Query statements to check Job Record
  $query = "SELECT * FROM View_IncomingRecordByID WHERE JobNumber = ? AND SubcontractorTypeName= 'Window Patching'  AND InspectionProgress = 'Incomplete'";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $jobNumber);


  if ($stmt->execute()) {

    //$results in array of array
    $result = $stmt->fetchAll();

    //Get rowcount for query result
    $row = $stmt->rowCount();

    if ($row == 1) {
      //Assign MasterID to variable
      $masterID = $result[0][0];

      //Redirect to Pallet Form with parameters
      header("Location: ../pages/patchingInspection.php?masterID=" . $masterID . "");
    } else {
      header("Location: ../pages/patchingInspection.php?action=invalid");
    }
  } else {
    //Redirect with error message
    header("Location: ../pages/patchingInspection.php?action=error");
  }
}

//QA Incming Flute Job Number Form
elseif (isset($_POST['jobfluteSubmit'])) {

  $jobNumber = $_POST['jobNumber'];

  //If just Job Number is inputted

  //Query statements to check Job Record
  $query = "SELECT * FROM View_IncomingRecordByID WHERE JobNumber = ? AND SubcontractorTypeName = 'Flute' AND InspectionProgress = 'Incomplete' ";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $jobNumber);


  if ($stmt->execute()) {

    //$results in array of array
    $result = $stmt->fetchAll();

    //Get rowcount for query result
    $row = $stmt->rowCount();

    if ($row == 1) {
      //Assign MasterID to variable
      $masterID = $result[0][0];

      //Redirect to Pallet Form with parameters
      header("Location: ../pages/fluteInspection.php?masterID=" . $masterID . "");
    } else {
      header("Location: ../pages/fluteInspection.php?action=invalid");
    }
  } else {
    //Redirect with error message
    header("Location: ../pages/fluteInspection.php?action=error");
  }
}

//QA Incming Job Number Form
elseif (isset($_POST['manualnumberSubmit'])) {

  $jobNumber = $_POST['jobNumber'];

  //If just Job Number is inputted

  //Query statements to check Job Record
  $query = "SELECT * FROM View_IncomingRecordByID WHERE JobNumber = ? AND SubcontractorTypeName='Manual Glue/Work' AND InspectionProgress = 'Incomplete'";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $jobNumber);


  if ($stmt->execute()) {

    //$results in array of array
    $result = $stmt->fetchAll();

    //Get rowcount for query result
    $row = $stmt->rowCount();

    if ($row == 1) {
      //Assign MasterID to variable
      $masterID = $result[0][0];

      //Redirect to Pallet Form with parameters
      header("Location: ../pages/manualInspection.php?masterID=" . $masterID . "");
    } else {
      header("Location: ../pages/manualInspection.php?action=invalid");
    }
  } else {
    //Redirect with error message
    header("Location: ../pages/manualInspection.php?action=error");
  }
}

//QA Incming Printing Job Number Form
elseif (isset($_POST['printingnumberSubmit'])) {

  $jobNumber = $_POST['jobNumber'];

  //If just Job Number is inputted

  //Query statements to check Job Record
  $query = "SELECT * FROM View_IncomingRecordByID WHERE JobNumber = ? AND SubcontractorTypeName='Printing' AND InspectionProgress = 'Incomplete'";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $jobNumber);


  if ($stmt->execute()) {

    //$results in array of array
    $result = $stmt->fetchAll();

    //Get rowcount for query result
    $row = $stmt->rowCount();

    if ($row == 1) {
      //Assign MasterID to variable
      $masterID = $result[0][0];

      //Redirect to Pallet Form with parameters
      header("Location: ../pages/printInspection.php?masterID=" . $masterID . "");
    } else {
      header("Location: ../pages/printInspection.php?action=invalid");
    }
  } else {
    //Redirect with error message
    header("Location: ../pages/printInspection.php?action=error");
  }
}

//QA Incming Die Cut Job Number Form
elseif (isset($_POST['jobdieSubmit'])) {

  $jobNumber = $_POST['jobNumber'];

  //If just Job Number is inputted

  //Query statements to check Job Record
  $query = "SELECT * FROM View_IncomingRecordByID WHERE JobNumber = ? AND SubcontractorTypeName='Die Cut' AND InspectionProgress = 'Incomplete'";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $jobNumber);


  if ($stmt->execute()) {

    //$results in array of array
    $result = $stmt->fetchAll();

    //Get rowcount for query result
    $row = $stmt->rowCount();

    if ($row == 1) {
      //Assign MasterID to variable
      $masterID = $result[0][0];

      //Redirect to Pallet Form with parameters
      header("Location: ../pages/dieInspection.php?masterID=" . $masterID . "");
    } else {
      header("Location: ../pages/dieInspection.php?action=invalid");
    }
  } else {
    //Redirect with error message
    header("Location: ../pages/dieInspection.php?action=error");
  }
}


//Finish Inspection Form
elseif (isset($_POST['finishSubmit'])) {

  //Start session to access UserID
  session_start();

  //Get Master ID from URL parameter
  $masterID = $_GET['masterID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $sizeNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];
  //Defects
  $positionRegistry = $_POST['positionRegistry'];

  if (empty($positionRegistry)) {
    $positionRegistry = 0;
  }
  $finishEffect = $_POST['finishEffect'];
  if (empty($finishEffect)) {
    $finishEffect = 0;
  }

  $dirty = $_POST['dirty'];
  if (empty($dirty)) {
    $dirty = 0;
  }
  $sideLay = $_POST['sideLay'];
  if (empty($sideLay)) {
    $sideLay = 0;
  }
  $damage = $_POST['damage'];
  if (empty($damage)) {
    $damage = 0;
  }
  $sticking = $_POST['sticking'];
  if (empty($sticking)) {
    $sticking = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }


  //Verify

  $dispositionSelect = $_POST['rejectSelect'];
  $checkedBy = $_SESSION['userID'];

  //Query statements to add Finishing Record
  $query = "{CALL SP_AddFinishInspection(? ,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  // $query = "{CALL test2(? ,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $checkedBy);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $sizeNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $positionRegistry);
  $stmt->bindParam(12, $finishEffect);
  $stmt->bindParam(13, $dirty);
  $stmt->bindParam(14, $sideLay);
  $stmt->bindParam(15, $damage);
  $stmt->bindParam(16, $sticking);
  $stmt->bindParam(17, $mixed);

  if ($stmt->execute()) {
    if ($progressSelect == '0') {
      //  Redirect to Pallet Form with success message
      header("Location: ../pages/finishInspection.php?action=success&masterID=" . $masterID . "");
    } else {
      //    Redirect to Job Form with success message
      header("Location: ../pages/finish.php?action=success");
    }
  } else {
    //edirect with error message
    header("Location: ../pages/finishInspection.php?action=error&masterID=" . $masterID . "");
  }
}

//Edit Finishing Inspection Form
elseif (isset($_POST['editfinishUpdate'])) {

  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];
  $incomingID = $_GET['incomingID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $itemNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];


  //Defects
  $positionRegistry = $_POST['positionRegistry'];

  if (empty($positionRegistry)) {
    $positionRegistry = 0;
  }
  $finishEffect = $_POST['finishEffect'];
  if (empty($finishEffect)) {
    $finishEffect = 0;
  }

  $dirty = $_POST['dirty'];
  if (empty($dirty)) {
    $dirty = 0;
  }
  $sideLay = $_POST['sideLay'];
  if (empty($sideLay)) {
    $sideLay = 0;
  }
  $damage = $_POST['damage'];
  if (empty($damage)) {
    $damage = 0;
  }
  $sticking = $_POST['sticking'];
  if (empty($sticking)) {
    $sticking = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }

  //Verify

  $dispositionSelect = $_POST['rejectSelect'];


  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditFinishingInspect(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);


  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $incomingID);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $itemNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $positionRegistry);
  $stmt->bindParam(12, $finishEffect);
  $stmt->bindParam(13, $dirty);
  $stmt->bindParam(14, $sideLay);
  $stmt->bindParam(15, $damage);
  $stmt->bindParam(16, $sticking);
  $stmt->bindParam(17, $mixed);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/finishInspection.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/finishInspection.php?action=error");
  }
}
//Patching Inspection Form
elseif (isset($_POST['patchSubmit'])) {

  //Start session to access UserID
  session_start();

  //Get Master ID from URL parameter
  $masterID = $_GET['masterID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $sizeNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];
  //Defects
  $oppPosition = $_POST['oppPosition'];

  if (empty($oppPosition)) {
    $oppPosition = 0;
  }
  $scratchMarks = $_POST['scratchMarks'];
  if (empty($scratchMarks)) {
    $scratchMarks = 0;
  }

  $oppFilm = $_POST['oppFilm'];
  if (empty($oppFilm)) {
    $oppFilm = 0;
  }
  $materialTorn = $_POST['materialTorn'];
  if (empty($materialTorn)) {
    $materialTorn = 0;
  }
  $oppOff = $_POST['oppOff'];
  if (empty($oppOff)) {
    $oppOff = 0;
  }
  $missingOPP = $_POST['missingOPP'];
  if (empty($missingOPP)) {
    $missingOPP = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }


  //Verify

  $dispositionSelect = $_POST['rejectSelect'];
  $checkedBy = $_SESSION['userID'];

  //Query statements to add Finishing Record
  $query = "{CALL SP_AddPatchInspectionForm(? ,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $checkedBy);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $sizeNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $oppPosition);
  $stmt->bindParam(12, $scratchMarks);
  $stmt->bindParam(13, $oppFilm);
  $stmt->bindParam(14, $materialTorn);
  $stmt->bindParam(15, $oppOff);
  $stmt->bindParam(16, $missingOPP);
  $stmt->bindParam(17, $mixed);

  if ($stmt->execute()) {
    if ($progressSelect == '0') {
      //  Redirect to Pallet Form with success message
      header("Location: ../pages/patchingInspection.php?action=success&masterID=" . $masterID . "");
    } else {
      //    Redirect to Job Form with success message
      header("Location: ../pages/patching.php?action=success");
    }
  } else {
    //edirect with error message
    header("Location: ../pages/patchingInspection.php?action=error&masterID=" . $masterID . "");
  }
}

//Edit Patching Inspection Form
elseif (isset($_POST['editpatchingUpdate'])) {

  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];
  $incomingID = $_GET['incomingID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $itemNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];
  //Defects
  $oppPosition = $_POST['oppPosition'];

  if (empty($oppPosition)) {
    $oppPosition = 0;
  }
  $scratchMarks = $_POST['scratchMarks'];
  if (empty($scratchMarks)) {
    $scratchMarks = 0;
  }

  $oppFilm = $_POST['oppFilm'];
  if (empty($oppFilm)) {
    $oppFilm = 0;
  }
  $materialTorn = $_POST['materialTorn'];
  if (empty($materialTorn)) {
    $materialTorn = 0;
  }
  $oppOff = $_POST['oppOff'];
  if (empty($oppOff)) {
    $oppOff = 0;
  }
  $missingOPP = $_POST['missingOPP'];
  if (empty($missingOPP)) {
    $missingOPP = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }


  //Verify

  $dispositionSelect = $_POST['rejectSelect'];


  //Query statements to add Finishing Record
  $query = "{CALL SP_EditPatchInspection(? ,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $incomingID);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $itemNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $oppPosition);
  $stmt->bindParam(12, $scratchMarks);
  $stmt->bindParam(13, $oppFilm);
  $stmt->bindParam(14, $materialTorn);
  $stmt->bindParam(15, $oppOff);
  $stmt->bindParam(16, $missingOPP);
  $stmt->bindParam(17, $mixed);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/patchingInspection.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/patchingInspection.php?action=error");
  }
}


//Flute Inspection Form
elseif (isset($_POST['fluteInspectionSubmit'])) {

  //Start session to access UserID
  session_start();

  //Get Master ID from URL parameter
  $masterID = $_GET['masterID'];

  //Inspection Section Flute Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $itemNo = $_POST['itemNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];

  //Defects
  $colorVar = $_POST['colorVar'];

  if (empty($colorVar)) {
    $colorVar = 0;
  }
  $postLay = $_POST['postLay'];
  if (empty($postLay)) {
    $postLay = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }
  $sideSeam = $_POST['sideSeam'];
  if (empty($sideSeam)) {
    $sideSeam = 0;
  }
  $dieCut = $_POST['dieCut'];
  if (empty($dieCut)) {
    $dieCut = 0;
  }
  $barcode = $_POST['barcode'];
  if (empty($barcode)) {
    $barcode = 0;
  }


  $dirty = $_POST['dirty'];
  if (empty($dirty)) {
    $dirty = 0;
  }
  $flutepost = $_POST['flutepost'];
  if (empty($flutepost)) {
    $flutepost = 0;
  }
  $sideGlued = $_POST['sideGlued'];
  if (empty($sideGlued)) {
    $sideGlued = 0;
  }
  $matThorn = $_POST['matThorn'];
  if (empty($matThorn)) {
    $matThorn = 0;
  }
  $poorCut = $_POST['poorCut'];
  if (empty($poorCut)) {
    $poorCut = 0;
  }



  //Verify

  $dispositionSelect = $_POST['rejectSelect'];
  $checkedBy = $_SESSION['userID'];

  //Query statements to add Finishing Record
  $query = "{CALL SP_AddFluteInspection(? ,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $checkedBy);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $itemNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $colorVar);
  $stmt->bindParam(12, $postLay);
  $stmt->bindParam(13, $mixed);
  $stmt->bindParam(14, $sideSeam);
  $stmt->bindParam(15, $dieCut);
  $stmt->bindParam(16, $barcode);
  $stmt->bindParam(17, $dirty);
  $stmt->bindParam(18, $flutepost);
  $stmt->bindParam(19, $sideGlued);
  $stmt->bindParam(20, $matThorn);
  $stmt->bindParam(21, $poorCut);

  if ($stmt->execute()) {
    if ($progressSelect == '0') {
      //  Redirect to Pallet Form with success message
      header("Location: ../pages/fluteInspection.php?action=success&masterID=" . $masterID . "");
    } else {
      //    Redirect to Job Form with success message
      header("Location: ../pages/flute.php?action=success");
    }
  } else {
    //edirect with error message
    header("Location: ../pages/fluteInspection.php?action=error&masterID=" . $masterID . "");
  }
}

//Edit Flute Inspection Form
elseif (isset($_POST['editfluteUpdate'])) {

  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];
  $incomingID = $_GET['incomingID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $itemNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];


  //Defects
  $colorVar = $_POST['colorVar'];

  if (empty($colorVar)) {
    $colorVar = 0;
  }
  $postLay = $_POST['postLay'];
  if (empty($postLay)) {
    $postLay = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }
  $sideSeam = $_POST['sideSeam'];
  if (empty($sideSeam)) {
    $sideSeam = 0;
  }
  $dieCut = $_POST['dieCut'];
  if (empty($dieCut)) {
    $dieCut = 0;
  }
  $barcode = $_POST['barcode'];
  if (empty($barcode)) {
    $barcode = 0;
  }
  $dirty = $_POST['dirty'];
  if (empty($dirty)) {
    $dirty = 0;
  }
  $flutepost = $_POST['flutepost'];
  if (empty($flutepost)) {
    $flutepost = 0;
  }
  $sideGlued = $_POST['sideGlued'];
  if (empty($sideGlued)) {
    $sideGlued = 0;
  }
  $matThorn = $_POST['matThorn'];
  if (empty($matThorn)) {
    $matThorn = 0;
  }
  $poorCut = $_POST['poorCut'];
  if (empty($poorCut)) {
    $poorCut = 0;
  }


  //Verify

  $dispositionSelect = $_POST['rejectSelect'];


  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditFluteInspection(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)}";
  $stmt = $conn->prepare($query);


  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $incomingID);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $itemNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  //Defects
  $stmt->bindParam(11, $colorVar);
  $stmt->bindParam(12, $postLay);
  $stmt->bindParam(13, $mixed);
  $stmt->bindParam(14, $sideSeam);
  $stmt->bindParam(15, $dieCut);
  $stmt->bindParam(16, $barcode);
  $stmt->bindParam(17, $dirty);
  $stmt->bindParam(18, $flutepost);
  $stmt->bindParam(19, $sideGlued);
  $stmt->bindParam(20, $matThorn);
  $stmt->bindParam(21, $poorCut);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/fluteInspection.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/fluteInspection.php?action=error");
  }
}

// Glue Form
elseif (isset($_POST['glueSubmit'])) {

  //Start session to access UserID
  session_start();

  $query = "{CALL SP_View_OIR_ReportNum()}";
  $stmt = $conn->prepare($query);
  $stmt->execute();

  $fetchCheckSheet = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchOIRJob = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchIncoming = $stmt->fetchAll();

  foreach ($fetchIncoming as $income) {

    $datedb = $income[''];
    $tarikhdb = substr($datedb, 0, 10);
    echo $tarikhdb;
  // echo "HI";
    $substract = substr($datedb,10);
    $mins =  $substract + 1;
   // $minus = number_format($substract+1);
 //  echo $mins;
  }
 


  echo "<br />";
  //Start session to access UserID
  session_start();

  // Return current date from the remote server
  $datesekarang = 'QAI/'.date('y/m/');

  echo "<br />";
  echo "<br />";
  echo $datesekarang;
  //   $now = new DateTime();
  //    $now->format('Y/m/');
  //  //echo $tesr = substr($now, 0, 6);

  echo "<br />";
  echo "<br />";

   $reportNumber = $_POST['reportNumber'];
   echo $reportNumber;
  // //separate follow on digit
  // echo "<br />";
  // echo "<br />";
  // $sub = substr($oirNumber, 0, 6);
  // echo $sub;

  $i = 1;
  if ($datesekarang == $tarikhdb) {

    //  $oirNumber = $_POST['oirNumber']. $i;
    //  echo "tak dak lagi";
    // echo $oirNumber;

    $reportNumber = $reportNumber.$mins;
    echo "dah ada tambah 1 je";

    echo $reportNumber;
  } else {

    //if ()
    // $oirNumber = $_POST['oirNumber']. $cal;
    // echo "dah ada tambah 1 je";

    //  echo $oirNumber;
     $i = 1;
    $reportNumber = $reportNumber . $i;
    echo "tak dak lagi";
    echo $reportNumber;
   
  
  }



  //Finished Goods Details
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
 // $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];
  $sqlDate = date("Y-m-d ", strtotime($_POST['receivedDate']));
  $date_start = date('Y-m-d', strtotime($sqlDate));



  //Query statements to insert Finish Record
  $query = "{CALL SP_AddGlueForm( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $epCode);
  $stmt->bindParam(4, $inspectionDateTime);
  $stmt->bindParam(5, $supplierSelect);
  $stmt->bindParam(6, $doNumber);
  $stmt->bindParam(7, $jobQuantity);
  $stmt->bindParam(8, $doQuantity);
  $stmt->bindParam(9, $reportNumber);
  $stmt->bindParam(10, $date_start);

  if ($stmt->execute()) {

    //Fetch result
    $result = $stmt->fetch();
    //Assign Master ID to variable
    $masterID = $result['masterID'];

    //Redirect to Finish Form with success message
    header("Location: ../pages/manualInspection.php?action=success&masterID=" . $masterID . "");
  } else {
    //Redirect with error message
    header("Location: ../pages/manualInspection.php?action=error");
  }
}

//Glue Inspection Form
elseif (isset($_POST['glueInspectSubmit'])) {

  //Start session to access UserID
  session_start();

  //Get Master ID from URL parameter
  $masterID = $_GET['masterID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $sizeNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];
  //Defects
  $stickPosition = $_POST['stickPosition'];

  if (empty($stickPosition)) {
    $stickPosition = 0;
  }
  $sideSeam = $_POST['sideSeam'];
  if (empty($sideSeam)) {
    $sideSeam = 0;
  }

  $exGlue = $_POST['exGlue'];
  if (empty($exGlue)) {
    $exGlue = 0;
  }
  $sideStap = $_POST['sideStap'];
  if (empty($sideStap)) {
    $sideStap = 0;
  }
  $matDamn = $_POST['matDamn'];
  if (empty($matDamn)) {
    $matDamn = 0;
  }
  $noStri = $_POST['noStri'];
  if (empty($noStri)) {
    $noStri = 0;
  }


  //Verify

  $dispositionSelect = $_POST['rejectSelect'];
  $checkedBy = $_SESSION['userID'];

  //Query statements to add Finishing Record
  $query = "{CALL SP_AddGlueInspection(? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $checkedBy);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $sizeNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $stickPosition);
  $stmt->bindParam(12, $sideSeam);
  $stmt->bindParam(13, $exGlue);
  $stmt->bindParam(14, $sideStap);
  $stmt->bindParam(15, $matDamn);
  $stmt->bindParam(16, $noStri);


  if ($stmt->execute()) {
    if ($progressSelect == '0') {
      //  Redirect to Pallet Form with success message
      header("Location: ../pages/manualInspection.php?action=success&masterID=" . $masterID . "");
    } else {
      //    Redirect to Job Form with success message
      header("Location: ../pages/manualglue.php?action=success");
    }
  } else {
    //edirect with error message
    header("Location: ../pages/manualInspection.php?action=error&masterID=" . $masterID . "");
  }
}

//Edit Glue Form

elseif (isset($_POST['editglueSubmit'])) {


  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];


  //Finished Good Details
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
  $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];


  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditGlueForm(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);


  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $supplierSelect);
  $stmt->bindParam(4, $doNumber);
  $stmt->bindParam(5, $jobQuantity);
  $stmt->bindParam(6, $doQuantity);
  $stmt->bindParam(7, $reportNumber);
  $stmt->bindParam(8, $epCode);
  $stmt->bindParam(9, $masterID);


  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/manualglue.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/manualglue.php?action=error");
  }
}


//Edit Glue Inspection
elseif (isset($_POST['editglueUpdate'])) {

  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];
  $incomingID = $_GET['incomingID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $itemNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];

  //Defects
  $stickPosition = $_POST['stickPosition'];

  if (empty($stickPosition)) {
    $stickPosition = 0;
  }
  $sideSeam = $_POST['sideSeam'];
  if (empty($sideSeam)) {
    $sideSeam = 0;
  }

  $exGlue = $_POST['exGlue'];
  if (empty($exGlue)) {
    $exGlue = 0;
  }
  $sideStap = $_POST['sideStap'];
  if (empty($sideStap)) {
    $sideStap = 0;
  }
  $matDamn = $_POST['matDamn'];
  if (empty($matDamn)) {
    $matDamn = 0;
  }
  $noStri = $_POST['noStri'];
  if (empty($noStri)) {
    $noStri = 0;
  }

  //Verify

  $dispositionSelect = $_POST['rejectSelect'];


  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditGlueInspection(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);


  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $incomingID);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $itemNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);


  //Defects
  $stmt->bindParam(11, $stickPosition);
  $stmt->bindParam(12, $sideSeam);
  $stmt->bindParam(13, $exGlue);
  $stmt->bindParam(14, $sideStap);
  $stmt->bindParam(15, $matDamn);
  $stmt->bindParam(16, $noStri);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/manualInspection.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/manualInspection.php?action=error");
  }
}

//Print Form
elseif (isset($_POST['printSubmit'])) {

  //session start

  session_start();

  $query = "{CALL SP_View_OIR_ReportNum()}";
  $stmt = $conn->prepare($query);
  $stmt->execute();

  $fetchCheckSheet = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchOIRJob = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchIncoming = $stmt->fetchAll();

  foreach ($fetchIncoming as $income) {

    $datedb = $income[''];
    $tarikhdb = substr($datedb, 0, 10);
    echo $tarikhdb;
  // echo "HI";
    $substract = substr($datedb,10);
    $mins =  $substract + 1;
   // $minus = number_format($substract+1);
 //  echo $mins;
  }
 


  echo "<br />";
  //Start session to access UserID
  session_start();

  // Return current date from the remote server
  $datesekarang = 'QAI/'.date('y/m/');

  echo "<br />";
  echo "<br />";
  echo $datesekarang;
  //   $now = new DateTime();
  //    $now->format('Y/m/');
  //  //echo $tesr = substr($now, 0, 6);

  echo "<br />";
  echo "<br />";

   $reportNumber = $_POST['reportNumber'];
   echo $reportNumber;
  // //separate follow on digit
  // echo "<br />";
  // echo "<br />";
  // $sub = substr($oirNumber, 0, 6);
  // echo $sub;

  $i = 1;
  if ($datesekarang == $tarikhdb) {

    //  $oirNumber = $_POST['oirNumber']. $i;
    //  echo "tak dak lagi";
    // echo $oirNumber;

    $reportNumber = $reportNumber.$mins;
    echo "dah ada tambah 1 je";

    echo $reportNumber;
  } else {

    //if ()
    // $oirNumber = $_POST['oirNumber']. $cal;
    // echo "dah ada tambah 1 je";

    //  echo $oirNumber;
     $i = 1;
    $reportNumber = $reportNumber . $i;
    echo "tak dak lagi";
    echo $reportNumber;
   
  
  }



  //Finised Good Details
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
 // $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];
  $sqlDate = date("Y-m-d ", strtotime($_POST['receivedDate']));
  $date_start = date('Y-m-d', strtotime($sqlDate));

//   echo $inspectionDateTime;
// echo $itemSelect;
// echo $jobNumber;
// echo $supplierSelect;
// echo $doNumber;
// echo $jobQuantity;
// echo $doQuantity;
// echo $reportNumber;
// echo $epCode;
// echo $date_start;
  //Query statements to insert Finish Record
  $query = "{CALL SP_AddPrintingForm( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $inspectionDateTime);

  $stmt->bindParam(4, $supplierSelect);
  $stmt->bindParam(5, $doNumber);
  $stmt->bindParam(6, $jobQuantity);
  $stmt->bindParam(7, $doQuantity);
  $stmt->bindParam(8, $reportNumber);
  $stmt->bindParam(9, $epCode);
  $stmt->bindParam(10, $date_start);

  if ($stmt->execute()) {

    //Fetch result
    $result = $stmt->fetch();
    //Assign Master ID to variable
    $masterID = $result['masterID'];

    //Redirect to Finish Form with success message
    header("Location: ../pages/printInspection.php?action=success&masterID=" . $masterID . "");
  } else {
    //Redirect with error message
    header("Location: ../pages/printInspection.php?action=error");
  }
}
//Printing Inspection Form
elseif (isset($_POST['printInspectSubmit'])) {

  //Start session to access UserID
  session_start();

  //Get Master ID from URL parameter
  $masterID = $_GET['masterID'];

  //Inspection Section Printing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $sizeNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];
  //Defects
  $postLay = $_POST['postLay'];

  if (empty($postLay)) {
    $postLay = 0;
  }
  $rest = $_POST['rest'];
  if (empty($rest)) {
    $rest = 0;
  }

  $stick = $_POST['stick'];
  if (empty($stick)) {
    $stick = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }
  $spotVar = $_POST['spotVar'];
  if (empty($spotVar)) {
    $spotVar = 0;
  }
  $incomp = $_POST['incomp'];
  if (empty($incomp)) {
    $incomp = 0;
  }
  $verify = $_POST['verify'];
  if (empty($verify)) {
    $verify = 0;
  }
  $colorVar = $_POST['colorVar'];
  if (empty($colorVar)) {
    $colorVar = 0;
  }
  $dirt = $_POST['dirt'];
  if (empty($dirt)) {
    $dirt = 0;
  }
  $bar = $_POST['bar'];
  if (empty($bar)) {
    $bar = 0;
  }
  $lot = $_POST['lot'];
  if (empty($lot)) {
    $lot = 0;
  }
  $doub = $_POST['doub'];
  if (empty($doub)) {
    $doub = 0;
  }
  $water = $_POST['water'];
  if (empty($water)) {
    $water = 0;
  }

  //Verify

  $dispositionSelect = $_POST['rejectSelect'];
  $checkedBy = $_SESSION['userID'];

  //Query statements to add Finishing Record
  $query = "{CALL SP_AddPrintInspection(? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $checkedBy);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $sizeNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $postLay);
  $stmt->bindParam(12, $rest);
  $stmt->bindParam(13, $stick);
  $stmt->bindParam(14, $mixed);
  $stmt->bindParam(15, $spotVar);
  $stmt->bindParam(16, $incomp);
  $stmt->bindParam(17, $verify);
  $stmt->bindParam(18, $colorVar);
  $stmt->bindParam(19, $dirt);
  $stmt->bindParam(20, $bar);
  $stmt->bindParam(21, $lot);
  $stmt->bindParam(22, $doub);
  $stmt->bindParam(23, $water);

  if ($stmt->execute()) {
    if ($progressSelect == '0') {
      //  Redirect to Pallet Form with success message
      header("Location: ../pages/printInspection.php?action=success&masterID=" . $masterID . "");
    } else {
      //    Redirect to Job Form with success message
      header("Location: ../pages/print.php?action=success");
    }
  } else {
    //edirect with error message
    header("Location: ../pages/printInspection.php?action=error&masterID=" . $masterID . "");
  }
}


// Edit Print Form
elseif (isset($_POST['editprintSubmit'])) {


  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];

  //Finished Good Details
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
  $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];

  //Query statements to insert Finish Record
  $query = "{CALL SP_EditPrintingForm( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);


  $stmt->bindParam(3, $supplierSelect);
  $stmt->bindParam(4, $doNumber);
  $stmt->bindParam(5, $jobQuantity);
  $stmt->bindParam(6, $doQuantity);
  $stmt->bindParam(7, $reportNumber);
  $stmt->bindParam(8, $epCode);
  $stmt->bindParam(9, $date_start);
  $stmt->bindParam(10, $masterID);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/print.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/print.php?action=error");
  }
}

//Edit Printing Inspection Form
elseif (isset($_POST['editprintInspectSubmit'])) {



  //Get Master ID from URL parameter
  $masterID = $_GET['masterID'];
  $incomingID = $_GET['incomingID'];

  //Inspection Section Printing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $sizeNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];
  //Defects
  $postLay = $_POST['postLay'];

  if (empty($postLay)) {
    $postLay = 0;
  }
  $rest = $_POST['rest'];
  if (empty($rest)) {
    $rest = 0;
  }

  $stick = $_POST['stick'];
  if (empty($stick)) {
    $stick = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }
  $spotVar = $_POST['spotVar'];
  if (empty($spotVar)) {
    $spotVar = 0;
  }
  $incomp = $_POST['incomp'];
  if (empty($incomp)) {
    $incomp = 0;
  }
  $verify = $_POST['verify'];
  if (empty($verify)) {
    $verify = 0;
  }
  $colorVar = $_POST['colorVar'];
  if (empty($colorVar)) {
    $colorVar = 0;
  }
  $dirt = $_POST['dirt'];
  if (empty($dirt)) {
    $dirt = 0;
  }
  $bar = $_POST['bar'];
  if (empty($bar)) {
    $bar = 0;
  }
  $lot = $_POST['lot'];
  if (empty($lot)) {
    $lot = 0;
  }
  $doub = $_POST['doub'];
  if (empty($doub)) {
    $doub = 0;
  }
  $water = $_POST['water'];
  if (empty($water)) {
    $water = 0;
  }

  //Verify

  $dispositionSelect = $_POST['rejectSelect'];


  //Query statements to add Finishing Record
  $query = "{CALL SP_EditPrintInspection(? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $incomingID);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $sizeNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $postLay);
  $stmt->bindParam(12, $rest);
  $stmt->bindParam(13, $stick);
  $stmt->bindParam(14, $mixed);
  $stmt->bindParam(15, $spotVar);
  $stmt->bindParam(16, $incomp);
  $stmt->bindParam(17, $verify);
  $stmt->bindParam(18, $colorVar);
  $stmt->bindParam(19, $dirt);
  $stmt->bindParam(20, $bar);
  $stmt->bindParam(21, $lot);
  $stmt->bindParam(22, $doub);
  $stmt->bindParam(23, $water);


  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/printInspection.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/printInspection.php?action=error");
  }
}

//Edit Flute Inspection Form
elseif (isset($_POST['editfluteUpdate'])) {

  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];
  $incomingID = $_GET['incomingID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $itemNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];
  //Defects
  $postLay = $_POST['postLay'];

  if (empty($postLay)) {
    $postLay = 0;
  }
  $rest = $_POST['rest'];
  if (empty($rest)) {
    $rest = 0;
  }

  $stick = $_POST['stick'];
  if (empty($stick)) {
    $stick = 0;
  }
  $mixed = $_POST['mixed'];
  if (empty($mixed)) {
    $mixed = 0;
  }
  $spotVar = $_POST['spotVar'];
  if (empty($spotVar)) {
    $spotVar = 0;
  }
  $incomp = $_POST['incomp'];
  if (empty($incomp)) {
    $incomp = 0;
  }
  $verify = $_POST['verify'];
  if (empty($verify)) {
    $verify = 0;
  }
  $colorVar = $_POST['colorVar'];
  if (empty($colorVar)) {
    $colorVar = 0;
  }
  $dirt = $_POST['dirt'];
  if (empty($dirt)) {
    $dirt = 0;
  }
  $bar = $_POST['bar'];
  if (empty($bar)) {
    $bar = 0;
  }
  $lot = $_POST['lot'];
  if (empty($lot)) {
    $lot = 0;
  }
  $doub = $_POST['doub'];
  if (empty($doub)) {
    $doub = 0;
  }
  $water = $_POST['water'];
  if (empty($water)) {
    $water = 0;
  }
  //Verify

  $dispositionSelect = $_POST['rejectSelect'];

  //Query statements to add Finishing Record
  $query = 'CALL SP_EditPrintInspection(?,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?)';
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $incomingID);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $itemNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  $stmt->bindParam(11, $postLay);
  $stmt->bindParam(12, $rest);
  $stmt->bindParam(13, $stick);
  $stmt->bindParam(14, $mixed);
  $stmt->bindParam(15, $spotVar);
  $stmt->bindParam(16, $incomp);
  $stmt->bindParam(17, $verify);
  $stmt->bindParam(18, $colorVar);
  $stmt->bindParam(19, $dirt);
  $stmt->bindParam(20, $bar);
  $stmt->bindParam(21, $lot);
  $stmt->bindParam(22, $doub);
  $stmt->bindParam(23, $water);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/printInspection.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/printInspection.php?action=error");
  }
}

// Die Cut Form
elseif (isset($_POST['dieSubmit'])) {

  //Start session to access UserID
  session_start();


  $query = "{CALL SP_View_OIR_ReportNum()}";
  $stmt = $conn->prepare($query);
  $stmt->execute();

  $fetchCheckSheet = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchOIRJob = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchIncoming = $stmt->fetchAll();

  foreach ($fetchIncoming as $income) {

    $datedb = $income[''];
    $tarikhdb = substr($datedb, 0, 10);
    echo $tarikhdb;
  // echo "HI";
    $substract = substr($datedb,10);
    $mins =  $substract + 1;
   // $minus = number_format($substract+1);
 //  echo $mins;
  }
 


  echo "<br />";
  //Start session to access UserID
  session_start();

  // Return current date from the remote server
  $datesekarang = 'QAI/'.date('y/m/');

  echo "<br />";
  echo "<br />";
  echo $datesekarang;
  //   $now = new DateTime();
  //    $now->format('Y/m/');
  //  //echo $tesr = substr($now, 0, 6);

  echo "<br />";
  echo "<br />";

   $reportNumber = $_POST['reportNumber'];
   echo $reportNumber;
  // //separate follow on digit
  // echo "<br />";
  // echo "<br />";
  // $sub = substr($oirNumber, 0, 6);
  // echo $sub;

  $i = 1;
  if ($datesekarang == $tarikhdb) {

    //  $oirNumber = $_POST['oirNumber']. $i;
    //  echo "tak dak lagi";
    // echo $oirNumber;

    $reportNumber = $reportNumber.$mins;
    echo "dah ada tambah 1 je";

    echo $reportNumber;
  } else {

    //if ()
    // $oirNumber = $_POST['oirNumber']. $cal;
    // echo "dah ada tambah 1 je";

    //  echo $oirNumber;
     $i = 1;
    $reportNumber = $reportNumber . $i;
    echo "tak dak lagi";
    echo $reportNumber;
   
  
  }


  //Finished Goods Details
  $inspectionDateTime = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $_POST['inspectionDateTime'])));
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
  //$reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];
  $sqlDate = date("Y-m-d ", strtotime($_POST['receivedDate']));
  $date_start = date('Y-m-d', strtotime($sqlDate));



  //Query statements to insert Finish Record
  $query = "{CALL SP_AddDieForm( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $epCode);
  $stmt->bindParam(4, $inspectionDateTime);
  $stmt->bindParam(5, $supplierSelect);
  $stmt->bindParam(6, $doNumber);
  $stmt->bindParam(7, $jobQuantity);
  $stmt->bindParam(8, $doQuantity);
  $stmt->bindParam(9, $reportNumber);
  $stmt->bindParam(10, $date_start);

  if ($stmt->execute()) {

    //Fetch result
    $result = $stmt->fetch();
    //Assign Master ID to variable
    $masterID = $result['masterID'];

    //Redirect to Finish Form with success message
    header("Location: ../pages/dieInspection.php?action=success&masterID=" . $masterID . "");
  } else {
    //Redirect with error message
    header("Location: ../pages/dieInspection.php?action=error");
  }
}
//Die Cut Inspection Form
elseif (isset($_POST['dieInspectSubmit'])) {

  //Start session to access UserID
  session_start();

  //Get Master ID from URL parameter
  $masterID = $_GET['masterID'];

  //Inspection Section Printing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $sizeNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];
  //Defects
  $postLay = $_POST['post'];

  if (empty($postLay)) {
    $postLay = 0;
  }
  $score = $_POST['score'];
  if (empty($score)) {
    $score = 0;
  }

  $window = $_POST['window'];
  if (empty($window)) {
    $window = 0;
  }
  $die = $_POST['die'];
  if (empty($die)) {
    $die = 0;
  }
  $half = $_POST['half'];
  if (empty($half)) {
    $half = 0;
  }
  $cut = $_POST['cut'];
  if (empty($cut)) {
    $cut = 0;
  }
  $cutting = $_POST['cutting'];
  if (empty($cutting)) {
    $cutting = 0;
  }
  $paper = $_POST['paper'];
  if (empty($paper)) {
    $paper = 0;
  }


  //Verify

  $dispositionSelect = $_POST['rejectSelect'];
  $checkedBy = $_SESSION['userID'];

  //Query statements to add Finishing Record
  $query = "{CALL SP_AddDieInspection(?,?,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $checkedBy);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $sizeNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $postLay);
  $stmt->bindParam(12, $score);
  $stmt->bindParam(13, $window);
  $stmt->bindParam(14, $die);
  $stmt->bindParam(15, $cut);
  $stmt->bindParam(16, $half);
  $stmt->bindParam(17, $cutting);
  $stmt->bindParam(18, $paper);


  if ($stmt->execute()) {
    if ($progressSelect == '0') {
      //  Redirect to Pallet Form with success message
      header("Location: ../pages/dieInspection.php?action=success&masterID=" . $masterID . "");
    } else {
      //    Redirect to Job Form with success message
      header("Location: ../pages/diecut.php?action=success");
    }
  } else {
    //edirect with error message
    header("Location: ../pages/dieInspection.php?action=error&masterID=" . $masterID . "");
  }
}

//Edit Die Cut Form
elseif (isset($_POST['editdieSubmit'])) {


  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];


  //Finished Good Details
  $itemSelect = $_POST['itemSelect'];
  $jobNumber = $_POST['jobNumber'];
  $supplierSelect = $_POST['supplierSelect'];
  $doNumber = $_POST['doNumber'];
  $jobQuantity = $_POST['jobQuantity'];
  $doQuantity = $_POST['doQuantity'];
  $reportNumber = $_POST['reportNumber'];
  $epCode = $_POST['epCode'];

  //Query statements to add OIR Job Record
  $query = "{CALL SP_EditDieForm(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $itemSelect);
  $stmt->bindParam(2, $jobNumber);
  $stmt->bindParam(3, $supplierSelect);
  $stmt->bindParam(4, $doNumber);
  $stmt->bindParam(5, $jobQuantity);
  $stmt->bindParam(6, $doQuantity);
  $stmt->bindParam(7, $reportNumber);
  $stmt->bindParam(8, $epCode);
  $stmt->bindParam(9, $masterID);


  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/diecut.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/diecut.php?action=error");
  }
}

//Edit Die Cut Inspection Form
elseif (isset($_POST['editdieUpdate'])) {

  //Get MasterID from url parameter
  $masterID = $_GET['masterID'];
  $incomingID = $_GET['incomingID'];

  //Inspection Section Finishing Form
  $sizeSelect = $_POST['sizeRatioSelect'];
  $itemNo = $_POST['sizeNo'];
  $quantity = $_POST['qty'];
  $aqlSelect = $_POST['aqlSelect'];
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $overallSelect = $_POST['overallSelect'];

  //Defects
  $post = $_POST['post'];

  if (empty($post)) {
    $post = 0;
  }
  $score = $_POST['score'];
  if (empty($score)) {
    $score = 0;
  }

  $window = $_POST['window'];
  if (empty($window)) {
    $window = 0;
  }
  $die = $_POST['die'];
  if (empty($die)) {
    $die = 0;
  }
  $cut = $_POST['cut'];
  if (empty($cut)) {
    $cut = 0;
  }
  $cutting = $_POST['cutting'];
  if (empty($cutting)) {
    $cutting = 0;
  }
  $paper = $_POST['paper'];
  if (empty($paper)) {
    $paper = 0;
  }
  $half = $_POST['half'];
  if (empty($half)) {
    $half = 0;
  }
  //Verify

  $dispositionSelect = $_POST['rejectSelect'];
 
  // echo $sizeSelect;
  // echo $itemNo;
  // echo $quantity;
  // echo $aqlSelect;
  // echo $status;
  // echo $progressSelect;
  // echo $overallSelect;

  //Query statements to add Finishing Record
  $query = "{CALL SP_EditDieInspection(?,?,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $masterID);
  $stmt->bindParam(2, $incomingID);
  $stmt->bindParam(3, $dispositionSelect);
  $stmt->bindParam(4, $progressSelect);
  $stmt->bindParam(5, $overallSelect);
  $stmt->bindParam(6, $sizeSelect);
  $stmt->bindParam(7, $itemNo);
  $stmt->bindParam(8, $aqlSelect);
  $stmt->bindParam(9, $quantity);
  $stmt->bindParam(10, $status);

  //Defects
  $stmt->bindParam(11, $post);
  $stmt->bindParam(12, $score);
  $stmt->bindParam(13, $window);
  $stmt->bindParam(14, $die);
  $stmt->bindParam(15, $cut);
  $stmt->bindParam(16, $half);
  $stmt->bindParam(17, $cutting);
  $stmt->bindParam(18, $paper);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/dieInspection.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/dieInspection.php?action=error");
  }
}


//OIR Initial Form
elseif (isset($_POST['initialSubmit'])) {

  $jobNumber = $_POST['jobNumber'];
  //If OIR Number is not empty
  // if ($_POST['oirNumber'] != 'OIR/__/__/___/_') {

  //   $oirNumber = $_POST['oirNumber'];

  //   //Query statements to check Job Record
  //   $query = "SELECT RecordID FROM View_OIRJobRecordByID WHERE JobNumber = ? AND OIRNumber = ? AND InspectionType = 'Reinspection' AND InspectionProgress = 'Incomplete'";
  //   $stmt = $conn->prepare($query);
  //   $stmt->bindParam(1, $jobNumber);
  //   $stmt->bindParam(2, $oirNumber);
  // } //If just Job Number is inputted
  // else {

    //Query statements to check Job Record
    $query = "SELECT RecordID FROM View_OIRJobRecordByID WHERE JobNumber = ? AND InspectionType = 'New Inspection' AND InspectionProgress = 'Incomplete'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $jobNumber);
  //}

  if ($stmt->execute()) {

    //$results in array of array
    $result = $stmt->fetchAll();

    //Get rowcount for query result
    $row = $stmt->rowCount();

    if ($row == 1) {
      //Assign MasterID to variable
      $RecordID = $result[0][0];

      //Redirect to Pallet Form with parameters
      header("Location: ../pages/oirpallet.php?RecordID=" . $RecordID . "");
    } else {
      header("Location: ../pages/oirpallet.php?action=invalid");
    }
  } else {
    //Redirect with error message
    header("Location: ../pages/oirpallet.php?action=error");
  }
} //OIR Pallet Form

elseif (isset($_POST['palletSubmit'])) {

  //Start session to access UserID
  session_start();

  //Get Master ID from URL parameter
  $RecordID = $_GET['RecordID'];

  //Pallet Details
  $palletNumber = $_POST['palletNumber'];
  $sizeSelect = $_POST['sizeSelect'];
  $itemNumber = $_POST['itemNumber'];
  $batchSize = $_POST['batchSize'];
  $quantityCheck1 = $_POST['quantityCheck1'];
  $quantityCheck2 = $_POST['quantityCheck2'];
  $quantityCheck3 = $_POST['quantityCheck3'];
  $thickness = $_POST['thickness'];
  $grammage = $_POST['grammage'];

  //Defects
  $dirtSPL = $_POST['dirtSPL'];

  if (empty($dirtSPL)) {
    $dirtSPL = 0;
  }
  $excessivePowder = $_POST['excessivePowder'];
  if (empty($excessivePowder)) {
    $excessivePowder = 0;
  }
  $paperCoating = $_POST['paperCoating'];
  if (empty($paperCoating)) {
    $paperCoating = 0;
  }
  $inkSmearing = $_POST['inkSmearing'];
  if (empty($inkSmearing)) {
    $inkSmearing = 0;
  }
  $fungus = $_POST['fungus'];
  if (empty($fungus)) {
    $fungus = 0;
  }
  $scrathesPrinting = $_POST['scrathesPrinting'];
  if (empty($scrathesPrinting)) {
    $scrathesPrinting = 0;
  }
  $waterMark = $_POST['waterMark'];
  if (empty($waterMark)) {
    $waterMark = 0;
  }
  $whiteDots = $_POST['whiteDots'];
  if (empty($whiteDots)) {
    $whiteDots = 0;
  }
  $colorVariation = $_POST['colorVariation'];
  if (empty($colorVariation)) {
    $colorVariation = 0;
  }
  $powderMark = $_POST['powderMark'];
  if (empty($powderMark)) {
    $powderMark = 0;
  }
  $discoloration = $_POST['discoloration'];
  if (empty($discoloration)) {
    $discoloration = 0;
  }
  $misregistration = $_POST['misregistration'];
  if (empty($misregistration)) {
    $misregistration = 0;
  }
  $whitePatches = $_POST['whitePatches'];
  if (empty($whitePatches)) {
    $whitePatches = 0;
  }
  $dcOOP = $_POST['dcOOP'];
  if (empty($dcOOP)) {
    $dcOOP = 0;
  }
  $dcONEP = $_POST['dcONEP'];
  if (empty($dcONEP)) {
    $dcONEP = 0;
  }
  $dcCrack = $_POST['dcCrack'];
  if (empty($dcCrack)) {
    $dcCrack = 0;
  }
  $excessivePaperDust = $_POST['excessivePaperDust'];
  if (empty($excessivePaperDust)) {
    $excessivePaperDust = 0;
  }
  $noFTIG = $_POST['noFTIG'];
  if (empty($noFTIG)) {
    $noFTIG = 0;
  }
  $scrathesGluing = $_POST['scrathesGluing'];
  if (empty($scrathesGluing)) {
    $scrathesGluing = 0;
  }
  $mixedSLF = $_POST['mixedSLF'];
  if (empty($mixedSLF)) {
    $mixedSLF = 0;
  }
  $shortageQuantity = $_POST['shortageQuantity'];
  if (empty($shortageQuantity)) {
    $shortageQuantity = 0;
  }
  $colorAbrasion = $_POST['colorAbrasion'];
  if (empty($colorAbrasion)) {
    $colorAbrasion = 0;
  }
  $tearDamage = $_POST['tearDamage'];
  if (empty($tearDamage)) {
    $tearDamage = 0;
  }
  $excessiveGlue = $_POST['excessiveGlue'];
  if (empty($excessiveGlue)) {
    $excessiveGlue = 0;
  }

  //Verify
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $progressSelect = $_POST['progressSelect'];
  $remark = $_POST['remark'] != '' ? $_POST['remark'] : NULL;
  $checkedBy = $_SESSION['userID'];

  //Query statements to add OIR Pallet Record
  $query = "{CALL SP_AddOIRPalletRecord( ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(1, $RecordID);
  $stmt->bindParam(2, $progressSelect);
  $stmt->bindParam(3, $checkedBy);
  $stmt->bindParam(4, $sizeSelect);
  $stmt->bindParam(5, $itemNumber);
  $stmt->bindParam(6, $palletNumber);
  $stmt->bindParam(7, $batchSize);
  $stmt->bindParam(8, $quantityCheck1);
  $stmt->bindParam(9, $quantityCheck2);
  $stmt->bindParam(10, $quantityCheck3);
  $stmt->bindParam(11, $thickness);
  $stmt->bindParam(12, $grammage);
  $stmt->bindParam(13, $status);

  //Defects
  $stmt->bindParam(14, $dirtSPL);
  $stmt->bindParam(15, $excessivePowder);
  $stmt->bindParam(16, $paperCoating);
  $stmt->bindParam(17, $inkSmearing);
  $stmt->bindParam(18, $fungus);
  $stmt->bindParam(19, $scrathesPrinting);
  $stmt->bindParam(20, $waterMark);
  $stmt->bindParam(21, $whiteDots);
  $stmt->bindParam(22, $colorVariation);
  $stmt->bindParam(23, $powderMark);
  $stmt->bindParam(24, $discoloration);
  $stmt->bindParam(25, $misregistration);
  $stmt->bindParam(26, $whitePatches);
  $stmt->bindParam(27, $dcOOP);
  $stmt->bindParam(28, $dcONEP);
  $stmt->bindParam(29, $dcCrack);
  $stmt->bindParam(30, $excessivePaperDust);
  $stmt->bindParam(31, $noFTIG);
  $stmt->bindParam(32, $scrathesGluing);
  $stmt->bindParam(33, $mixedSLF);
  $stmt->bindParam(34, $shortageQuantity);
  $stmt->bindParam(35, $colorAbrasion);
  $stmt->bindParam(36, $tearDamage);
  $stmt->bindParam(37, $excessiveGlue);

  //Remark
  $stmt->bindParam(38, $remark);

  if ($stmt->execute()) {
    if ($progressSelect == '0') {
      //Redirect to Pallet Form with success message
      header("Location: ../pages/oirpallet.php?action=success&RecordID=" . $RecordID . "");
    } else {
      //Redirect to Job Form with success message
      header("Location: ../pages/oirjob.php?action=success");
    }
  } else {
    //Redirect with error message
    header("Location: ../pages/oirpallet.php?action=error&RecordID=" . $RecordID . "");
  }
} //Edit OIR Pallet Form
elseif (isset($_POST['palletUpdate'])) {

  //Get Master ID & PalletID from URL parameter
  $RecordID = $_GET['RecordID'];
  $palletID = $_GET['palletID'];

  //Pallet Details
  $palletNumber = $_POST['palletNumber'];
  $sizeSelect = $_POST['sizeSelect'];
  $itemNumber = $_POST['itemNumber'];
  $batchSize = $_POST['batchSize'];
  $quantityCheck1 = $_POST['quantityCheck1'];
  $quantityCheck2 = $_POST['quantityCheck2'];
  $quantityCheck3 = $_POST['quantityCheck3'];
  $thickness = $_POST['thickness'];
  $grammage = $_POST['grammage'];

  //Defects
  $dirtSPL = $_POST['dirtSPL'];

  if (empty($dirtSPL)) {
    $dirtSPL = 0;
  }
  $excessivePowder = $_POST['excessivePowder'];
  if (empty($excessivePowder)) {
    $dirtSPL = 0;
  }
  $paperCoating = $_POST['paperCoating'];
  if (empty($paperCoating)) {
    $paperCoating = 0;
  }
  $inkSmearing = $_POST['inkSmearing'];
  if (empty($inkSmearing)) {
    $inkSmearing = 0;
  }
  $fungus = $_POST['fungus'];
  if (empty($fungus)) {
    $fungus = 0;
  }
  $scrathesPrinting = $_POST['scrathesPrinting'];
  if (empty($scrathesPrinting)) {
    $scrathesPrinting = 0;
  }
  $waterMark = $_POST['waterMark'];
  if (empty($waterMark)) {
    $waterMark = 0;
  }
  $whiteDots = $_POST['whiteDots'];
  if (empty($whiteDots)) {
    $whiteDots = 0;
  }
  $colorVariation = $_POST['colorVariation'];
  if (empty($colorVariation)) {
    $colorVariation = 0;
  }
  $powderMark = $_POST['powderMark'];
  if (empty($powderMark)) {
    $powderMark = 0;
  }
  $discoloration = $_POST['discoloration'];
  if (empty($discoloration)) {
    $discoloration = 0;
  }
  $misregistration = $_POST['misregistration'];
  if (empty($misregistration)) {
    $misregistration = 0;
  }
  $whitePatches = $_POST['whitePatches'];
  if (empty($whitePatches)) {
    $whitePatches = 0;
  }
  $dcOOP = $_POST['dcOOP'];
  if (empty($dcOOP)) {
    $dcOOP = 0;
  }
  $dcONEP = $_POST['dcONEP'];
  if (empty($dcONEP)) {
    $dcONEP = 0;
  }
  $dcCrack = $_POST['dcCrack'];
  if (empty($dcCrack)) {
    $dcCrack = 0;
  }
  $excessivePaperDust = $_POST['excessivePaperDust'];
  if (empty($excessivePaperDust)) {
    $excessivePaperDust = 0;
  }
  $noFTIG = $_POST['noFTIG'];
  if (empty($noFTIG)) {
    $noFTIG = 0;
  }
  $scrathesGluing = $_POST['scrathesGluing'];
  if (empty($scrathesGluing)) {
    $scrathesGluing = 0;
  }
  $mixedSLF = $_POST['mixedSLF'];
  if (empty($mixedSLF)) {
    $mixedSLF = 0;
  }
  $shortageQuantity = $_POST['shortageQuantity'];
  if (empty($shortageQuantity)) {
    $shortageQuantity = 0;
  }
  $colorAbrasion = $_POST['colorAbrasion'];
  if (empty($colorAbrasion)) {
    $colorAbrasion = 0;
  }
  $tearDamage = $_POST['tearDamage'];
  if (empty($tearDamage)) {
    $tearDamage = 0;
  }
  $excessiveGlue = $_POST['excessiveGlue'];
  if (empty($excessiveGlue)) {
    $excessiveGlue = 0;
  }

  //Verify
  $status = $_POST['status'] == 'Pass' ? 1 : 0;
  $remark = $_POST['remark'] != '' ? $_POST['remark'] : NULL;

  //Query statements to add OIR Pallet Record
  $query = "{CALL SP_EditOIRPalletRecord(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(1, $RecordID);
  $stmt->bindParam(2, $palletID);
  $stmt->bindParam(3, $sizeSelect);
  $stmt->bindParam(4, $itemNumber);
  $stmt->bindParam(5, $palletNumber);
  $stmt->bindParam(6, $batchSize);
  $stmt->bindParam(7, $quantityCheck1);
  $stmt->bindParam(8, $quantityCheck2);
  $stmt->bindParam(9, $quantityCheck3);
  $stmt->bindParam(10, $thickness);
  $stmt->bindParam(11, $grammage);
  $stmt->bindParam(12, $status);

  //Defects
  $stmt->bindParam(13, $dirtSPL);
  $stmt->bindParam(14, $excessivePowder);
  $stmt->bindParam(15, $paperCoating);
  $stmt->bindParam(16, $inkSmearing);
  $stmt->bindParam(17, $fungus);
  $stmt->bindParam(18, $scrathesPrinting);
  $stmt->bindParam(19, $waterMark);
  $stmt->bindParam(20, $whiteDots);
  $stmt->bindParam(21, $colorVariation);
  $stmt->bindParam(22, $powderMark);
  $stmt->bindParam(23, $discoloration);
  $stmt->bindParam(24, $misregistration);
  $stmt->bindParam(25, $whitePatches);
  $stmt->bindParam(26, $dcOOP);
  $stmt->bindParam(27, $dcONEP);
  $stmt->bindParam(28, $dcCrack);
  $stmt->bindParam(29, $excessivePaperDust);
  $stmt->bindParam(30, $noFTIG);
  $stmt->bindParam(31, $scrathesGluing);
  $stmt->bindParam(32, $mixedSLF);
  $stmt->bindParam(33, $shortageQuantity);
  $stmt->bindParam(34, $colorAbrasion);
  $stmt->bindParam(35, $tearDamage);
  $stmt->bindParam(36, $excessiveGlue);

  //Remark
  $stmt->bindParam(37, $remark);

  if ($stmt->execute()) {
    //Redirect with success message
    header("Location: ../pages/oirpallet.php?action=success");
  } else {
    //Redirect with error message
    header("Location: ../pages/oirpallet.php?action=error");
  }
}
