<?php

  //Calculate Sample, Acceptance & Rejectance using Batch Quantity and AQL
  $aql = $palletRecord['AQLValue'];
  $batchSize = $palletRecord['Quantity'];
 
  if($batchSize >= 26 && $batchSize <= 50){
    $sample1 = 13;
    $acc1 = 0;

    $sample2 = 8;
    $acc2 = 0;

    $sample3 = 5;
    $acc3 = 0;
  }else if($batchSize >= 51 && $batchSize <= 90){
    $sample1 = 13;
    $acc1 = 0;

    $sample2 = 8;
    $acc2 = 0;

    $sample3 = 13;
    $acc3 = 1;
  }else if($batchSize >= 91 && $batchSize <= 150){

   
    $sample1 = 13;
    $acc1 = 0;

    $sample2 = 32;
    $acc2 = 1;

    $sample3 = 20;
    $acc3 = 1;
  }else if($batchSize >= 151 && $batchSize <= 280){
    $sample1 = 50;
    $acc1 = 1;

    $sample2 = 32;
    $acc2 = 1;

    $sample3 = 32;
    $acc3 = 2;
  }else if($batchSize >= 281 && $batchSize <= 500){
    $sample1 = 50;
    $acc1 = 1;

    $sample2 = 50;
    $acc2 = 2;

    $sample3 = 50;
    $acc3 = 3;
  }else if($batchSize >= 501 && $batchSize <= 1200){
    $sample1 = 80;
    $acc1 = 2;

    $sample2 = 80;
    $acc2 = 3;

    $sample3 = 80;
    $acc3 = 5;
  }else if($batchSize >= 1201 && $batchSize <= 3200){
    $sample1 = 125;
    $acc1 = 3;

    $sample2 = 125;
    $acc2 = 5;

    $sample3 = 125;
    $acc3 = 7;
  }else if($batchSize >= 3201 && $batchSize <= 10000){
    $sample1 = 200;
    $acc1 = 5;

    $sample2 = 200;
    $acc2 = 7;

    $sample3 = 200;
    $acc3 = 10;
  }else if($batchSize >= 10001 && $batchSize <= 35000){
    $sample1 = 315;
    $acc1 = 7;

    $sample2 = 315;
    $acc2 = 10;

    $sample3 = 315;
    $acc3 = 14;
  }else if($batchSize >= 35001 && $batchSize <= 150000){
    $sample1 = 500;
    $acc1 = 10;

    $sample2 = 500;
    $acc2 = 14;

    $sample3 = 500;
    $acc3 = 21;
  }else if($batchSize >= 150001 && $batchSize <= 500000){
    $sample1 = 800;
    $acc1 = 14;

    $sample2 = 800;
    $acc2 = 21;

    $sample3 = 500;
    $acc3 = 21;
  }else if($batchSize >= 500001 && $batchSize <= 10000000000000){
    $sample1 = 1250;
    $acc1 = 21;

    $sample2 = 800;
    $acc2 = 21;

    $sample3 = 500;
    $acc3 = 21;
  }
  if($aql == '1.0'){
    $rej = $acc1 + 1;
    $sample = $sample1;  
    $acc = $acc1;
  }else if($aql == '1.5'){
    $rej = $acc2 + 1;
    $sample = $sample2;  
    $acc = $acc2;
  }else if($aql == '2.5'){
    $rej = $acc3 + 1;
    $sample = $sample3;  
    $acc = $acc3;
  }
?>
