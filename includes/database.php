<!-- Database connection -->
<?php
  try{
    $conn = new PDO("sqlsrv:Server=172.16.10.61\QAPQC; Database=QAF34PM", "pqcapp", "TGQApqcQrex");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch (Exception $e){
    die(print_r( $e->getMessage()));
  }
?>