<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');

    //Call sp to view Item, Size, Customer, Supplier
    $query = "{CALL SP_ViewGlueList()}";
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

    //Assign MasterID to variable
     $masterID = $_GET['masterID'];

     $query = "SELECT COUNT(JobNumber) AS JobNumber FROM View_IncomingRecordByID WHERE JobNumber = (SELECT JobNumber FROM View_IncomingRecordByID WHERE RecordID = ?)";
     $stmt = $conn->prepare($query);
     $stmt->bindParam(1, $masterID);
     $stmt->execute();
     $fetchJobNumber = $stmt->fetch();

     if(isset($_GET['incomingID'])){

        if($_SESSION['role']!='Staff'){
          //If user not Staff, show Unauthorized Page
          include('../includes/unauthorized.php');
        }else{

           //Assign IncomingID to variable
           $incomingID = $_GET['incomingID']; 

          if($fetchJobNumber['JobNumber']>1){
            //If query returns >1 row, show Invalid Page
            include('manualglue/inspect/invalidjob.php');
          
          }else{
            //Else show Edit Job Form
            include('manualglue/inspect/editglueInspection.php');
    
          }
        }
      }else{
        //If only MasterID is supplied and no IncomingID, show Pallet Form
        include('manualglue/inspect/formglueinspection.php');
      }
    }
      else{
        //If no masterID parameter in URL, show Job Form
        include('manualglue/inspect/formjobnumber4.php');
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
<script src="../dist/js/autocalculatefinish.js"></script>

<script>
  $(function () {

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
   $('#manualnumberSubmit').validate({
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

    //Validate Form
    $('#glue7').validate({
      rules: {
        sizeRatioSelect: {
          required: true
        },
        sizeNo: {
          number: true,
          integer: true,
          min: 1,
          max: 999
        },
        qty: {
          required: true,
          number: true,
          integer: true,
          min: 26,
          max: 2147483647
        },
        
        aqlSelect: {
          required: true
        },
       
        stickPosition: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        
        sideSeam: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        
        exGlue: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        sideStap: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        matDamn: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        noStri: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        }
        
      },
      messages: {

        sizeRatioSelect: {
          required: "Please select the Size."
        },
        sizeNo: {
          required: "Please select the Size No."
        },
        aqlSelect: {
          required: "Please select the Size No."
        },
        qty: {
          required: "Please enter the Quantity.",
          integer: "Please enter a whole number."
        },
        
        stickPosition: {
          integer: "Please enter a whole number."
        },
        sideSeam: {
          integer: "Please enter a whole number."
        },
        exGlue: {
          integer: "Please enter a whole number."
        },
        sideStap: {
          integer: "Please enter a whole number."
        },
        matDamn: {
          integer: "Please enter a whole number."
        },
        noStri: {
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

   //Validate Form
   $('#glueInspectForm').validate({
    rules: {
        sizeRatioSelect: {
          required: true
        },
        sizeNo: {
          number: true,
          integer: true,
          min: 1,
          max: 999
        },
        qty: {
          required: true,
          number: true,
          integer: true,
          min: 26,
          max: 2147483647
        },
        
        aqlSelect: {
          required: true
        },
       
        stickPosition: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        
        sideSeam: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        
        exGlue: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        sideStap: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        matDamn: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        noStri: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        }
        
      },
      messages: {

        sizeRatioSelect: {
          required: "Please select the Size."
        },
        sizeNo: {
          required: "Please select the Size No."
        },
        aqlSelect: {
          required: "Please select the Size No."
        },
        qty: {
          required: "Please enter the Quantity.",
          integer: "Please enter a whole number."
        },
        
        stickPosition: {
          integer: "Please enter a whole number."
        },
        sideSeam: {
          integer: "Please enter a whole number."
        },
        exGlue: {
          integer: "Please enter a whole number."
        },
        sideStap: {
          integer: "Please enter a whole number."
        },
        matDamn: {
          integer: "Please enter a whole number."
        },
        noStri: {
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
    $('#qty').keyup(function(){
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