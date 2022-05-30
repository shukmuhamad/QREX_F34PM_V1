<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');

  //Call sp to view Item, Size, Customer, Supplier
  $query = '{CALL SP_ViewPatchingList()}';
  $stmt = $conn->prepare($query);
  $stmt->execute();
  
  $fetchItem = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchSize = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchSupplier = $stmt->fetchAll();
  $stmt->nextRowset();
  $fetchAQL  = $stmt->fetchAll()
  

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
            include('printing/inspect/invalidjob.php');
          
          }else{
            //Else show Edit Job Form
            include('printing/inspect/editprintInspection.php');
    
          }
        }
      }else{
        //If only MasterID is supplied and no IncomingID, show Pallet Form
        include('printing/inspect/formprintInspect.php');
      }
    }
      else{
        //If no masterID parameter in URL, show Job Form
        include('printing/inspect/formjobnumber5.php');
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
   $('#printing8Form').validate({
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
    $('#print7').validate({
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
       
        postLay: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        
        rest: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        
        stick: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        mixed: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        spotVar: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        incomp: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        verify: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        colorVar: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dirt: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        bar: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        lot: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        doub: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        water: {
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
        
        postLay: {
          integer: "Please enter a whole number."
        },
        rest: {
          integer: "Please enter a whole number."
        },
        stick: {
          integer: "Please enter a whole number."
        },
        mixed: {
          integer: "Please enter a whole number."
        },
        spotVar: {
          integer: "Please enter a whole number."
        },
        incomp: {
          integer: "Please enter a whole number."
        },
        verify: {
          integer: "Please enter a whole number."
      
        },
        colorVar: {
          integer: "Please enter a whole number."
      
        },
        dirt: {
          integer: "Please enter a whole number."
      
        },
        bar: {
          integer: "Please enter a whole number."
      
        },
        lot: {
          integer: "Please enter a whole number."
      
        },
        doub: {
          integer: "Please enter a whole number."
      
        },
        water: {
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
   $('#printInspectForm').validate({
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
       
        postLay: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        
        rest: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        
        stick: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        mixed: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        spotVar: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        incomp: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        verify: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        colorVar: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dirt: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        bar: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        lot: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        doub: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        water: {
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
        
        postLay: {
          integer: "Please enter a whole number."
        },
        rest: {
          integer: "Please enter a whole number."
        },
        stick: {
          integer: "Please enter a whole number."
        },
        mixed: {
          integer: "Please enter a whole number."
        },
        spotVar: {
          integer: "Please enter a whole number."
        },
        incomp: {
          integer: "Please enter a whole number."
        },
        verify: {
          integer: "Please enter a whole number."
      
        },
        colorVar: {
          integer: "Please enter a whole number."
      
        },
        dirt: {
          integer: "Please enter a whole number."
      
        },
        bar: {
          integer: "Please enter a whole number."
      
        },
        lot: {
          integer: "Please enter a whole number."
      
        },
        doub: {
          integer: "Please enter a whole number."
      
        },
        water: {
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