<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');
?>

<?php

      //Call sp to view Size
      $query = "{CALL SP_ViewOIRPalletList()}";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      
      $fetchSize = $stmt->fetchAll();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php
      if(isset($_GET['RecordID'])){

        //Assign MasterID to variable
        $RecordID = $_GET['RecordID'];

        $query = "SELECT InspectionType FROM View_OIRJobRecordByID WHERE RecordID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $RecordID);
        $stmt->execute();
        $fetchInspectionType = $stmt->fetch();

        //Check if query returns valid array(There is record in database)
        if(is_array($fetchInspectionType)){

          if(isset($_GET['palletID'])){
  
            if($_SESSION['role']!='Staff'){
              //If user not Staff, show Unauthorized Page
              include('../includes/unauthorized.php');
            }else{
              //Assign PalletID to variable
              $palletID = $_GET['palletID']; 
            
              if($fetchInspectionType['InspectionType']=='Reinspection'){
                //If Job inspection type is Reinspection, show Edit Pallet Form
                include('oir/pallet/editpallet.php');
                
              }elseif($fetchInspectionType['InspectionType']=='New Inspection'){

                $query = "SELECT COUNT(JobNumber) AS JobNumber FROM View_OIRJobRecordByID WHERE JobNumber = (SELECT JobNumber FROM View_OIRJobRecordByID WHERE RecordID = ?)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(1, $RecordID);
                $stmt->execute();
                $fetchJobNumber = $stmt->fetch();

                if($fetchJobNumber['JobNumber']>1){
                  //If query returns >1 row(Job Reinspected), show Invalid Page
                  include('oir/pallet/invalidpallet.php');
                }else{
                  //Else Job is not Reinspected, show Edit Pallet Form
                  include('oir/pallet/editpallet.php');
                }
              }
            }
          }else{
            //If only MasterID is supplied and no PalletID, show Pallet Form
            include('oir/pallet/formpallet.php');
          }
        }else{
          //If query returns 0 row(no Job record), show Invalid Page
          include('oir/pallet/invalidpallet.php');
        }
      }else{
        //If no masterID parameter in URL, show Initial Form
        include('oir/pallet/initialform.php');
      }
    ?>
         
  </div>
  <!-- /.content-wrapper -->

<?php
  include('../includes/footer.php');
  include('../includes/scripts.php'); 
?>

<?php
  //Toast message after submit form
  if(isset($_GET['action'])){
    if($_GET['action']=='success'){
      echo '<script>toastr.success("Data has been saved into the database successfully!");</script>';
    }
    elseif($_GET['action']=='error'){
      echo '<script>toastr.error("There was a problem encountered during the saving process!")</script>';
    }
    elseif($_GET['action']=='invalid'){
      echo '<script>toastr.error("The details were invalid or the Job is completed!")</script>';
    }
  }
?>

