<?php
require '../inc/db.init.php';

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

$report_link = "bloodsugarbiochemistry";
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

    <div class="row text-center mx-auto ">
      <div class="col-12 text-center mx-auto ">
        <h4 class="display-5 report-header">BLOOD SUGAR BIOCHEMISTRY</h4>
      </div>
    </div>

    <!-- Pathology form -->
    <div id="main-form" style="display: block;">
      <form id="pathology-form" method="post" action="insertbloodsugarbiochemistry.php" role="form">
          <div class="messages"></div>

          <div class="controls">
              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          <br><br>
                          <label for="ref" >Ref by : </label>

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
                          <input type="hidden" id="patient-id" type="text" name="pid"  />
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <p></p>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="bsf" >Blood Sugar Fasting : </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <input id="bsf" type="text" name="bsf" class="form-control"
                          placeholder="Blood Sugar Fasting *" >
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <p>Reference Value 65-100 mg%</p>
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="usf">Urine Sugar Fasting : </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <input id="usf" type="text" name="usf" class="form-control"
                          placeholder="Urine Sugar Fasting *" >
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <p>mg%</p>
                      </div>
                  </div>
              </div>
              <!-- Blood Sugar Post Prandial : -->
              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="bsfp">Blood Sugar Post Prandial : </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <input id="bsfp" type="text" name="bspp"
                          class="form-control" placeholder="Blood Sugar Post Prandial :  *">
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <p></p>
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="usfp">Urine Sugar Post Prandial : </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <input id="usfp" type="text" name="uspp" class="form-control"
                          placeholder="Urine Sugar Post Prandial :  *">
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <p></p>
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="bsfr">Blood Sugar Post Random : </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <input id="bsfr" type="text" name="bspr" class="form-control"
                          placeholder="Blood Sugar Post Random :  *" >
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <p></p>
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="usfr">Urine Sugar Post Random : </label>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <input id="usfr" type="text" name="uspr" class="form-control"
                          placeholder="Urine Sugar Post Random :  *">
                          <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <p></p>
                      </div>
                  </div>
              </div>

          </div>
          <div class="clearfix"></div>

          <div class="row">
              <div class="col-md-12">
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

    <!-- jQuery CDN - min version -->
    <script src="../js/jquery-3.5.1.min.js"></script>
    <!-- Popper.JS -->
    <script src="../js/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../js/bloodgroup.js"></script>

    <script src="../js/addcontact.js"></script>
    <!-- jQuery Validation -->
    <script src="../js/jquery.validate.js"></script>

    <script type="text/javascript">
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
