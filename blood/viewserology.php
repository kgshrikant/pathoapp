<?php
//include '../inc/header.php';
require '../inc/db.init.php';

$pid = "";
$drid = "";
$bgtype = "";
$bgrhfactor = "";
$message_result = "";
$report_id = "";
$message_result = "";
$report_create_date = "";
$sex_code = "";
$testname = "SEROLOGY TEST";
$report_link = 'serology';
//patient details
$initials = '';
$firstname = '';
$surname = '';
$sex = '';
$age = '';
//doctor details
$drinitials = '';
$drfirstname = '';
$drsurname = '';
$drqualification = '';
$doctor_details = '';


if($_SERVER["REQUEST_METHOD"] == "GET") {
  //get the report url parameter
  $rid = $_GET['rid'];

  //get the report info from report table class type serology rid from reports table
  $data_report = $database->get("report",
  ["class_id"],
  ["class_type" => "serology", "rid" => "{$rid}" ]);

  //get the bloodgroup id from data report
  $id = $data_report["class_id"];

  $data_bloodgroup = $database->get("serology",
  ["pid","drid","hiv1","hiv2","vdrl","hbsag","anti_hcv","create_date"],
  ["id" => $id ]);

  $pid = $data_bloodgroup['pid'];
  $drid = $data_bloodgroup['drid'];
  $hiv1 = $data_bloodgroup['hiv1'];
  $hiv2 = $data_bloodgroup['hiv2'];
  $hbsag = $data_bloodgroup['hbsag'];
  $anti_hcv = $data_bloodgroup['anti_hcv'];
  $vdrl = $data_bloodgroup['vdrl'];

  //$report_create_date = $data_bloodgroup['create_date'];
  $report_create_date = date("d/m/Y",strtotime($data_bloodgroup['create_date']));

  $error_db = $database->error() ;
  echo $error_db[1];

  $data_patient = $database->get("patient",
  ["pid","firstname","surname","sex","age","initials"],
  ["pid" => $pid ]);

  //echo $data_patient;
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
<title>  <?php echo $rid." {$testname} ". $initials." ".$firstname." ".$surname;  ?></title>
<style media="screen">
  .report_header{
    background-color: #a7a9ab;
    border-radius: 5px;
    padding: 5px;
  }
  .colum_header {
    background-color: #a7a9ab;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;
  }
</style>
</head>
<body>

  <div class="container " style="border-radius: 10px; size:21cm; height:1440px">
    <div class="d-print-none">
            <a href="#" class="" role="button" onclick=" window.history.back();">
              <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
            <button  onclick="window.print();">
              <i class="fas fa-print" style="font-size:30px;"></i></button>
            <a href="edit<?= $report_link ?>.php?rid=<?= $rid ?>" role="button">
                <i class="fas fa-edit": style="font-size:30px;"></i></a>
            <a href="/pathoapp" role="button">
                <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
    </div>

    <?php include '../inc/printheader.php'; ?>
    <div class="row">
        <div class="col-sm-10">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center mx-auto ">
            <br><br>
            <h4 class="display-5 report_header" style=""><b><?= $testname ?></b></h4>
        </div>
        <br><br>
    </div>

    <div class="row mx-auto" style="padding:10px;">
      <div class="col-sm-1.5  text-left text-uppercase" style="margin-left:20px;">
          Patient Name
      </div>
      <div class="col-sm-8 text-left text-uppercase">
        :&nbsp&nbsp<b><?php echo $initials." ".$firstname." ".$surname;  ?></b>
      </div>
    </div>
    <div class="row mx-auto text-uppercase" style="padding:10px;">
      <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
        Age / Gender
      </div>
      <div class="col-sm-8 text-left text-uppercase">
        :&nbsp&nbsp<b><?= $age; ?></b> Year(s) / <b><?= $sex; ?></b>
        <i class="fas fa-<?= $sex_code ?>" style="font-size:20px; color:red; padding:3px"></i>
      </div>
    </div>
    <div class="row mx-auto text-uppercase" style="padding:10px;">
        <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
          Report id &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </div>
        <div class="col-sm-4 text-left">
            :&nbsp <b><?= sprintf("%07d", $rid)?></b>
        </div>
        <div class="col-sm-4 text-left">

        </div>
        <div class="col-sm-8.5 text-right text-uppercase">
            Report Date :<b> <?= $report_create_date ?> </b>
        </div>
    </div>

    <div class="row mx-auto text-uppercase" style="padding:10px;">
      <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
        Referred By &nbsp&nbsp
      </div>
      <div class="col-sm-4 text-left">
          : &nbsp <b><?php  echo $drinitials." ".$drfirstname." ".$drsurname; ?></b>,
          (<?php  echo $drqualification; ?>)</b>
      </div>

    </div>
    <hr style="width:100%">

    <div class="row mx-auto mt-5" >

      <div class="col-sm-4 text-center display-5 colum_header">
          <h3><b>TEST DESCRIPTION</b></h3>
      </div>
      <div class="col-sm-2 text-right">
      </div>
      <div class="col-sm-4 text-center display-5 colum_header">
          <h3><b> RESULT</b></h3>
      </div>
    </div>
    <br><br>
    <div class="row mx-auto diplay-2">
      <div class="col-sm-4 text-center font-weight-bold">
          HIV1
      </div>
      <div class="col-sm-2 text-right">
      </div>
      <div class="col-sm-4 text-center ">
        <?= ( ($hiv1 == 0 )? "NON-REACTIVE" : "<b>REACTIVE</b>" ) ?>
      </div>
    </div>
    <br>
    <div class="row mx-auto">
      <div class="col-sm-4 text-center font-weight-bold">
        HIV2
      </div>
      <div class="col-sm-2 text-right">
      </div>
      <div class="col-sm-4 text-center ">
        <?= ( ($hiv2 == 0 )? "NON-REACTIVE" : "<b>REACTIVE</b>" ) ?>
      </div>
    </div>
    <br>
    <div class="row mx-auto">
      <div class="col-sm-4 text-center font-weight-bold">
          VDRL
      </div>
      <div class="col-sm-2 text-right">
      </div>
      <div class="col-sm-4 text-center ">

        <?= ( ($vdrl == 0 )? "NON-REACTIVE" : "<b>REACTIVE</b>" ) ?>

      </div>
    </div>
    <br>
    <div class="row mx-auto">
      <div class="col-sm-4 text-center font-weight-bold">
          HBsAg
      </div>
      <div class="col-sm-2 text-right">
      </div>
      <div class="col-sm-4 text-center ">
        <?= ( ($hbsag == 0 )? "NON-REACTIVE" : "<b>REACTIVE</b>" ) ?>
      </div>
    </div>
    <br>
    <div class="row mx-auto">
      <div class="col-sm-4 text-center font-weight-bold">
          ANTI HCV
      </div>
      <div class="col-sm-2 text-right">
      </div>
      <div class="col-sm-4 text-center ">
        <?= ( ($anti_hcv == 0 )? "NON-REACTIVE" : "<b>REACTIVE</b>" ) ?>
      </div>
    </div>
    <br><br>
    <div class="row" style="position:relative; top: 430px;">
      <div class="col-8 text-left mx-auto" >
        Report with thanks to <b> <?php echo $doctor_details ?> </b>
      </div>
      <div class="col-4 text-center mx-auto">
        <b>Pathologist</b>
      </div>
    </div>
    <div class="row mx-auto" style="position:relative; top: 430px;">
      <p>This is an electronically authenticated report. Report Printed Date : <b> <?= $report_create_date ?> </b></p>
      <p>NOTE : These reports are for assisting Doctors/ Physicians in their treatment and not for the medico legal purposes and should be co-related clinically.</p>
    </div>
  </div>

  </div>
</body>
<script src="../js/jquery-3.3.1.slim.min.js" ></script>
<script src="../js/popper.min.js" ></script>
<script src="../js/bootstrap.min.js" ></script>
<script src="../js/bloodgroup.js" ></script>

</body>
</html>
