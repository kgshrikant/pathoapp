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
//$testname = "SEMEN ANALYSIS";
$report_link = 'bloodchemistry';


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
  ["class_type" => "{$report_link}", "rid" => "{$rid}" ]);

  $id = $data_report["class_id"];
  //echo $id;
  //search semen table with id
  $data_bc = $database->get("bloodchemistry",
  ["pid","drid","bsf","usf","bspp","uspp","usf","bsr","usr",
  "bloodurea","serumcholestrol","hdl","serumuricacid","serumcreatine","serumtry","create_date"],
  ["id" => $id ]);

  $error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $bsf = $data_bc['bsf'];
  $usf = $data_bc['usf'];
  $bspp = $data_bc['bspp'];
  $uspp = $data_bc['uspp'];
  $bsr = $data_bc['bsr'];
  $usr = $data_bc['usr'];
  $bloodurea= $data_bc['bloodurea'];
  $serumcholestrol = $data_bc['serumcholestrol'];
  $serumcreatine = $data_bc['serumcreatine'];
  $hdl = $data_bc['hdl'];
  $serumuricacid = $data_bc['serumuricacid'];
  $serumtry = $data_bc['serumtry'];
  $report_create_date = date("d/m/Y",strtotime($data_bc['create_date']));
//  $report_create_date = date("d/m/Y",strtotime($data_bc['create_date']));

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

    <!-- Patient Details -->
    <div class="row mt-1">
        <div class="col-sm-12 text-center mx-auto ">
          <h5 class="heading"> <b>PATIENT DETAILS</b></h5>
        </div>
    </div>
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


    <!-- Pathology Form -->
    <div id="main-form" class="text-uppercase">
      <form id="pathology-form" method="post" action="updatebloodchemistry.php" role="form">
        <!-- Doctor Details -->
        <br>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              Ref By :
              <select id="drid" name="drid" class="form-control">
                <?php
                foreach($doctor_arr as $doctor){
                  if($doctor['drid'] == $drid){
                    echo "<option value='".$doctor['drid']."' selected>".$doctor['fullname']."</option>";
                  }else{
                    echo "<option value='".$doctor['drid']."' >".$doctor['fullname']."</option>";
                  }

                }
                ?>
              </select>
            </div>
          </div>

          <div class="col-sm-4">
              <input type="hidden" id="patient-id" type="text" name="id" value="<?= $id ?>" />
          </div>
          <div class="col-sm-4">
            <div class="form-group">
                <p></p>
            </div>
          </div>
        </div>

        <!-- Header -->
        <!--
        <div class="row text-center mx-auto ">
          <div class="col-12 text-center mx-auto ">
            <h4 class="display-5 report-header">BLOOD CHEMISTRY</h4>
          </div>
        </div>
        -->
        <!-- Blood Sugar Fasting : -->
        <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                  <label for="bsf" >Blood Sugar Fasting : </label>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                  <input id="bsf" type="text" value="<?= $bsf ?>" name="bsf" class="form-control" placeholder="Blood Sugar Fasting *" >

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
                    <input id="usf" type="text" value="<?= $usf ?>" name="usf" class="form-control" placeholder="Urine Sugar Fasting *" >

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
                    <input id="bspp" type="text" value="<?= $bspp ?>" name="bspp" class="form-control"
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
                    <input id="usfp" type="text" value="<?= $uspp ?>" name="uspp" class="form-control" placeholder="Urine Sugar Post Prandial :  *" >

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
                    <input id="bsr" type="text" value="<?= $bsr ?>" name="bsr" class="form-control" placeholder="Blood Sugar Random :  *">

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
                    <input id="usr" type="text" value="<?= $usr ?>" name="usr" class="form-control" placeholder="Urine Sugar Random :  *">

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
                    <input id="bloodurea" type="text" value="<?= $bloodurea ?>" name="bloodurea" class="form-control" placeholder="Blood Urea *" >

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
                    <input id="serumcreatine" value="<?= $serumcreatine ?>" type="text" name="serumcreatine"
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
                    <input id="serumcholestrol"  value="<?= $serumcholestrol ?>" type="text" name="serumcholestrol" class="form-control"
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
                    <input id="hdl" type="text" value="<?= $hdl ?>" name="hdl" class="form-control"
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
                    <input id="serumtry" type="text" value="<?= $serumtry ?>" name="serumtry" class="form-control"
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
                    <input id="serumuricacid" type="text" value="<?= $serumuricacid ?>" name="serumuricacid" class="form-control"
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
              <input type="submit" class="btn btn-warning btn-send" value="Save">
          </div>
        </div>

      </form>
    </div>
  </div>
  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>

  <script src="../js/jquery-ui.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- Key Events JS -->
  <!-- <script src="../js/addcontact.js"></script> -->
  <!-- Datepicker JS -->
  <script src="../js/jquery.simple-dtpicker.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">
  //jQuery('#datetimepicker_start').datetimepicker();
  //alert('hello');
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
