<?php

require '../inc/db.init.php';

//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "HAEMOGRAM";
$report_link = "haemogram";
$pid = "";
$drid = "";
$tec = "";
$haemoglobin = "";
$neutrophils = "";
$eosinophil = "";
$monocytes = "";
$platletscount = "";
$esr = "";
$parasites = "";
$bleedingtime = "";
$clottingtime = "";
$create_date = "";

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
  $data_bc = $database->get("haemogram",
  ["drid", "pid", "tec", "haemoglobin", "neutrophils", "eosinophil", "monocytes",
  "basophils", "platletscount", "esr", "parasites",
  "bleedingtime", "clottingtime","create_date", "immaturecells", "lymphocytes",
  "sickling", "ppd"],
  ["id" => $id ]);

  //$error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $tec = $data_bc['tec'];
  $haemoglobin = $data_bc['haemoglobin'];
  $neutrophils = $data_bc['neutrophils'];
  $lymphocytes = $data_bc['lymphocytes'];
  $eosinophil = $data_bc['eosinophil'];
  $monocytes = $data_bc['monocytes'];
  $platletscount = $data_bc['platletscount'];
  $esr = $data_bc['esr'];
  $parasites = $data_bc['parasites'];
  $bleedingtime = $data_bc['bleedingtime'];
  $clottingtime = $data_bc['clottingtime'];
  $create_date = $data_bc['create_date'];
  $basophils = $data_bc['basophils'];
  $immaturecells = $data_bc['immaturecells'];
  $sickling = $data_bc['sickling'];
  $ppd = $data_bc['ppd'];


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

    <div class="container">
      <!-- Navigation -->
      <div class="d-print-none">
        <a href="#" class="" role="button" onclick=" window.history.back();">
          <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
          <a href="/pathoapp" role="button">
              <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
        <a href="/pathoapp/urine/add<?= $report_link?>.php" class="" role="button">
          <i class='fas fa-plus' style='font-size:30px;color:green'></i></a>
        <button  onclick="window.print();">
          <i class="fas fa-print" style="font-size:30px;"></i></button>
        <a href="edit<?= $report_link?>.php?rid=<?= $rid ?>" role="button">
            <i class="fas fa-edit": style="font-size:30px;"></i></a>
        <a href="/pathoapp/listreport.php?type=<?= $report_link?>" role="button">
            <i class="fas fa-list": style="font-size:30px; color:green;"></i></a>
      </div>

      <?php include '../inc/printheader.php'; ?>

      <!-- Header -->
      <div class="row mt-5">
        <div class="col-sm-12 text-center mx-auto ">
          <h4 class="display-5 report_header" style=""><b><?= $testname ?></b></h4>
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

      <!-- Columns -->
      <div class="row text-center" style="margin: 10px">
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

      <div class="row">
        <div class="col-4">
            Total Erythrocyte Count:
        </div>
        <div class="col-2 text-left mx-auto">
            <?= $tec ?> g/dl
        </div>
        <div class="col-6">
            <p>DIFFERENTIAL LEUCOCYTE COUNT</p>
        </div>
      </div>

      <div class="row">
        <div class="col-4">
            HAEMOGLOBIN (gm %)
        </div>
        <div class="col-2 text-left mx-auto">
            <?= $haemoglobin ?> g/dl
        </div>
        <div class="col-6">
        </div>
      </div>

      <div class="row">
        <div class="col-4">
            <p>  Neutrophils (gm %)</p>
        </div>
        <div class="col-2">
            <p>  <?= $neutrophils ?> %</p>
        </div>

        <div class="col-4">

        </div>
        <div class="col-2 text-center mx-auto">

        </div>

      </div>

      <div class="row">
        <div class="col-4">
            <p>  Eisnophils (%)</p>
        </div>
        <div class="col-2">
            <p>  <?= $eosinophil ?> %</p>
        </div>
        <div class="col-4">

        </div>
        <div class="col-2 text-center mx-auto">

        </div>
      </div>

      <div class="row">
        <div class="col-4">
            <p>  Monocytes (%)</p>
        </div>
        <div class="col-2">
            <p>  <?= $monocytes ?> %</p>
        </div>
        <div class="col-4">
        </div>
        <div class="col-2 text-center mx-auto">

        </div>
      </div>

      <div class="row">

        <div class="col-4">
            <p>  Basophils (%)</p>
        </div>
        <div class="col-2">
            <p>  <?= $basophils ?> %</p>
        </div>
        <div class="col-4">

        </div>
        <div class="col-2 text-center mx-auto">

        </div>

      </div>

      <div class="row">
        <div class="col-4 text-left mx-auto">
        </div>
        <div class="col-2 text-left mx-auto">
        </div>
        <div class="col-4">
          Platlets Count
        </div>
        <div class="col-2">
          <?= $platletscount ?>
        </div>
      </div>

      <div class="row">
        <div class="col-4 text-left mx-auto">
          E.S.R. (westergren)
        </div>
        <div class="col-2 text-left mx-auto">
          <?= $esr ?>
        </div>
        <div class="col-4">
          Parasites (MP)
        </div>
        <div class="col-2">
          <?= $parasites ?>
        </div>
      </div>

      <div class="row">
        <div class="col-4 text-left mx-auto">
          Sickling
        </div>
        <div class="col-2 text-left mx-auto">
          <?= $sickling ?>
        </div>
        <div class="col-4">
          Bleeding Time
        </div>
        <div class="col-2">
          <?= $bleedingtime ?>
        </div>
      </div>

      <div class="row">
        <div class="col-4 text-left mx-auto">
          P.P.D. Test
        </div>
        <div class="col-2 text-left mx-auto">
          <?= $ppd ?>
        </div>
        <div class="col-4">
          Bleeding Time
        </div>
        <div class="col-2">
          <?= $clottingtime ?>
        </div>
      </div>


      <hr style="width:100%">

      <div class="row" style="position:relative; top: 230px;">
        <div class="col-8 text-left mx-auto" >
          Report with thanks to <b> <?php echo $doctor_details ?> </b>
        </div>
        <div class="col-4 text-center mx-auto">
          <b>Pathologist</b>
        </div>
      </div>
      <div class="row mx-auto" style="position:relative; top: 230px;">
        <p>This is an electronically authenticated report. Report Printed Date : <b> <?= $report_create_date ?> </b></p>
        <p>NOTE : Assay results should be correlated clinically with other clinical findings and the total clinical status of the patient</p>
      </div>


    </div>
</body>

<script src="../js/jquery-3.3.1.slim.min.js" ></script>
<script src="../js/popper.min.js" ></script>
<script src="../js/bootstrap.min.js" ></script>

<script type="text/javascript">
$(document).keyup(function (e) {
  //alert(e.keyCode);
  switch (e.keyCode) {
    case 8:
      //window.location.href = 'http://localhost/pathoapp/urine/addsemen.php';
      break;
    case 76:
      window.location.href = 'http://localhost/pathoapp/listreport.php?type=semen';
      break;
    case 65:
      window.location.href = 'http://localhost/pathoapp/urine/addsemen.php';
      break;
    case 69:
      window.location.href = 'http://localhost/pathoapp/urine/editsemen.php?rid=<?= $rid ?>';
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
