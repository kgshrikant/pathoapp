<?php

require '../inc/db.init.php';


$testname = "BLOODSUGAR BIOCHEMISTRY";
$report_link = 'bloodsugarbiochemistry';
$class_id = "";

$id="";
$rid = "";
$pid = "";
$drid = "";

$bsf = "";
$usf = "";
$bspp = "";
$uspp = "";
$bspr = "";
$uspr = "";

//patient DETAILS
$initials = "";
$firstname = "";
$patient_name = "";
$surname = "";
$sex = "";
$age = "";
$patient_details = "";

//dr DETAILS
$drinitials = "";
$drfirstname = "";
$drsurname = "";
$drqualification = "";
$doctor_details = "";
$fullname = "";

if($_SERVER["REQUEST_METHOD"] == "GET") {
  $rid = $_GET['rid'];
  //echo $rid;
  $data_report = $database->get("report",
  ["class_id"],
  ["class_type" => "bloodsugarbiochemistry", "rid" => "{$rid}" ]);

  $id = $data_report["class_id"];

  //search bloodchemistry table with id
  $data_bc = $database->get("bloodsugarbiochemistry",
  ["pid","drid","bsf","usf","bspp","uspp","uspr","bspr", "create_date"],
  ["id" => $id ]);
  
  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $bsf = $data_bc['bsf'];
  $usf = $data_bc['usf'];
  $bspp = $data_bc['bspp'];
  $uspp = $data_bc['uspp'];
  $bspr = $data_bc['bspr'];
  $uspr = $data_bc['uspr'];
  $create_date = $data_bc['create_date'];
  $report_create_date = date("d/m/Y",strtotime($data_bc['create_date']));


  $report_create_date = new DateTime($create_date);

  //echo "doctor id = ".  $db_drid;
  //patient detials
  $data_patient = $database->get("patient",
  ["pid","firstname","surname","sex","age","initials"],
  ["pid" => $pid ]);

  $initials = $data_patient['initials'];
  $firstname = $data_patient['firstname'];
  $surname = $data_patient['surname'];
  $sex = $data_patient['sex'];
  $age = $data_patient['age'];
  $patient_name = $data_patient['initials'].". ".$data_patient['firstname']." ".$data_patient['surname'];

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
  <!-- favicon css -->
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <!-- fontawesome css -->
  <link rel="stylesheet" href="../css/all.css">

  <style media="screen">
    .report_header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
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

    <div class="row">
      <div class="col-sm-12 text-center mx-auto ">
          <br><br>
          <h4 class="display-5 report_header" style=""><b><?= $testname ?></b></h4>
      </div>
      <br><br>
    </div>
    <div class="line"></div>

    <!-- patient details -->
    <div id="patient-details" style="display: block;">
      <div class="row text-center mx-auto ">
        <hr style="width:100%">
        <div class="col-3">
            Patient : <b><div id="patient-name"><?= $patient_name ?></div></b>
        </div>

        <div  class="col-3 text-center mx-auto ">
            Sex : <b><div id="patient-sex"><?= $sex ?></div></b>
        </div>

        <div class="col-3 text-center mx-auto">
            Age : <b><div id="patient-age"><?= $age ?></div></b>
        </div>
      </div>
    </div>

    <!-- Pathology form -->
    <div id="main-form" style="display: block;">
      <form id="pathology-form" method="post" action="updatebloodsugarbiochemistry.php" role="form">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <br><br>
              <label for="ref" >Ref by : </label>

              <select id="drid" name="drid" class="form-control">
                <?php
                foreach($doctor_arr as $doctor){
                  if($doctor['drid'] == $drid){
                    echo "<option value='".$doctor['drid']."' selected >".$doctor['fullname']."</option>";
                  }else {
                    echo "<option value='".$doctor['drid']."' >".$doctor['fullname']."</option>";
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
                <input type="hidden" id="class_type" type="text"
                  name="id" value="<?= $id?>"  />
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
                <p></p>
            </div>
          </div>
        </div>

        <!-- Blood Sugar Fasting : -->
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="bsf" >Blood Sugar Fasting : </label>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <input id="bsf" type="text" name="bsf" class="form-control"
              placeholder="Blood Sugar Fasting *" value="<?= $bsf ?>" >
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
              placeholder="Urine Sugar Fasting *" value="<?= $usf ?>">
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
                <label for="bspp">Blood Sugar Post Prandial : </label>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
                <input id="bspp" type="text" name="bspp"
                class="form-control" placeholder="Blood Sugar Post Prandial :  *"
                value="<?= $bspp ?>">
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
                <input id="uspp" type="text" name="uspp" class="form-control"
                placeholder="Urine Sugar Post Prandial :*" value="<?= $uspp ?>">
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
                <input id="bspr" type="text" name="bspr" class="form-control"
                placeholder="Blood Sugar Post Random : *" value="<?= $bspr ?>">
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
              <input id="uspr" type="text" name="uspr" class="form-control"
              placeholder="Urine Sugar Post Random :  *" value="<?= $uspr ?>">
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
          <div class="col-md-12">
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

  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/bloodgroup.js"></script>
  <script type="text/javascript">
  $(document).keyup(function (e) {
    //alert(e.keyCode);
    if (e.keyCode == 27) {
      window.location.href = 'http://localhost/pathoapp/';
    }else if(e.keyCode == 76) {
      window.location.href = 'http://localhost/pathoapp/listreport.php';
    }else if(e.keyCode == 65) {
      window.location.href = 'http://localhost/pathoapp/blood/addbloodgroup.php';
    }
  });
  </script>
</body>
</html>
