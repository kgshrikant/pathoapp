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
}

$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "LIPID PROFILE";
$report_link = "lipidprofile";

if($_SERVER["REQUEST_METHOD"] == "GET") {

  // get id details from report table
   $rid = $_GET['rid'];
   $data_report = $database->get("report",
   ["class_id"],
   ["class_type" => "{$report_link}", "rid" => "{$rid}" ]);

   $id = $data_report["class_id"];
   //echo $id;
  //search semen table with id

    $data_bc = $database->get("{$report_link}",
    ["pid","drid","ldl","hdl","serumc","serumt", "create_date"],
    ["id" => $id ]);

    $pid = $data_bc['pid'];
    $drid = $data_bc['drid'];
    $ldl = $data_bc['ldl'];
    $hdl = $data_bc['hdl'];
    $serumc = $data_bc['serumc'];
    $serumt = $data_bc['serumt'];

    $error_db = $database->error() ;
    //var_dump($error_db);
    $report_create_date = date("d/m/Y",strtotime($data_bc['create_date']));

    $data_patient = $database->get("patient",
    ["pid","firstname","surname","sex","age","initials"],
    ["pid" => $pid ]);

    $initials = $data_patient['initials'];
    $firstname = $data_patient['firstname'];
    $surname = $data_patient['surname'];
    $sex = $data_patient['sex'];
    $age = $data_patient['age'];
    $patient_details = "initials: " . $initials. ", Name: " . $firstname. " " . $surname. ", sex: ". $sex. ", age: ".$age;

    if($sex == "MALE"){
      $sex_code = "mars";
    }else {
      $sex_code = "venus";
    }
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
  </style>
</head>

<body>

    <div class="container">
      <div class="row">
        <div class="col-1 offset-1">
          <a href="http://localhost/pathoapp/" class="btn">
            <i class="fas fa-home" style="font-size: 45px;" ></i></a>
        </div>
        <div class="col-6">
          <div class="input-group margin-bottom-sm" style="margin-top:9px; padding: 5px; float:left; ">
            <input class="form-control" id="patient-search" type="text" placeholder="Search Patients .." >
            <div class="input-group-btn" >
              <button class="btn btn-warning" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="col-3">
            <a class="btn" id="btn-show-patient-form" href="#">
            <i class="fas fa-user-plus" style="font-size:45px; color: black;"></i> </a>
            <a class="btn" id="btn-list" href="#">
            <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
        </div>
      </div>
      <div class="line"></div>

      <!-- display patient details on saving patients details -->
      <!-- Patient Details -->
      <div class="row mx-auto" style="padding:10px;">
        <div class="col-sm-1.5  text-left" style="margin-left:20px;">
            Patient Name
        </div>
        <div class="col-sm-8 text-left">
          :&nbsp&nbsp<b><?php echo $initials." ".$firstname." ".$surname;  ?></b>
        </div>
      </div>

      <div class="row mx-auto" style="padding:10px;">
        <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
          Age / Gender
        </div>
        <div class="col-sm-8 text-left ">
          :&nbsp&nbsp<b><?= $age; ?></b> Year(s) / <b><?= $sex; ?></b>
          <i class="fas fa-<?= $sex_code ?>" style="font-size:20px; color:red; padding:3px"></i>
        </div>
      </div>

      <!-- Report Details -->
      <div class="row mx-auto" style="padding:10px;">
        <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
          Report id &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </div>
        <div class="col-sm-4 text-left">
            :&nbsp <b><?= sprintf("%07d", $rid)?></b>
        </div>
        <div class="col-sm-4 text-left">
        </div>
        <div class="col-sm-8.5 text-right">
            Report Date :<b> <?= $report_create_date ?> </b>
        </div>
      </div>

      <!-- Pathology form -->
      <div id="pathology" style="display: block; padding: 20px;">
        <form id="pathology-form" method="post" action="update<?= $report_link ?>.php" role="form">
          <!-- Partient Doctor Fields -->
          <div class="row">
            <div class="col-2.5">
              <div class="form-group">
                <label for="drid">Referred By : </label>
                <select id="drid" name="drid"  class="form-control" >
                  <?php
                  foreach($doctor_arr as $doctor){
                     if($doctor['drid'] == $drid){
                       echo "<option value='".$doctor['drid']."' selected>".$doctor['fullname']."</option>";
                     }
                     else {
                       echo "<option value='".$doctor['drid']."'>".$doctor['fullname']."</option>";
                     }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-2">
              <div class="form-group">
                <!--<input type="hidden" id="doctor-id" type="text" name="drid" value="1"  /> -->

                <input type="hidden" type="text" value="<?= $id ?>" name="id"  />
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
                data-error="name is required." value="<?= $ldl ?>">
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
                data-error="name is required." value="<?= $hdl ?>">
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
                placeholder="Serum Cholestrol : *"  data-error="name is required." value="<?= $serumc ?>">
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
                placeholder="Serum Tryglyceride : *"  data-error="name is required." value="<?= $serumt ?>">
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
                <input type="submit" class="btn btn-warning btn-send" value="Save">
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
          spermcount: "required",
          active : "required",

				},
				messages: {
					spermcount: {
						required: "Please enter the sperm count",
						minlength: "Your sperm count must consist of at least 2 characters"
					},

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
