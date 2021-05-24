<?php

require '../inc/db.init.php';
//form fields

$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "LIPID PROFILE";
$report_link = "lipidprofile";

//initializing variables
$pid = "";
$drid = "";

$report_id = "";
$message_result = "";
$report_create_date = date("d/m/Y");

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
  ["class_id","class"],
  ["class_type" => "{$report_link}", "rid" => "{$rid}" ]);

  $id = $data_report["class_id"];
  $class = $data_report["class"];
  //echo $id;
  //search semen table with id

  $data_bc = $database->get("{$report_link}",
  ["pid","drid","ldl","hdl","serumc","serumt", ],
  ["id" => $id ]);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $ldl = $data_bc['ldl'];
  $hdl = $data_bc['hdl'];
  $serumc = $data_bc['serumc'];
  $serumt = $data_bc['serumt'];

  $error_db = $database->error() ;
  //var_dump($error_db);

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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/bootstrap.min.css" >
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/all.css" >
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <title><?= $rid ?> PATHOLOGY REPORT  <?php echo $initials." ".$firstname." ".$surname;  ?></title>
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
      border-radius: 2px;
      padding: 5px;
      margin-top:10px;
    }
    .field{
      margin-left: 50px;
    }

  </style>
<body>

    <div class="container" style="">
      <div class="d-print-none">
        <a href="#" class="" role="button" onclick=" window.history.back();">
          <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
          <a href="/pathoapp" role="button">
            <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
          <a href="/pathoapp/<?= $class ?>/add<?= $report_link?>.php" class="" role="button">
            <i class='fas fa-plus' style='font-size:30px;color:green'></i></a>
          <button  onclick="window.print();">
            <i class="fas fa-print" style="font-size:30px;"></i></button>
          <a href="edit<?= $report_link?>.php?rid=<?= $rid ?>" role="button">
            <i class="fas fa-edit": style="font-size:30px;"></i></a>
          <a href="/pathoapp/listreport.php?type=<?= $report_link?>" role="button">
            <i class="fas fa-list": style="font-size:30px; color:green;"></i></a>
      </div>

      <?php include '../inc/printheader.php' ; ?>

      <!-- Debugging id and date -->
      <!-- Header -->
      <?php include '../inc/view-patient-details.php' ; ?>
      <br>

      <!-- Columns -->
      <div class="row text-center pathology-form">
        <div class="col-3 text-center mx-auto column_header" >
            <b>TEST DESCRIPTION</b>
        </div>
        <div class="col-3 text-center mx-auto column_header" >
            <b>RESULT</b>
        </div>
        <div class="col-3 text-center mx-auto column_header">
            <b>UNITS</b>
        </div>
        <div class="col-3 text-center mx-auto column_header">
            <b>REFERENCES</b>
        </div>
      </div>

      <!--LDL -->
      <div class="row pathology-form mt-3">
        <div class="col-3 text-center" >
          <p><b>LDL</b></p>
        </div>
        <div class="col-3 text-center">
          <p class="form-values">
            <?php echo ($ldl>90 && $ldl<170)?  $ldl : '<b class="abnormal;">'.$ldl.'</b>' ;?></p>
        </div>
        <div class="col-3 text-center">
          <div class="">
            mg/dl
          </div>
        </div>
        <div class="col-2 offset-1">
          <div class="">
            <p>[90-170]</p>
          </div>
        </div>
      </div>

      <!--HDL -->
      <div class="row pathology-form mt-2">
        <div class="col-3 text-center" >
          <p ><b>HDL</b></p>
        </div>
        <div class="col-3 text-center">
          <p class="form-values"><?php
          echo ($hdl>30 && $hdl<70)?  $hdl : "<b class='abnormal'>".$hdl."</b>" ;
          ?></p>
        </div>
        <div class="col-3 text-center">
          <div class="">
            mg/dl
          </div>
        </div>
        <div class="col-2 offset-1">
          <div class="">
            <p>[30-70]</p>
          </div>
        </div>
      </div>

      <!--Serum Cholesterol  -->
      <div class="row pathology-form mt-2">
        <div class="col-3 text-center" >
          <p><b>Serum Cholesterol</b></p>
        </div>
        <div class="col-3 text-center">
          <p class="form-values">
            <?php echo ($serumc>150 && $serumc<250)?  $serumc : '<b class="abnormal">'.$serumc.'</b>' ;?>
          </p>
        </div>
        <div class="col-3 text-center">
          <div class="">
            mg/dl
          </div>
        </div>
        <div class="col-2 offset-1">
          <div class="">
            <p>[150-250]</p>
          </div>
        </div>
      </div>

      <!--Serum Cholesterol  -->
      <div class="row pathology-form mt-2">
        <div class="col-3 text-center" >
          <p><b>Serum Trygliycerides</b></p>
        </div>
        <div class="col-3 text-center">
          <p class="form-values"><?php echo ($serumt>60 && $serumt<165)?
            $serumt : '<b class="abnormal">'.$serumt.'</b>' ;?></p>
        </div>
        <div class="col-3 text-center">
          <div class="">
            mg/dl
          </div>
        </div>
        <div class="col-2 offset-1">
          <div class="">
            <p>[60-165]</p>
          </div>
        </div>
      </div>


      <div class="row" style="position:relative; top:400px; margin:20px;">
        <div class="col-8 text-left mx-auto" >
          Report with thanks to <b> <?php echo $doctor_details ?> </b>
        </div>
        <div class="col-4 text-center mx-auto" style="margin-left:20px;" >
          <b>Pathologist</b>
          <p><b>DR.K. GOPINATH, MBBS DCP</b></p>
        </div>
      </div>

      <div class="row mx-auto " style="position:relative; top:400px ; margin:50px;">
        <p>This is an electronically authenticated report. Report Printed Date : <b> <?php echo date("d-m-Y") ?> </b></p>
        <p>NOTE : Assay results should be correlated clinically with other clinical findings and the total clinical status of the patient</p>
      </div>

  </div>

</body>
<script src="../js/jquery-3.3.1.slim.min.js" ></script>
<script src="../js/popper.min.js" ></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).keyup(function (e) {
  //alert(e.keyCode);
  switch (e.keyCode) {
    case 8:
      //window.location.href = 'http://localhost/pathoapp/urine/addsemen.php';
      break;
    case 76:
      window.location.href = 'http://localhost/pathoapp/listreport.php?type=<?= $report_link ?>';
      break;
    case 65:
      window.location.href = 'http://localhost/pathoapp/<?= $class ?>/add<?= $report_link ?>.php';
      break;
    case 69:
      window.location.href = 'http://localhost/pathoapp/<?= $class ?>/edit<?= $report_link ?>.php?rid=<?= $rid ?>';
      break;
    case 72:
      window.location.href = 'http://localhost/pathoapp/';
      break;
    case 80:
      window.print();
      break;
    case 13:
      window.print();
      break;
    case 27:
      //window.location.href = 'http://localhost/pathoapp/';
      break;
    }
  });
</script>

</body>
</html>
