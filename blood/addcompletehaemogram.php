<?php
//initialize Medoo DB
require '../inc/db.init.php';

$home_link = "/pathoapp/";
$report_link = "completehaemogram";

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
  <link rel="stylesheet" href="../css/bootstrap-tokenfield.min.css">
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
    <br>
    <!-- Pathology form -->
    <div id="report-form" style="display: block;">
      <form id="pathology-form" method="post" action="insert<?= $report_link?>.php" role="form">
        <!-- Patient Doctor Fields -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <br>
                  Ref By :<br>
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
            </div>
        </div>
        <!-- tec Total Erythrocyte Count: -->
        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="tec"><b>Total Erythrocyte Count:</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="tec" type="text" name="tec" class="form-control" placeholder="Total *"  >
                </div>
            </div>
            <div class="col-sm-6 text-center mx-auto">
                <div class="form-group">
                    <p><b>DIFFERENTIAL LEUCOCYTE COUNT</b></p>
                </div>
            </div>
        </div>
        <!-- heamoglobin Haemoglobin: -->
        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="heamoglobin"><b>Haemoglobin (gm %):</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="heamoglobin" type="text" name="heamoglobin" class="form-control" placeholder="Heamoglobin *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="neutrophils"><b>Neutrophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="neutrophils" type="text" name="neutrophils" class="form-control" placeholder="Neutrophils *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>
        <!-- pcv P.C.V (%): -->
        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="pcv"><b>P.C.V (%):</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="pcv" type="text" name="pcv" class="form-control" placeholder="P.C.V  *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="lymphocytes"><b>Lymphocytes</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="lymphocytes" type="text" name="lymphocytes" class="form-control" placeholder="Lymphocytes *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>
        <!-- mcv M.C.V. (femolitres): -->
        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="mcv"><b>M.C.V. (femolitres):</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="mcv" type="text" name="mcv" class="form-control" placeholder="M.C.V. *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="eisnophils"><b>Eisnophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="eisnophils" type="text" name="eisnophils" class="form-control" placeholder="Eisnophils *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="mch"><b>M.C.H. (picograms):</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="mch" type="text" name="mch" class="form-control" placeholder="M.C.H. *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="monocytes"><b>Monocytes</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="monocytes" type="text" name="monocytes" class="form-control" placeholder="Monocytes *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="mchc"><b>M.C.H.C. (%):</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="mchc" type="text" name="mchc" class="form-control" placeholder="M.C.H.C. *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="basophils"><b>Basophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="basophils" type="text" name="basophils" class="form-control" placeholder="Basophils *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="reticculolytes"><b>Reticculolytes (%):</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="reticculolytes" type="text" name="reticculolytes" class="form-control" placeholder="Reticculolytes *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">

                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group"></div>
            </div>
            <div class="col-sm-1 text-center mx-auto">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="tlc"><b>Total Leucocytes count :</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="tlc" type="text" name="tlc" class="form-control" placeholder="Total Leucocytes count *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="immaturecells"><b>Immature cells</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="immaturecells" type="text" name="immaturecells" class="form-control" placeholder="Immature cells *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">

            </div>
            <div class="col-sm-2">
                <div class="form-group">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="platletscount"><b>Platlets Count</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="platletscount" type="text" name="platletscount" class="form-control" placeholder="Platlets Count *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="esr"><b>E.S.R. (westergren) :</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="esr" type="text" name="esr" class="form-control" placeholder="E.S.R. *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="parasites"><b>Parasites (MP)</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                  <select id="parasites" name="parasites"  class="form-control" >
                    <option value="0">NOT SEEN</option>
                    <option value="1">SEEN</option>
                  </select>
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="esr"><b>ESR :</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="esr" type="text" name="esr" class="form-control" placeholder="E.S.R. *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="bleedingtime"><b>Bleeding Time</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="bleedingtime" type="text" name="bleedingtime" class="form-control" placeholder="Bleeding Time *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="ppd"><b>P.P.D. Test :</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="ppd" type="text" name="ppd" class="form-control" placeholder="P.P.D. *"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="clottingtime"><b>Clotting Time</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="clottingtime" type="text" name="clottingtime" class="form-control" placeholder="Clotting Time *"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
            </div>
        </div>
        <br><br>
        <div class="row">

            <div class="col-md-4 text-center">
            </div>
            <div class="col-md-8 text-center">
                <input type="submit" id ="addformbtn" disabled="disabled" class="btn btn-warning btn-send" value="Save">
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <p class="text-muted"><strong>*</strong> These fields are required.</p>
          </div>
        </div>

    </div>
  </div>


  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>

  <!-- add contact -->
  <script src="../js/addcontact.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">
  //jQuery('#datetimepicker_start').datetimepicker();
  //alert('hello');
  $(function(){
      $( "#pathology-form" ).validate({
				rules: {
          tec: "required",
          heamoglobin : "required",
          pcv : "required",
          mcv : "required",

				},
				messages: {
					tec: {
						required: "Total Erythrocyte Count: ",
						minlength: "Total Erythrocyte Count count must consist of at least 2 characters"
					},

          heamoglobin : {
						required: "Please enter the heamoglobin count",
						minlength: "must consist of at least 1 characters"
					},
          pcv : {
						required: "Please enter the P.C.V (%): ",
						minlength: "must consist of at least 1 characters"
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
