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

// initialzing variables
$home_link = "http://localhost/pathoapp/";
$testname = "COMPLETE HAEOMOGRAM";
$report_link = "completehaemogram";
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

  $data_bc = $database->get("completehaemogram",
  ["drid", "pid", "tec", "heamoglobin", "neutrophils", "pcv", "mcv", "mch",
	  "monocytes", "mchc", "basophils", "reticculolytes", "tlc", "immaturecells", "platletscount",
	  "esr", "parasites", "bleedingtime", "ppd", "clottingtime", "eisnophils"],
  ["id" => $id ]);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $tec = $data_bc['tec'];
  $heamoglobin = $data_bc['heamoglobin'];
  $neutrophils = $data_bc['neutrophils'];
  $pcv = $data_bc['pcv'];
  $mcv = $data_bc['mcv'];
  $mch = $data_bc['mch'];
  $monocytes= $data_bc['monocytes'];
  $mchc= $data_bc['mchc'];
  $basophils =  $data_bc['basophils'];
  $reticculolytes = $data_bc['reticculolytes'];
  $tlc = $data_bc['tlc'];
  $immaturecells = $data_bc['immaturecells'];
  $platletscount = $data_bc['platletscount'];
  $esr = $data_bc['esr'];
  $parasites = $data_bc['parasites'];
  $bleedingtime = $data_bc['bleedingtime'];
  $ppd= $data_bc['ppd'];
  $clottingtime =  $data_bc['clottingtime'];
  $eisnophils = $data_bc['eisnophils'];

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

  $data_doctor = $database->get("doctor",
  ["initials","firstname","surname","qualification"],
  ["drid" => $drid ]);

  $drinitials = $data_doctor['initials'];
  $drfirstname = $data_doctor['firstname'];
  $drsurname = $data_doctor['surname'];
  $drqualification = $data_doctor['qualification'];
  $doctor_details = $drinitials. "." . $drfirstname. " " . $drsurname. " ". $drqualification;

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
  <!-- Font Awesome JS -->
  <link rel="stylesheet" href="../css/all.css">

<style>
  #header-name{
    font: 60px bold Copperplate; color: #400e78;
    text-shadow: 2px 2px 5px #7f9fd4, 0 0 5px #b2b4b8;
  }
  #punch-line{
    font-family: 'Brush Script MT', cursive;
    font-style: normal;
    font-weight:800;
    color: red;
    font-size: 20px;
    text-align: right;
    margin-right: 200px;
  }
  #address{
    font-size:24px;
    color:red;
    padding:3px
  }
  #phone{
     style="padding:3px;
     font-size:24px;
     color:blue;"
  }
  .report_header{
    background-color: #a7a9ab;
    border-radius: 5px;
    padding: 5px;
  }
  .column_header {
    background-color: #a7a9ab;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;
  }
  .field{
    margin-left: 50px;
  }

