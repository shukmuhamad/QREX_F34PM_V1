<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');

    //Call sp to view Item, Size, Customer, Supplier
    $query = "{CALL SP_ViewFluteList()}";
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
              include('flute/inspect/invalidjob.php');
            }else{
              //Else show Edit Job Form
              include('flute/inspect/editfluteinspect.php');
            }
          }
        }else{
          //If only MasterID is supplied and no IncomingID, show Pallet Form
          include('flute/inspect/formfluteinspection.php');
        }
      }
        else{
          //If no masterID parameter in URL, show Job Form
          include('flute/inspect/formjobnumber3.php');
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
    $('#incoming8Form').validate({
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
 //Validate edit Form
 $('#finishInspect').validate({
  rules: {
        sizeRatioSelect: {
          required: true
        },
        itemNo: {
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
       
        colorVar: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        postLay: {
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
        sideSeam: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dieCut: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dirty: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        flutepost: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        sideGlued: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        matThorn: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        poorCut: {
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
        itemNumber: {
          required: "Please enter the Item Number.",
          integer: "Please enter a whole number."
        },
        qty: {
          required: "Please enter the Quantity.",
          integer: "Please enter a whole number."
        },
        
        colorVar: {
          integer: "Please enter a whole number."
        },
        postLay: {
          integer: "Please enter a whole number."
        },
        mixed: {
          integer: "Please enter a whole number."
        },
        sideSeam: {
          integer: "Please enter a whole number."
        },
        dieCut: {
          integer: "Please enter a whole number."
        },
        barcode: {
          integer: "Please enter a whole number."
        },
        dirty: {
          integer: "Please enter a whole number."
        },
        barcode: {
          integer: "Please enter a whole number."
        },
        flutepost: {
          integer: "Please enter a whole number."
        },
        sideGlued: {
          integer: "Please enter a whole number."
        },
        matThorn: {
          integer: "Please enter a whole number."
        },
        poorCut: {
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
    $('#fluteInspectForm').validate({
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
       
        colorVar: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        postLay: {
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
        sideSeam: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dieCut: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        dirty: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        flutepost: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        sideGlued: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        matThorn: {
          number: true,
          integer: true,
          min: 0,
          max: 255
        },
        poorCut: {
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
        itemNumber: {
          required: "Please enter the Item Number.",
          integer: "Please enter a whole number."
        },
        qty: {
          required: "Please enter the Quantity.",
          integer: "Please enter a whole number."
        },
        
        colorVar: {
          integer: "Please enter a whole number."
        },
        postLay: {
          integer: "Please enter a whole number."
        },
        mixed: {
          integer: "Please enter a whole number."
        },
        sideSeam: {
          integer: "Please enter a whole number."
        },
        dieCut: {
          integer: "Please enter a whole number."
        },
        barcode: {
          integer: "Please enter a whole number."
        },
        dirty: {
          integer: "Please enter a whole number."
        },
        barcode: {
          integer: "Please enter a whole number."
        },
        flutepost: {
          integer: "Please enter a whole number."
        },
        sideGlued: {
          integer: "Please enter a whole number."
        },
        matThorn: {
          integer: "Please enter a whole number."
        },
        poorCut: {
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