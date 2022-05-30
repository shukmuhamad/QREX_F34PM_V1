<?php
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/database.php');
     //Call sp to view Item, Size, Customer, Supplier
    //Call sp to view Item, Size, Customer, Supplier
    $query = "{CALL SP_ViewCheckSheetList()}";
    $stmt = $conn->prepare($query);
    $stmt->execute();
      
    $fetchCustomer = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchItem = $stmt->fetchAll();
    $stmt->nextRowset();
    $fetchSize = $stmt->fetchAll();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <?php
      if(isset($_GET['masterID'])){
        //Assign MasterID to variable
        $masterID = $_GET['masterID'];

        //Query to check if record exist
        $query = "SELECT * FROM View_CheckSheetRecordByID WHERE RecordID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $masterID);
        $stmt->execute();
        $checkRecord = $stmt->fetch();

        //Check if query returns valid array(There is record in database)
        if(is_array($checkRecord)){
          //If MasterID exist, show Check Sheet Edit Form
          include('checksheet/editchecksheet.php');
        }else{
          //Else show invalid page
          include('checksheet/invalidchecksheet.php');
        }
      }else{
        //If no MasterID, show Check Sheet Form
        include('checksheet/formchecksheet.php');
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
    //Set first four OIR Number
    $('#oirNumber').val($.datepicker.formatDate('y/mm', new Date()));

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

    //Validate form
    $('#checksheetForm').validate({
      rules: {
        customerSelect: {
          required: true
        },
        itemSelect: {
          required: true
        },
        skill: {
          required: true
        },
        quantityOrder: {
          required: true,
          integer: true,
          min: 1,
          max: 2147483647
        },
        oirNumber: {
          required: true,
          oirValid: true
        },
        jobNumber: {
          required: true,
          remote: {
            url: 'lol3.php',
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
        boxDimension: {
          required: true,
          maxlength: 100
        },
        topPanel: {
          required: true,
          maxlength: 100
        },
        sidePanel: {
          required: true,
          maxlength: 100
        },
        bottomPanel: {
          required: true,
          maxlength: 100
        },
        printedColor: {
          required: true,
          maxlength: 100
        },
        varnishArea: {
          required: true,
          maxlength: 100
        },
        lotPartNo: {
          required: true,
          maxlength: 100
        }, 
        barcodes: {
          required: true,
          maxlength: 100
        }, 
        sizeRatio: {
          required: true,
          maxlength: 100
        }, 
        overallDCD: {
          required: true,
          maxlength: 100
        }, 
        logoSymbol: {
          required: true,
          maxlength: 100
        },
        paperThickness: {
          required: true,
          maxlength: 100
        },
        others: {
          required: true,
          maxlength: 100
        }
      },
      messages: {
        customerSelect: {
          required: "Please select a Customer."
        },
        itemSelect: {
          required: "Please select an Item."
        },
        skill: {
          required: "Please select a Size Ratio."
        },
        quantityOrder: {
          required: "Please enter the Quantity Ordered.",
          integer: "Please enter a whole number greater than 1."
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

        //Validate form
        $('#1checksheetForm').validate({
      rules: {
        customerSelect: {
          required: true
        },
        itemSelect: {
          required: true
        },
        skill: {
          required: true
        },
        quantityOrder: {
          required: true,
          integer: true,
          min: 1,
          max: 2147483647
        },
        oirNumber: {
          required: true,
          oirValid: true
        },
        jobNumber: {
          required: true,
          maxlength: 12,
          minlength: 8
        },
        epCode: {
          required: true,
          maxlength: 12,
          minlength: 11
        },
        boxDimension: {
          
          maxlength: 100
        },
        topPanel: {
        
          maxlength: 100
        },
        sidePanel: {
         
          maxlength: 100
        },
        bottomPanel: {
         
          maxlength: 100
        },
        printedColor: {
         
          maxlength: 100
        },
        varnishArea: {
        
          maxlength: 100
        },
        lotPartNo: {
         
          maxlength: 100
        }, 
        barcodes: {
       
          maxlength: 100
        }, 
        sizeRatio: {
        
          maxlength: 100
        }, 
        overallDCD: {
         
          maxlength: 100
        }, 
        logoSymbol: {
  
          maxlength: 100
        },
        paperThickness: {
  
          maxlength: 100
        },
        others: {
          
          maxlength: 100
        }
      },
      messages: {
        customerSelect: {
          required: "Please select a Customer."
        },
        itemSelect: {
          required: "Please select an Item."
        },
        skill: {
          required: "Please select a Size Ratio."
        },
        quantityOrder: {
          required: "Please enter the Quantity Ordered.",
          integer: "Please enter a whole number greater than 1."
        },
        oirNumber: {
          required: "Please enter the OIR Number."
        },
        jobNumber: {
          required: "Please enter the Job Number."
        },
        epCode: {
          required: "Please enter the EP Code."
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