</style>
</head>
<body>

  <div class="container">
    <div class="d-print-none">
      <a href="#" class="" role="button" onclick=" window.history.back();">
        <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
      <button  onclick="window.print();">
        <i class="fas fa-print" style="font-size:30px;"></i></button>
      <a href="editbloodchemistry.php?rid=<?= $rid ?>" role="button">
          <i class="fas fa-edit": style="font-size:30px;"></i></a>
      <a href="/pathoapp" role="button">
          <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
    </div>

    <!-- <div class="row">
      <div class="col-1 offset-1">
        <a href="<?$home_link ?>" class="btn">
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
    </div> -->

    <br>

    <!-- display patient details on saving patients details -->

      <div class="row mt-1">
        <div class="col-sm-12 text-center column_header ">
          <b>PATIENT DETAILS</b>
        </div>
        <br>
      </div>
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
    <div id="report-form" style="display: block;">
      <form id="pathology-form" method="post" action="update<?= $report_link?>.php" role="form">
        <!-- Patient Doctor Fields -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <br>
                  Ref By :<br>
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
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="hidden" id="patient-id" type="text" name="id" value="<?= $id ?>"/>
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
                    <input id="tec" type="text" name="tec" class="form-control"
                    placeholder="Total *" value="<?= $tec ?>" >
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
                    <input id="heamoglobin" type="text" name="heamoglobin" class="form-control"
                    placeholder="heamoglobin *" value="<?= $heamoglobin ?>" >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="neutrophils"><b>Neutrophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="neutrophils" type="text" name="neutrophils" class="form-control"
                    placeholder="heamoglobin *" value="<?= $neutrophils ?>" >
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
                    <input id="pcv" type="text" name="pcv" class="form-control"
                    placeholder="P.C.V  *" value="<?= $pcv ?>" >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="lymphocytes"><b>Lymphocytes</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="lymphocytes" type="text" name="neutrophils" class="form-control"
                    placeholder="Lymphocytes *" value="<?= $neutrophils ?>" >
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
                    <input id="mcv" type="text" name="mcv" class="form-control"
                    placeholder="M.C.V. *" value="<?= $mcv ?>" >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="eisnophils"><b>Eisnophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="eisnophils" type="text" name="eisnophils" class="form-control"
                    placeholder="Eisnophils *" value="<?= $eisnophils ?>" >
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
                    <input id="mch" type="text" name="mch" class="form-control"
                    placeholder="M.C.H. *" value="<?= $mch ?>" >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="monocytes"><b>Monocytes</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="monocytes" type="text" name="monocytes" class="form-control"
                    placeholder="Monocytes *" value="<?= $monocytes ?>" >
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
                    <input id="mchc" type="text" name="mchc" class="form-control"
                    placeholder="M.C.H.C. *" value="<?= $mchc ?>" >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="basophils"><b>Basophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="basophils" type="text" name="basophils" class="form-control"
                    placeholder="Basophils *" value="<?= $basophils ?>" >
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
                    <input id="reticculolytes" type="text" name="reticculolytes"
                    class="form-control" placeholder="Reticculolytes *" value="<?= $reticculolytes ?>" >
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
                    <input id="tlc" type="text" name="tlc" class="form-control"
                    placeholder="Total Leucocytes count *" value="<?= $tlc ?>" >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="immaturecells"><b>Immature cells</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="basophils" type="text" name="immaturecells"
                    class="form-control" placeholder="Immature cells *" value="<?= $immaturecells ?>" >
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
                    <input id="platletscount" type="text" name="platletscount" class="form-control"
                    placeholder="Platlets Count *" value="<?= $platletscount ?>"  >
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
                    <input id="esr" type="text" name="esr" class="form-control"
                    placeholder="E.S.R. *" value="<?= $parasites ?>" >
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
                    <option value="0"<?php if($parasites == '0') echo 'selected' ?>>NOT SEEN</option>
                    <option value="1" <?php if($parasites == '1') echo 'selected' ?>>SEEN</option>
                  </select>

                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="sickling"><b>Sickling :</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="esr" type="text" name="esr" class="form-control"
                    placeholder="E.S.R. *" value="<?= $esr ?>" >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="bleedingtime"><b>Bleeding Time</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="bleedingtime" type="text" name="bleedingtime" class="form-control"
                    placeholder="Bleeding Time *" value="<?= $bleedingtime ?>"  >
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
                    <input id="ppd" type="text" name="ppd" class="form-control"
                    placeholder="P.P.D. *" value="<?= $ppd ?>"  >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="clottingtime"><b>Clotting Time</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="clottingtime" type="text" name="clottingtime" class="form-control"
                    placeholder="Clotting Time *" value="<?= $clottingtime ?>"  >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
            </div>
        </div>

        <div class="row">
            <br><br>
            <div class="col-md-6 text-center">
            </div>
            <div class="col-md-6 text-right">
                <input type="submit" class="btn btn-warning btn-send" value="Save">
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
          haemoglobin : "required",
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
