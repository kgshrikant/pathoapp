<?php
require '../inc/db.init.php';
$report_link = "electrolyte";
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
  <!-- Google APIs -->
  <link rel="stylesheet" href="../css/all.css">
</head>
<style type="text/css">
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
<body>
  <div class="container">
  <!-- patient search page links and add Patient modal page -->
  <!-- patient details -->
  <?php include("../inc/search-add-patient.php"); ?>

  <div class="column-header mt-3 text-center heading-3" >
    <b>ELECTROLYTE TEST</b>
  </div>

    <!-- Pathology form -->
    <div id="main-form" style="display: block;">
      <form id="pathology-form" method="post" action="insertelectrolyte.php" role="form">
          <!-- Partient Doctor Fields -->
        <div class="row">
          <div class="col-sm-4 offset-sm-2">
            <div class="form-group">
              <br><br>
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
                <div class="form-group">
                    <input type="hidden" id="patient-id" type="text" name="pid" />
                </div>
            </div>
            <div class="col-sm-4">

            </div>
        </div>

        <div class="row">
          <div class="col-sm-4 text-right">
            <b>TEST:</b>
            <hr style="width:100%">
          </div>
          <div class="col-sm-2 text-center">
            <div class="form-group">
              <p><b>RESULT</b></p>
              <hr style="width:100%">
            </div>
          </div>
          <div class="col-sm-2 text-center">
            <div class="form-group">
              <p><b>NORMAL VALUE</b></p>
              <hr style="width:100%">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-4 text-right">
            <label for="sodium"><b>Na (Sodium)</b> </label>
          </div>
          <div class="col-sm-2 text-right">
            <div class="form-group">
              <input id="sodium" type="sodium" name="sodium" class="form-control" placeholder="Sodium *"  >
              <hr style="width:100%">
            </div>
          </div>
          <div class="col-sm-5 text-left mx-auto">
            <div class="form-group">
              <p><b>[135 to 155]</b></p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-4 text-right">
            <label for="potassium"><b>K (Potassium)</b> </label>
          </div>
          <div class="col-sm-2 text-right">
            <div class="form-group">
              <input id="potassium" type="text" name="potassium" class="form-control" placeholder="Potassium *"  >
              <hr style="width:100%">
            </div>
          </div>
          <div class="col-sm-5 text-left mx-auto">
            <div class="form-group">
              <p><b>[3.5 to 5.5]</b></p>
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="calcium"><b>Ca (Calcium) </b> </label>
            </div>
            <div class="col-sm-2 text-right">
              <div class="form-group">
                <input id="calcium" type="text" name="calcium" class="form-control" placeholder="Calcium *"  >
                <hr style="width:100%">
              </div>
            </div>
            <div class="col-sm-5 text-left mx-auto">
              <div class="form-group">
                <p><b>[1.10 to 1.35]</b></p>
              </div>
            </div>
        </div>

        <div class="row">
          <div class="col-md-4 text-center">
          </div>
          <div class="col-md-2 text-left">

          </div>
          <div class="col-md-5 text-left mx-auto">
            <input id ="addformbtn" disabled="disabled" type="submit" class="btn btn-warning btn-send" value="Save">
            <p class="text-muted"><strong>*</strong> These fields are required.</p>
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
  $(document).ready(function () {
    // show patient form

    //alert("hello");

    $( "#pathology-form" ).validate({
      rules: {
        sodium: "required",
        potassium: "required",
        calcium: "required"

      },
      messages: {

        sodium: {
          required: "sodium is required",
          minlength: "must consist of at least 1 digit numbers"
        },
        calcium: {
          required: "potassium is required",
          minlength: "must consist of at least 1 digit numbers"
        },
        potassium: {
          required: "calcium is required",
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