<!-- Include auto calculate .js file -->
<script src="../dist/js/autocalculate.js"></script>
<script>
  $(function () {
    //Set first three OIR Number
    $('#oirNumber').val($.datepicker.formatDate('OIR/y/mm/', new Date()));
    
    //Set first letter for Job Number
    $('#jobNumber').val('J')

    //On success validation insert into database
    $.validator.setDefaults({
      submitHandler: function (form) {
        $.ajax({
          type: form.attr('method'),
          url: form.attr('action'),
          data: form.serialize()
        })
      }
    })

    //Validate Initial Form
    $('#initialForm').validate({
      rules: {
        jobNumber: {
          required: true,
          maxlength: 12,
          minlength: 8
        }
      },
      messages: {
        jobNumber: {
          required: "Please enter the Job Number."
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback')
        element.closest('.form-group').append(error)
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid')
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid')
      }
    })

    //Validate Item Number
    jQuery.validator.addMethod("itemNumberValid", function(value, element){
      if (/_/.test(value)) {
        //Fail if contains _
        return false  
      } else {
        //Pass validation otherwise
        return true   
      };
    }, "Please enter a valid Item Number.")

    //Validate Pallet Form
    $('#palletForm').validate({
      rules: {
        palletNumber: {
          required: true,
          number: true,
          integer: true,
          min: 1,
          max: 255
        },
        sizeSelect: {
          required: true
        },
        itemNumber: {
          required: true,
          itemNumberValid: true
        },
        batchSize: {
          required: true,
          number: true,
          integer: true,
          min: 26,
          max: 2147483647
        },
        quantityCheck1: {
          required: true,
          number: true,
          integer: true,
          min: 1,
          max: 255
        },
        quantityCheck2: {
          required: true,
          number: true,
          integer: true,
          min: 1,
          max: 255
        },
        quantityCheck3: {
          required: true,
          number: true,
          integer: true,
          min: 1,
          max: 255
        },
        thickness: {
          required: true,
          number: true
        },
        grammage: {
          required: true,
          number: true,
          integer: true,
          min: 1,
          max: 32767
        },
        dirtSPL: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        excessivePowder: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        paperCoating: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        inkSmearing: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        fungus: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        scrathesPrinting: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        waterMark: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        whiteDots: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        colorVariation: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        powderMark: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        discoloration: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        misregistration: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        whitePatches: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dcOOP: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dcONEP: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dcCrack: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        excessivePaperDust: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        noFTIG: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        scrathesGluing: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        mixedSLF: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        shortageQuantity: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        colorAbrasion: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        tearDamage: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        excessiveGlue: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        }
      },
      messages: {
        palletNumber: {
          required: "Please enter the Pallet Number.",
          integer: "Please enter a whole number greater than 1."
        },
        sizeSelect: {
          required: "Please select the Size."
        },
        itemNumber: {
          required: "Please enter the Item Number.",
          integer: "Please enter a whole number."
        },
        batchSize: {
          required: "Please enter the Batch Size.",
          integer: "Please enter a whole number."
        },
        quantityCheck1: {
          required: "Please enter the Quantity Checked 1.",
          integer: "Please enter a whole number."
        },
        quantityCheck2: {
          required: "Please enter the Quantity Checked 2.",
          integer: "Please enter a whole number."
        },
        quantityCheck3: {
          required: "Please enter the Quantity Checked 3.",
          integer: "Please enter a whole number."
        },
        thickness: {
          required: "Please enter the Thickness."
        },
        grammage: {
          required: "Please enther the Grammage.",
          integer: "Please enter a whole number."
        },
        dirtSPL: {
          integer: "Please enter a whole number."
        },
        excessivePowder: {
          integer: "Please enter a whole number."
        },
        paperCoating: {
          integer: "Please enter a whole number."
        },
        inkSmearing: {
          integer: "Please enter a whole number."
        },
        fungus: {
          integer: "Please enter a whole number."
        },
        scrathesPrinting: {
          integer: "Please enter a whole number."
        },
        waterMark: {
          integer: "Please enter a whole number."
        },
        whiteDots: {
          integer: "Please enter a whole number."
        },
        colorVariation: {
          integer: "Please enter a whole number."
        },
        powderMark: {
          integer: "Please enter a whole number."
        },
        discoloration: {
          integer: "Please enter a whole number."
        },
        misregistration: {
          integer: "Please enter a whole number."
        },
        whitePatches: {
          integer: "Please enter a whole number."
        },
        dcOOP: {
          integer: "Please enter a whole number."
        },
        dcONEP: {
          integer: "Please enter a whole number."
        },
        dcCrack: {
          integer: "Please enter a whole number."
        },
        excessivePaperDust: {
          integer: "Please enter a whole number."
        },
        noFTIG: {
          integer: "Please enter a whole number."
        },
        scrathesGluing: {
          integer: "Please enter a whole number."
        },
        mixedSLF: {
          integer: "Please enter a whole number."
        },
        shortageQuantity: {
          integer: "Please enter a whole number."
        },
        colorAbrasion: {
          integer: "Please enter a whole number."
        },
        tearDamage: {
          integer: "Please enter a whole number."
        },
        excessiveGlue: {
          integer: "Please enter a whole number."
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback')
        element.closest('.form-group').append(error)
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid')
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid')
      }
    })
    
    //On key up Batch Size, calculate Sample Size, Acceptance, Rejectance & Status
    $('#batchSize').keyup(function(){
      calcSampleAccRej();
      calcStatus();
    });

    //On key up defects, calculate Total Defects & Status 
    $('.defect').keyup(function(){
      calcTotalDefects();
      calcStatus();
    });
  })
</script>