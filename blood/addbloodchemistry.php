<?php
require '../inc/db.init.php';
$report_link = "bloodchemistry";
$data_doctor = $database->select("doctor",
["drid","initials","firstname","surname"],
["drid[>]" => 0]
);

$doctor_arr = array();
foreach($data_doctor as $doctor) {
    $drid = $doctor["drid"];
    $fullname = $doctor['initials']." ".$doctor['firstname']." ".$doctor['surname'];
    $doctor_arr[] = array("drid" => $drid, "fullname" => $fullname);
    //echo $drid." ".$fullname."<br/>";
}

$report_link = "bloodchemistry";

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>PATHOLAB Blood Chemistry</title>
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="../css/dashboard_style.css">
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <!-- Fontawesome -->
  <link rel="stylesheet" href="../css/all.css">
  <!-- Bootstrap Tokenfield -->
  <link rel="stylesheet" href="../css/jquery-ui.css">


  <style type="text/css">
    .heading{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .upper{
      text-transform: uppercase;
    }
    .column-header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
      margin: 10px;
    }
    .patient-header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .report-header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .col-sm-4 {
      //padding-botton : 5px;
      //margin: 0px;
      //padding : 0px;

    }
    .form-control{
      padding : 0px;
      //margin-top: 5px;
    }
    .form-group{
      //padding: 0px
      //margin: 0px;
      margin-bottom: 5px;
    }

    ul{
      background-color: #eee;
      cursor: pointer;
    }
    li{
      padding:12px;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- patient search page links and add Patient modal page -->
    <!-- patient details -->
    <?php include("../inc/search-add-patient.php"); ?>

    <!-- Pathology Form -->
    <div id="main-form" class="text-uppercase">
      <form id="pathology-form" method="post" action="insertbloodchemistry.php" role="form">
        <!-- Doctor Details -->
        <br>
        <div class="row">
          <div class="col-sm-4 offset-sm-2">
            <div class="form-group">
              Ref By :
              <select id="drid" name="drid" class="form-control">
                <?php
                foreach($doctor_arr as $doctor){
                   echo "<option value='".$doctor['drid']."' >".$doctor['fullname']."</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="col-sm-4">
              <input type="hidden" id="patient-id" type="text" name="pid"  />
          </div>
          <div class="col-sm-4">
            <div class="form-group">
                <p></p>
            </div>
          </div>
        </div>

        <!-- Header -->

        <!-- Blood Sugar Fasting : -->
        <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                  <label for="bsf" >Blood Sugar Fasting : </label>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                  <input id="bsf" type="text" name="bsf" class="form-control" placeholder="Blood Sugar Fasting *" >

              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                  <p>mg%</p>
              </div>
            </div>
        </div>

        <!-- Urine Sugar Fasting : -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="usf">Urine Sugar Fasting : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="usf" type="text" name="usf" class="form-control" placeholder="Urine Sugar Fasting *" >

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p></p>
                </div>
            </div>
        </div>

        <!-- Blood Sugar Post Prandial : -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="bspp">Blood Sugar Post Prandial : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="bspp" type="text" name="bspp" class="form-control"
                    placeholder="Blood Sugar Post Prandial :  *" >
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p>mg%</p>
                </div>
            </div>
        </div>

        <!-- Urine Sugar Post Prandial : -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="uspp">Urine Sugar Post Prandial : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="usfp" type="text" name="uspp" class="form-control" placeholder="Urine Sugar Post Prandial :  *" >

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p></p>
                </div>
            </div>
        </div>

        <!-- Blood Sugar Post Prandial : -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="bsr">Blood Sugar Random : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="bsr" type="text" name="bsr" class="form-control" placeholder="Blood Sugar Random :  *">

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p>mg%</p>
                </div>
            </div>
        </div>

        <!-- Urine Sugar Random : -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="usr">Urine Sugar Random : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="usr" type="text" name="usr" class="form-control" placeholder="Urine Sugar Random :  *">

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p></p>
                </div>
            </div>
        </div>

        <!-- Blood Urea -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="bloodurea">Blood Urea (Dam Method) : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="bloodurea" type="text" name="bloodurea" class="form-control" placeholder="Blood Urea *" >

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p>mg%</p>
                </div>
            </div>
        </div>

        <!-- Serum Creatine-->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="serumcreatine">Serum Creatinine : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="serumcreatine" type="text" name="serumcreatine"
                    class="form-control" placeholder="Serum Creatinine *">

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p>mg%</p>
                </div>
            </div>
        </div>

        <!-- Serum Cholestrol-->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="serumcholestrol">Serum Cholestrol : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="serumcholestrol" type="text" name="serumcholestrol" class="form-control"
                    placeholder="Serum Cholestrol *" >

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p>mg%</p>
                </div>
            </div>
        </div>

        <!-- HDL-->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="hdl">H.D.L. : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="hdl" type="text" name="hdl" class="form-control"
                    placeholder="H.D.L. *" >

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p>mg%</p>
                </div>
            </div>
        </div>

        <!-- Serum Tryglyceride-->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="serumtry">Serum Trygliycerides : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="serumtry" type="text" name="serumtry" class="form-control"
                    placeholder="Serum Trygliycerides *">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p>mg%</p>
                </div>
            </div>
        </div>

        <!-- Serum Uric Acid-->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="serumuricacid">Serum Uric Acid : </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input id="serumuricacid" type="text" name="serumuricacid" class="form-control"
                    placeholder="Serum Uric Acid *">

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <p>mg%</p>
                </div>
            </div>
        </div>

        <div class="row">
          <div class="col-md-6">

          </div>
          <div class="col-md-3 col-md-offset-4">
              <br>
              <input type="submit" id ="addformbtn" disabled="disabled" class="btn btn-warning btn-send" value="Save">
          </div>
        </div>

      </form>
    </div>
  </div>


  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- Key Events JS -->
  <script src="../js/bloodgroup.js"></script>
  <!-- Jquery UI -->
  <script src="../js/jquery-ui.min.js"></script>
  <!-- custom jquery for patient search and add patient form -->
  <script src="../js/addcontact.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">

    //blood chemistry form validation
    $(document).ready(function () {
      // show patient form

      //alert("hello");

      $( "#pathology-form" ).validate({
        rules: {
          bsf: "required"
        },
        messages: {

          bsf: {
            required: "Blood Sugar Fasting is required",
            minlength: "must consist of at least 2 digit numbers"
          }
        },

        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `invalid-feedback` class to the error element
          error.addClass( "invalid-feedback" );

          if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.next( "label" ) );
          } else {
            error.insertAfter( element );
          }
        },

        highlight: function ( element, errorClass, validClass ) {
          $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
      });

    });
  </script>
</body>
</html>
