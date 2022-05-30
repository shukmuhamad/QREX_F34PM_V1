<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');

    //Call sp to view Item, Size, Customer, Supplier
    $query = "{CALL SP_ViewPatchingList()}";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $fetchItem = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchSize = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchSupplier = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchAQL  = $stmt->fetchAll();
  
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <?php
      if(isset($_GET['masterID'])){

        if($_SESSION['role']!='Staff'){
          //If user not Staff, show Unauthorized Page
          include('../includes/unauthorized.php');
        }else{

        //Assign MasterID to variable
        $masterID = $_GET['masterID'];

        $query = "SELECT COUNT(JobNumber) AS JobNumber FROM View_IncomingRecordByID WHERE JobNumber = (SELECT JobNumber FROM View_IncomingRecordByID WHERE RecordID = ?)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $masterID);
        $stmt->execute();
        $fetchJobNumber = $stmt->fetch();

        if($fetchJobNumber['JobNumber']>1){
          //If query returns >1 row,show Invalid Page
          include('dieCut/inspect/invalidjob.php');
        }else{
          //Else show Edit Job Form
          include('dieCut/editdie.php');
        }
      }
      }else{ 
        //If no MasterID, show Finish Form
        include('dieCut/formdiecut.php');
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
  }
?>


<script>
  $(function () {
    //Set first seven report number
    $('#reportNumber').val($.datepicker.formatDate('QAI/y/mm/ ', new Date()))

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
    }, "Please enter a valid Report Number.")

    //Validate Job Form
    $('#editdieForm').validate({
      rules: {
      
        itemSelect: {
          required: true
        },
      	jobNumber: {
          required: true,
          remote: {
            url: 'lol2.php',
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
        supplierSelect: {
          required: true
        },

        doNumber: {
          required: true,
          maxlength: 10
        },
        jobQuantity: {
          required: true,
          maxlength: 10
        },
        doQuantity: {
          required: true,
          maxlength: 10
        },
        reportNumber: {
          required: true,
          oirValid: true

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
        },
        receivedDate: {
          required: true
        }
      },
      messages: {

        itemSelect: {
          required: "Please select an Item."
        },
        jobNumber: {
          required: "Please enter the Job Number.",
          remote: "This Job Number already exists."
        },
        supplierSelect: {
          required: "Please select the Supplier."
        },
        doNumber: {
          required: "Please enter the DO Number."
        },
        jobQuantity: {
          required: "Please enter the Job Quantity."
        },
        doQuantity: {
          required: "Please enter the DO Quantity."
        },
        reportNumber: {
          required: "Please enter the Report Number."
        },
        receivedDate: {
          required: "Please enter the date."
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
  
   //Validate Job Form
 $('#dieCutForm').validate({
      rules: {

        itemSelect: {
          required: true
        },
      	jobNumber: {
          required: true,
          remote: {
            url: 'lol2.php',
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
        supplierSelect: {
          required: true
        },

        doNumber: {
          required: true,
          maxlength: 10
        },
        jobQuantity: {
          required: true,
          maxlength: 10
        },
        doQuantity: {
          required: true,
          maxlength: 10
        },
        reportNumber: {
          required: true,
          oirValid: true

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
        },
        receivedDate: {
          required: true
        }
      },
      messages: {
        itemSelect: {
          required: "Please select an Item."
        },
        jobNumber: {
          required: "Please enter the Job Number.",
          remote: "This Job Number already exists."
        },
        supplierSelect: {
          required: "Please select the Supplier."
        },
        doNumber: {
          required: "Please enter the DO Number."
        },
        jobQuantity: {
          required: "Please enter the Job Quantity."
        },
        doQuantity: {
          required: "Please enter the DO Quantity."
        },
        reportNumber: {
          required: "Please enter the Report Number."
        },
        receivedDate: {
          required: "Please enter the date."
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

  
