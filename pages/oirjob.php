<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');

    //Call sp to view  Customer, Item, InspectionSection, AQL, PackingType
    $query = "{CALL SP_ViewOIRJobList()}";
    $stmt = $conn->prepare($query);
    $stmt->execute();
  
  
    $fetchCustomer = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchItem = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchInspectionSection = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchAQL = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchPackingType = $stmt->fetchAll();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <?php
      if(isset($_GET['RecordID'])){

        if($_SESSION['role']!='Staff'){
          //If user not Staff, show Unauthorized Page
          include('../includes/unauthorized.php');
        }else{
          //Assign MasterID to variable
          $RecordID = $_GET['RecordID'];

          $query = "SELECT InspectionType FROM View_OIRJobRecordByID WHERE RecordID = ?";
          $stmt = $conn->prepare($query);
          $stmt->bindParam(1, $RecordID);
          $stmt->execute();
          $fetchInspectionType = $stmt->fetch();

          //Check if query returns valid array(There is record in database)
          if(is_array($fetchInspectionType)){

            if($fetchInspectionType['InspectionType']=='Reinspection'){
              //If Job inspection type is Reinspection, show Edit Job Reinspection Form
              include('oir/job/editjobreinspect.php');
              
            }elseif($fetchInspectionType['InspectionType']=='New Inspection'){

              $query = "SELECT COUNT(JobNumber) AS JobNumber FROM View_OIRJobRecordByID WHERE JobNumber = (SELECT JobNumber FROM View_OIRJobRecordByID WHERE RecordID = ?)";
              $stmt = $conn->prepare($query);
              $stmt->bindParam(1, $RecordID);
              $stmt->execute();
              $fetchJobNumber = $stmt->fetch();

              if($fetchJobNumber['JobNumber']>1){
                //If query returns >1 row(Job Reinspected), show Invalid Page
                include('oir/job/invalidjob.php');
              }else{
                //Else Job is not Reinspected, show Edit Job Form
                include('oir/job/editjob.php');
              }
            }
          }else{
            //If query returns 0 row(no Job record), show Invalid Page
            include('oir/job/invalidjob.php');
          }
        }
      }else{
        //If no masterID parameter in URL, show Job Form
        include('oir/job/formjob.php');
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
    }elseif($_GET['action']=='error'){
      echo '<script>toastr.error("There was a problem encountered during the saving process!")</script>';
    }
  }
?>

<script>
  $(function () {
    //Set first seven OIR Number
    $('#oirNumber').val($.datepicker.formatDate('OIR/y/mm', new Date()))

    //Set first letter for Job Number
    $('#jobNumber').val('J')

    //Set first two letter for EP Code
    $('#epCode').val('EP')

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

    //Validate oir number
    jQuery.validator.addMethod("oirValid", function(value, element){
      if (/_/.test(value)) {
        //Fail if contains _
        return false  
      } else {
        //Pass validation otherwise
        return true   
      };
    }, "Please enter a valid OIR Number.")

    //Validate Job Form
    $('#jobForm').validate({
      rules: {
        customerSelect: {
          required: true
        },
        itemSelect: {
          required: true
        },
        quantityPerBundle: {
          required: true,
          integer: true,
          min: 1,
          max: 32767
        },
        quantityPerPacking: {
          required: true,
          integer: true,
          min: 0,
          max: 32767
        },
        inspectionSectionSelect: {
          required: true
        },
        oirNumber: {
          required: true,
          oirValid: true
        },
	jobNumber: {
    required: true,
          remote: {
            url: 'lol.php',
            type: 'get',
            data: {
              jobNumber: function () { 
                return $('#jobNumber').val();
              }
            }
          },
          maxlength: 12,
          minlength: 8
        },
        epCode: {
          required: true,
          maxlength: 12,
          minlength: 11
        },
        aqlSelect: {
          required: true
        },
        packingTypeSelect: {
          required: true
        }
      },
      messages: {
        customerSelect: {
          required: "Please select a Customer."
        },
        itemSelect: {
          required: "Please select an Item."
        },
        quantityPerBundle: {
          required: "Please enter the Quantity per Bundle.",
          integer: "Please enter a whole number."
        },
        quantityPerPacking: {
          required: "Please enter the Quantity per Packing.",
          integer: "Please enter a whole number."
        },
        inspectionSectionSelect: {
          required: "Please select an Inspection Section."
        },
        oirNumber: {
          required: "Please enter the OIR Number."
        },
        jobNumber: {
          required: "Please enter the Job Number.",
          remote: "This Job Number already exists."
        },
        epCode: {
          required: "Please enter the EP Code."
        },
        aqlSelect: {
          required: "Please select an AQL."
        },
        packingTypeSelect: {
          required: "Please select a Packing Type."
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

  })
</script>
  
    
