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

$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "SEMEN ANALYSIS";
$report_link = 'semen';

$pid = "";
$drid = "";
$time_start = "";
$time_end = "";
$volume = "";
$consistency = "";
$colour = "";
$odour = "";
$spermcount = "";
$active= "";
$sluggish = "";
$dead = "";
$morpohology = "";
$puscells = "";
$epcells = "";
$rbc = "";
$report_create_date = "";

$class_id = "";
$message_result = "";

// patient details
$initials =  "";
$firstname =  "";
$surname =  "";
$sex =  "";
$age =  "";
$patient_details =  "";

//dr details
$drinitials = '';
$drfirstname = '';
$drsurname = '';
$drqualification = '';
$doctor_details = '';

$report_create_date = date("Y/m/d");

if($_SERVER["REQUEST_METHOD"] == "GET") {

  // get id details from report table
   $rid = $_GET['rid'];
   $data_report = $database->get("report",
   ["class_id"],
   ["class_type" => "semen", "rid" => "{$rid}" ]);

   $id = $data_report["class_id"];
   //echo $id;
  //search semen table with id
  $data_bc = $database->get("semen",
  ["pid","drid","time_start","time_end","volume","consistency","colour","odour","spermcount",
  "active","sluggish","dead","morpohology","puscells","epcells", "create_date","rbc"],
  ["id" => $id ]);

  $error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $time_start = $data_bc['time_start'];
  $time_end = $data_bc['time_end'];
  $volume = $data_bc['volume'];
  $consistency = $data_bc['consistency'];
  $colour = $data_bc['colour'];
  $odour = $data_bc['odour'];
  $spermcount = $data_bc['spermcount'];
  $active= $data_bc['active'];
  $sluggish = $data_bc['sluggish'];
  $dead = $data_bc['dead'];
  $morpohology = $data_bc['morpohology'];
  $puscells = $data_bc['puscells'];
  $epcells = $data_bc['epcells'];
  $rbc = $data_bc['rbc'];
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
  <!-- fontawesome APIs -->
  <link rel="stylesheet" href="../css/all.css">
  <!-- datetimepicker APIs -->
  <link rel="stylesheet" href="../css/jquery-ui.css">

  <link rel="stylesheet" href="../css/jquery.simple-dtpicker.css"/ >

  <style>
    .heading{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .upper{
      text-transform: uppercase;

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


    <!-- patient details -->
    <!--<div id="patient-details" class="border border-dark rounded"
    style="display: block; padding:20px;">
      <div class="row text-center mx-auto ">
        <div class="col-sm-12 text-center mx-auto ">
          <h5 class="heading"> <b>PATIENT DETAILS</b></h5>

        </div>
      </div>
      <div class="row text-center mx-auto ">

          <div class="col-3">
              Patient : <b><div id="patient-name"></div></b>
          </div>
          <div  class="col-3 text-center mx-auto ">
              Sex : <b><div id="patient-sex"></div></b>
          </div>
          <div class="col-3 text-center mx-auto">
              Age : <b><div id="patient-age"></div></b>
          </div>
      </div>
    </div>
    -->

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


    <div id="main-form" style="display: block;">
      <form id="pathology-form" method="post" action="updatesemen.php" role="form">
        <div class="messages"></div>
        <br><br>
        <!-- Physical Examination -->
        <div class="row mt-1">
            <div class="col-sm-12 text-center mx-auto ">
              <h5 class="heading"> <b>SEMINAL FLUID</b></h5>
            </div>
        </div>
        <!-- Columns -->
        <div class="row">
          <div class="col-sm-3 text-center mx-auto" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>TEST DESCRIPTION</b>
          </div>
          <div class="col-sm-3 text-center mx-auto" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>RESULT</b>
          </div>
          <div class="col-sm-3 text-center mx-auto" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>UNITS</b>
          </div>
          <div class="col-sm-3 text-center mx-auto" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>BIOLOGICAL REFERENCE </b>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              Ref By :
              <select id="drid" name="drid" class="form-control">
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
              <input type="hidden" id="patient-id" type="text" value="<?= $id ?>" name="id"  />
          </div>
          <div class="col-2">
          </div>
        </div>
        <br>

        <!-- Collection Time Start datetimepicker_start -->
        <div class="row ">
          <label for="time_start" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">Collection Time Start</label>

          <div class="col-3">
            <div class="form-group" >
              <input id="datetimepicker_start" type="text" name="time_start" value="<?= $time_start ?>" class="form-control">
            </div>
          </div>
        </div>

        <!-- Collection Time End datetimepicker_end -->
        <div class="row ">
          <label for="time_end" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">Collection Time End</label>

          <div class="col-3">
            <div class="form-group" >
              <input id="datetimepicker_end" type="text" name="time_end" value="<?= $time_end ?>" class="form-control">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3 text-left" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>GROSS EXAMINATION</b>
          </div>
        </div>

        <!-- semen volume -->
        <div class="row ">
          <label for="volume" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">Volume</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="volume" type="text" name="volume" value="<?= $volume ?>"  class="form-control" value="2">
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              ml
            </div>
          </div>
        </div>

        <!-- consistency -->
        <div class="row ">
          <label for="consistency" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">Colour</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="consistency" name="consistency"  class="form-control" >
                <option value="VISCOUS">VISCOUS</option>
              </select>
            </div>
          </div>
        </div>

        <!-- colour -->
        <div class="row ">
          <label for="colour" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">Colour</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="colour" name="colour"  class="form-control" >
                <option value="MILKY">MILKY</option>
              </select>
            </div>
          </div>
        </div>

        <!-- odour -->
        <div class="row ">
          <label for="odour" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">Odour</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="odour" name="odour"  class="form-control" >
                <option value="FISHY">FISHY</option>
              </select>
            </div>
          </div>
        </div>

        <!-- duration -->
        <div class="row ">
          <div class="col-3">
            Liquid Faction Time
          </div>
          <div id="duration" class="col-3 text-center">
            00:30
          </div>
          <div class="col-sm-3 text-center">
            minutes
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm-3 text-left" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>MICROSCOPIC EXAMINATION</b>
          </div>
        </div>

        <!-- spermcount -->
        <div class="row">
          <label for="spermcount" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">SPERM COUNT</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="spermcount" type="text" value="<?= $spermcount ?>"  name="spermcount" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              millions / ml
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-3 text-left" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>SPERM MOTILITY EXAMINATION</b>
          </div>
        </div>

        <!-- active cells -->
        <div class="row">
          <label for="active" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">ACTIVE</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="active" type="text"  value="<?= $active ?>"  name="active" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              % (Active Motile)
            </div>
          </div>
          <div class="col-3 text-center">

          </div>
        </div>

        <!-- sluggish cells -->
        <div class="row">
          <label for="sluggish" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">SLUGGISH</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="sluggish" type="text"  value="<?= $sluggish ?>"  name="sluggish" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              % (Sluggish Motile)
            </div>
          </div>
        </div>

        <!-- dead cells -->
        <div class="row">
          <label for="dead" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">DEAD</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="dead" type="text"  value="<?= $dead ?>"  name="dead" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              % (Active Motile)
            </div>
          </div>
        </div>

        <!-- morpohology cells -->
        <div class="row">
          <label for="morpohology" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">SPERM MORPOHOLOGY</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="morpohology" type="text"  value="<?= $morpohology ?>"  name="morpohology" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              % Normal
            </div>
          </div>
        </div>

        <!-- puscells cells -->
        <div class="row">
          <label for="puscells" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">Pus Cells</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="puscells" name="puscells"  value="<?= $puscells ?>"  type="text"  class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              /hpf
            </div>
          </div>
        </div>


        <!-- epcells cells -->
        <div class="row">
          <label for="epcells" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">EP Cells</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="epcells" name="epcells"  value="<?= $epcells ?>"  type="text"  class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              /hpf
            </div>
          </div>
        </div>

        <!-- rbc cells -->
        <div class="row">
          <label for="rbc" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">RBC</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="rbc" name="rbc"  value="<?= $rbc ?>"  type="text"  class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              /hpf
            </div>
          </div>
        </div>
        <br><br>
        <div class="row">
          <div class="col-md-8 text-right display-5">
            <input type="submit" class="btn btn-warning btn-send" value="Save">
          </div>
        </div>
    </form>
  </div>
  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>

  <script src="../js/jquery-ui.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- Key Events JS -->
  <script src="../js/addcontact.js"></script>
  <!-- Datepicker JS -->
  <script src="../js/jquery.simple-dtpicker.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">
  //jQuery('#datetimepicker_start').datetimepicker();
  //alert('hello');
  $(function(){
			$('#datetimepicker_start').appendDtpicker({
        //"dateFormat": "DD/MM/YYYY HH:mm TT"
      });
      $('#datetimepicker_end').appendDtpicker({
        //"dateFormat": "DD/MM/YYYY HH:mm TT"
      });

      $( "#datetimepicker_end" ).keyup(function() {
        var end_time = $(this).val();
        var start_time = $('#datetimepicker_start').val();
        var diff_ms = Math.abs(new Date(start_time) - new Date(end_time));
        var diff_mins = Math.floor((diff_ms/1000)/60);
        //alert (diff_mins);
        $('#duration').text(diff_mins);
      });

      $( "#pathology-form" ).validate({
				rules: {
          spermcount: "required",
          active : "required",
          sluggish : "required",
          dead : "required",
          morpohology : "required",
          puscells: "required"
				},
				messages: {
					spermcount: {
						required: "Please enter the sperm count",
						minlength: "Your sperm count must consist of at least 2 characters"
					},

          active : {
						required: "Please enter the active count",
						minlength: "must consist of at least 2 characters"
					},
          sluggish : {
						required: "Please enter the sluggish count",
						minlength: "must consist of at least 2 characters"
					},
          dead : {
						required: "Please enter the dead count",
						minlength: "must consist of at least 2 characters"
					},
          morpohology : {
						required: "Please enter the morpohology count",
						minlength: "must consist of at least 2 characters"
					},
          puscells: {
						required: "Please enter the puscells count",
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
