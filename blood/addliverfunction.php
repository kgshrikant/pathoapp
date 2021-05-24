<?php
require '../inc/db.init.php';
$report_link = "liverfunction";
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
  <!-- Fontawesome -->
  <link rel="stylesheet" href="../css/all.css">
  <!-- Bootstrap Tokenfield -->
  <link rel="stylesheet" href="../css/jquery-ui.css">

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
  </style>
</head>

<body>

  <div class="container">

    <!-- patient search page links and add Patient modal page -->
    <!-- patient details -->
    <?php include("../inc/search-add-patient.php"); ?>

    <div class="row mt-3">
      <div class="col-sm-12 text-center mx-auto ">
        <h4 class="display-5 report_header heading" style=""><b>LIVER FUNCTION TEST</b></h4>
      </div>
    </div>
        <!-- Pathology form -->
    <div id="pathology" style="d-block; padding: 20px;">
      <form id="pathology-form" method="post" action="insertliverfunction.php" role="form">
        <!-- Partient Doctor Fields -->
        <div class="row">
          <div class="col-sm-3 offset-sm-2">
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
          </div>
          <div class="col-sm-2">
            <div class="form-group">
                <!--<input type="hidden" id="doctor-id" type="text" name="drid" value="1"  /> -->
              <input type="hidden" id="patient-id" type="text" name="pid"  />
            </div>
          </div>


          <div class="row">
            <div class="col-sm-4 text-right">
              <b>SERUM BILIRUBIN:</b>
            </div>
            <div class="col-sm-4">
              <div class="form-group">

              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                  <p>NORMAL</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="sbt">Total </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                  <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <input id="sbt" type="text" name="sbt" class="form-control" placeholder="Total *"     >
                  <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group">
                <p>Upto 1.0 mg/dl</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="conjugated">Conjugated </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <input id="total" type="text" name="conjugated" class="form-control" placeholder="Conjugated *" >
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
                <div class="form-group">
                    <p>Upto 0.6 mg/dl</p>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
                <label for="unconjugated">Unconjugated </label>
            </div>
            <div class="col-sm-2 text-center">
                <div class="form-group">
                    <b>:</b>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="unconjugated" type="text" name="unconjugated" class="form-control"
                    placeholder="Unconjugated *" >
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-4 text-left">
                <div class="form-group">
                    <p>Upto 0.4 mg/dl</p>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <b>SERUM PROTEINS:</b>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <br>
              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                <p></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="spt">Total </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <input id="spt" type="text" name="spt" class="form-control" placeholder="Total *" >
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group">
                <p>6.0 to 8.0 mg/dl</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="albumin">Albumin </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                  <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <input id="albumin" type="text" name="albumin" class="form-control" placeholder="Albumin *" >
                  <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group">
                  <p>3.5 to 5.5 mg/dl</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="globulin">Globulin </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <input id="globulin" type="text" name="globulin" class="form-control" placeholder="Globulin *" >
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
                <div class="form-group">
                  <p>1.5 to 3.0 mg/dl</p>
                </div>
            </div>
          </div>

          <div class="row">
              <div class="col-sm-2 text-center">
              </div>
              <div class="col-sm-2 text-left">
                <label for="sgot"><b>SGOT</b> </label>
              </div>
              <div class="col-sm-2 text-center">
                <div class="form-group">
                    <b>:</b>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group ">
                  <input id="sgot" type="text" name="sgot" class="form-control" placeholder="SGOT *">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-sm-4 text-left mx-auto">
                <div class="form-group">
                <p> 5 to 40 units/ml</p>
                </div>
              </div>
          </div>

          <div class="row">
            <div class="col-sm-2 text-center">
            </div>
            <div class="col-sm-2 text-left">
              <label for="sgpt"><b>SGPT</b> </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                  <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <input id="sgpt" type="text" name="sgpt" class="form-control" placeholder="SGPT *" >
                  <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                  <p> 5 to 35 units/ml</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="sap"><b>SERUM ALKALINE PHOSPHATE</b></label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                  <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <input id="sap" type="text" name="sap" class="form-control" placeholder="SERUM ALKALINE PHOSPHATE *" >
                  <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                  <p> 4 to 11 KA units</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
                <label for="hbsag"><b>Hbs Ag Australia Antigen</b></label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <input id="hbsag" type="text" name="hbsag" class="form-control" placeholder="Hbs Ag *" >
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                <p> </p>
              </div>
            </div>
          </div>
          <br><br>

          <div class="row">
            <div class="col-md-6 text-center">
            </div>
            <div class="col-md-6 text-left">
              <input type="submit" id ="addformbtn" disabled="disabled"  class="btn btn-warning btn-send" value="Save">
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


  <script src="../js/jquery-3.5.1.min.js"></script>

  <script src="../js/jquery-ui.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- Key Events JS -->
  <script src="../js/addcontact.js"></script>

  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">
  //jQuery('#datetimepicker_start').datetimepicker();
  //alert('hello');
  $(function(){

    $( "#pathology-form" ).validate({
      rules: {
        sbt: "required",
        conjugated : "required",
        unconjugated : "required",
        spt: "required",
        globulin : "required",
        albumin: "required"
      },
      messages: {

        conjugated : {
          required: "Please enter the conjugated value",
          minlength: "must consist of at least 2 characters"
        },
        unconjugated : {
          required: "Please enter the unconjugated count",
          minlength: "must consist of at least 2 characters"
        },
        spt : {
          required: "Please enter the Serum Proteins",
          minlength: "must consist of at least 2 characters"
        },
        sbt : {
          required: "Please enter the Serum Bilirubin",
          minlength: "must consist of at least 2 characters"
        },
        albumin : {
          required: "Please enter the albumin value",
          minlength: "must consist of at least 2 characters"
        },
        puscells: {
          globulin: "Please enter the globulin value",
          minlength: "must consist of at least 2 characters"
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
