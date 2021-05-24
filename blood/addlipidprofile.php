<?php
require '../inc/db.init.php';
$report_link = "lipidprofile";
$data_doctor = $database->select("doctor",
["drid","initials","firstname","surname"],
["drid[>]" => 0]
);

$doctor_arr = array();
foreach($data_doctor as $doctor) {
  $drid = $doctor["drid"];
  $fullname = $doctor['initials']." ".$doctor['firstname']." ".$doctor['surname'];
  $doctor_arr[] = array("drid" => $drid, "fullname" => $fullname);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>PATHOLAB</title>
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="../css/dashboard_style.css">
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <!-- Fontawesome -->
  <link rel="stylesheet" href="../css/all.css">

  <style media="screen">
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
    
    <!-- Pathology form -->
    <div id="pathology" style="display: block; padding: 20px;">
      <form id="pathology-form" method="post" action="insertlipidprofile.php" role="form">
        <!-- Partient Doctor Fields -->
        <div class="row">
          <div class="col-2.5">
            <div class="form-group">
              <label for="drid">Referred By : </label>
              <select id="drid" name="drid"  class="form-control" >
                <?php
                foreach($doctor_arr as $doctor){
                   echo "<option value='".$doctor['drid']."' >".$doctor['fullname']."</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <!--<input type="hidden" id="doctor-id" type="text" name="drid" value="1"  /> -->
              <input type="hidden" id="patient-id" type="text" name="pid"  />
            </div>
          </div>
        </div>
        <!-- Report Header -->
        <div class="row text-center mx-auto ">
          <div class="col-12 text-center mx-auto ">
            <h4 class="display-5 report-header">
              <b>LIPID PROFILE</b></h4>
          </div>
        </div>

        <div class="row text-center">
          <div class="col-sm-3 text-center mx-auto column-header" >
            <b>TEST DESCRIPTION</b>
          </div>
          <div class="col-sm-3 text-center mx-auto column-header" >
            <b>RESULT</b>
          </div>
          <div class="col-sm-3 text-center mx-auto column-header"
            <b>UNITS</b>
          </div>
          <div class="col-sm-3 text-center mx-auto column-header">
            <b>REFERENCE RANGES</b>
          </div>
        </div>

        <!--LDL -->
        <div class="row">
          <div class="col-3 text-center" >
            <label for="ldl"><b> LDL :</b> </label>
          </div>
          <div class="col-3">
            <div class="form-group">
              <input id="ldl" type="text" name="ldl" class="form-control" placeholder="LDL *"
              data-error="name is required.">
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="">
              mg/dl
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="">
              <p>[90-170]</p>
            </div>
          </div>
        </div>

        <!--HDL -->
        <div class="row">
          <div class="col-3 text-center" >
            <label for="hdl"><b> HDL :</b> </label>
          </div>
          <div class="col-3">
            <div class="form-group">
              <input id="hdl" type="text" name="hdl" class="form-control" placeholder="HDL *"
              data-error="name is required.">
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="">
              mg/dl
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="">
              <p>[30-70]</p>
            </div>
          </div>
        </div>

        <!-- Serum Cholestrol : -->
        <div class="row">
          <div class="col-3 text-center" >
            <label for="serumc"><b> Serum Cholestrol :</b> </label>
          </div>
          <div class="col-3">
            <div class="form-group">
              <input id="serumc" type="text" name="serumc" class="form-control"
              placeholder="Serum Cholestrol : *"  data-error="name is required.">
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="">
              mg/dl
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="">
              <p>[150-250]</p>
            </div>
          </div>
        </div>

        <!--HDL -->
        <!-- Serum Cholestrol : -->
        <div class="row">
          <div class="col-3 text-center" >
            <label for="serumt"><b> Serum Tryglyceride :</b> </label>
          </div>
          <div class="col-3">
            <div class="form-group">
              <input id="serumt" type="text" name="serumt" class="form-control"
              placeholder="Serum Tryglyceride : *"  data-error="name is required.">
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="">
              mg/dl
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="">
              <p>[150-250]</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 text-left">
          </div>
          <div class="col-md-6 text-left">
              <input type="submit" id ="addformbtn" disabled="disabled" class="btn btn-warning btn-send" value="Save">
          </div>
        </div>


        <div class="row">
          <div class="col-md-12">
            <p class="text-muted"><strong>*</strong> These fields are required.</p>
          </div>
        </div>

      </form>
    </div>
    </div>
  </div>

  <script src="../js/jquery-3.5.1.min.js"></script>

  <script src="../js/jquery-ui.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- Key Events JS -->
  <script src="../js/addcontact.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">
  //jQuery('#datetimepicker_start').datetimepicker();
  //alert('hello');
  $(function(){

    $( "#pathology-form" ).validate({
			rules: {
        ldl: "required",
        hdl : "required",
        serumc : "required",
        serumt : "required"

			},
			messages: {
        ldl: {
					required: "Please enter the ldl value",
					minlength: "Your value must consist of at least 2 characters"
				},
        hdl: {
          required: "Please enter the hdl count",
          minlength: "Your value must consist of at least 2 characters"
        },
        serumc: {
          required: "Please enter the Serum cholestrol count",
          minlength: "Your value must consist of at least 2 characters"
        },
        serumt: {
          required: "Please enter the Serum Tryglyceride count",
          minlength: "Your value must consist of at least 2 characters"
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
