<?php

require '../inc/db.init.php';
//form fields

$report_id = "";
$report_create_date = "" ;

$message_result = "";
$testname = "BLOODSUGAR BIOCHEMISTRY";
$report_link = "bloodsugarbiochemistry";

$rid = "";
$pid = "";
$drid = "";
$bsf = "";
$usf = "";
$bspp = "";
$uspp = "";
$bspr = "";
$uspr = "";

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
   //echo $rid;
   $data_report = $database->get("report",
   ["class_id", "class"],
   ["class_type" => "bloodsugarbiochemistry", "rid" => "{$rid}" ]);

   $id = $data_report["class_id"];
   $class = $data_report["class"];

  //search bloodchemistry table with id
  $data_bc = $database->get("bloodsugarbiochemistry",
  ["pid","drid","bsf","usf","bspp","uspp","uspr","bspr", "create_date"],
  ["id" => $id ]);

  $error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $bsf = $data_bc['bsf'];
  $usf = $data_bc['usf'];
  $bspp = $data_bc['bspp'];
  $uspp = $data_bc['uspp'];
  $bspr = $data_bc['bspr'];
  $uspr = $data_bc['uspr'];
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
      border-radius: 5px;
      padding: 5px;
      margin: 5px;
    }
    .field{
      margin-left: 50px;
    }

  </style>
<body>
<!-- Patient Details -->
  <div class="container">

    <!-- Navigation -->
    <div class="d-print-none">
      <a href="#" class="" role="button" onclick=" window.history.back();">
        <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
      <a href="/pathoapp" role="button">
          <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
      <button  onclick="window.print();">
        <i class="fas fa-print" style="font-size:30px;"></i></button>
      <a href="edit<?= $report_link ?>.php?rid=<?= $rid ?>" role="button">
          <i class="fas fa-edit": style="font-size:30px;"></i></a>
      <a href="/pathoapp/<?= $class ?>/add<?= $report_link?>.php" class="" role="button">
        <i class='fas fa-plus' style='font-size:30px;color:green'></i></a>
    </div>

    <?php include '../inc/printheader.php' ; ?>

    <div class="row mt-1">
      <div class="col-sm-12 text-center mx-auto ">
        <h4 class="display-6 report_header" style=""><b>PATIENT DETAILS</b></h4>
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

    <div class="row mx-auto" style="padding:10px;">
      <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
        Referred By &nbsp&nbsp
      </div>
      <div class="col-sm-4 text-left">
          : &nbsp <b><?php  echo $drinitials." ".$drfirstname." ".$drsurname; ?></b>,
          (<?php  echo $drqualification; ?>)</b>
      </div>

    </div>

    <div class="row m-5">
      <div class="col-sm-12 text-center mx-auto ">
        <h4 class="display-6 report_header" style=""><b><?= $testname?></b></h4>
      </div>
      <br>
    </div>
    <!-- Columns -->
    <div class="row text-center ">
      <div class="column_header col-sm-3 text-center mx-auto" >
          <b>TEST DESCRIPTION</b>
      </div>
      <div class="column_header col-sm-3 text-center mx-auto column-header " >
          <b>RESULT</b>
      </div>
      <div class="column_header col-sm-3 text-center mx-auto column-header ">
          <b>UNITS</b>
      </div>
      <div class="column_header col-sm-3 text-center mx-auto column-header ">
          <b>REFERENCES</b>
      </div>
    </div>

    <!-- Blood Sugar Fasting -->
    <div class="row border-bottom-5 border-bottom">
      <div class="col-sm-3 text-left">
        <div class="field">
          <b>Blood Sugar Fasting :</b>
        </div>
      </div>
      <div class="col-sm-3 text-center">
        <?php
        if($bsf>65 && $bsf <100){
            echo $bsf;
        }else{
            echo '<b>'.$bsf.'</b>';
        }
        ?>
      </div>
      <div class="col-sm-3 text-center mx-auto">
        mg%
      </div>
      <div class="col-sm-3 text-left mx-auto">
        <p>Reference Value 65-100 mg%</p>
      </div>
    </div>

    <!-- Urine Sugar Fasting -->
    <div class="row border-bottom-5 border-bottom">
      <div class="col-sm-3 text-left">
        <div class="field">
          <b>Urine Sugar Fasting :</b>
        </div>
      </div>
      <div class="col-sm-3 text-center">
        <?= $usf?>
      </div>
      <div class="col-sm-3 text-center mx-auto">
        mg%
      </div>
      <div class="col-sm-3 text-left mx-auto">
        <p></p><br>
      </div>
    </div>

    <!-- Blood Sugar Post Prandial -->
    <div class="row border-bottom-5 border-bottom">
      <div class="col-sm-3 text-left">
        <div class="field">
          <b>Blood Sugar Post Prandial :</b>
        </div>
      </div>
      <div class="col-sm-3 text-center">
        <?php
        if($bspp<=140 ){
            echo $bspp;
        }else{
            echo "<b>".$bspp."</b>";
        }
        ?>
      </div>
      <div class="col-sm-3 text-center mx-auto">
        mg%
      </div>
      <div class="col-sm-3 text-left mx-auto">
        <p>Upto 140 mg%</p>
      </div>
    </div>

    <!-- Urine Sugar Post Prandial : -->
    <div class="row border-bottom-5 border-bottom">
      <div class="col-sm-3 text-left">
        <div class="field">
          <b>Urine Sugar Post Prandial :</b>
        </div>
      </div>
      <div class="col-sm-3 text-center">
        <?= $uspp ?>
      </div>
      <div class="col-sm-3 text-center mx-auto">
        mg%
      </div>
      <div class="col-sm-3 text-left mx-auto">
        <p></p><br>
      </div>
    </div>

    <!-- Blood Sugar Random :: -->
    <div class="row border-bottom-5 border-bottom">
      <div class="col-sm-3 text-left">
        <div class="field">
          <b>Blood Sugar Random :</b>
        </div>
      </div>
      <div class="col-sm-3 text-center">
        <?php echo $bspr ?>
      </div>
      <div class="col-sm-3 text-center mx-auto">

      </div>
      <div class="col-sm-3 text-left mx-auto">
        <p></p><br>
      </div>
    </div>

    <!-- Urine Sugar Random: -->
    <div class="row border-bottom-5 border-bottom">
      <div class="col-sm-3 text-left">
        <div class="field">
          <b>Urine Sugar Random :</b>
        </div>
      </div>
      <div class="col-sm-3 text-center">
        <?php echo $uspr ?>
      </div>
      <div class="col-sm-3 text-center mx-auto">

      </div>
      <div class="col-sm-3 text-left mx-auto">
        <p></p><br>
      </div>
    </div>


    <div class="row" style="position:relative; top: 400px;">
      <div class="col-8 text-left mx-auto" >
        Report with thanks to <b> <?php echo $doctor_details ?> </b>
      </div>
      <div class="col-4 text-center mx-auto">
        <b>Pathologist</b>
      </div>
    </div>
    <div class="row mx-auto" style="position:relative; top: 400px;">
      <p>This is an electronically authenticated report. Report Printed Date : <b> <?= $report_create_date ?> </b></p>
      <p>NOTE : Assay results should be correlated clinically with other clinical findings and the total clinical status of the patient</p>
    </div>
  </div>
<script src="../js/jquery-3.3.1.slim.min.js" ></script>
<script src="../js/popper.min.js" ></script>
<script src="../js/bootstrap.min.js" ></script>
</body>
</html>
