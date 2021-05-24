<?php

require '../inc/db.init.php';
//form fields

$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "ELECTROLYTE";
$report_link = "electrolyte";

//initializing variables
$pid = "";
$drid = "";
$sodium = "";
$potassium = "";
$calcium = "";
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
  ["pid","drid","sodium","potassium","calcium","create_date"],
  ["id" => $id ]);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $sodium = $data_bc['sodium'];
  $potassium = $data_bc['potassium'];
  $calcium = $data_bc['calcium'];
  $report_create_date = date("d/m/Y",strtotime($data_bc['create_date']));

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
      border-radius: 7px;
      padding-top: 5px;
      margin-top:5px;
    }
    .field{
      margin-left: 50px;
    }

  </style>
<body>
  <div class="container ">
    <!-- Navigation -->
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

    <?php include '../inc/view-patient-details.php' ; ?>

    <br><br>
    <!-- Test header -->
    <div class="row mt-4">
      <div class="col-md-10 offset-md-1">
        <table class="table table-grey">
          <thead class="thead-light text-center">
            <tr>
              <th>TEST</th>
              <th>RESULT</th>
              <th>NORMAL VALUE</th>
            </tr>
          </thead>
          <tbody class="text-center text-uppercase">
            <tr>
              <td>Na (Sodium)</td>
              <td>
                <?php
                if ($sodium>=135 && $sodium <= 155)
                  echo $sodium;
                else
                  echo "<b>$sodium</b>";
                ?>
              </td>
              <td><b>[135 to 155]</b></td>
            </tr>
            <tr>
              <td>K (Potassium)</td>
              <td><?php
              if ($potassium>=3.5 && $potassium <= 5.5)
                echo $potassium;
              else
                echo "<b>$potassium</b>";
              ?></td>
              <td><b>[3.5 to 5.5]</b></td>
            </tr>
            <tr>
              <td>Ca (Calcium)</td>
              <td><?php
              if ($calcium>=1.10 && $calcium<=1.35)
                echo $calcium;
              else
                echo "<b>$calcium</b>";
              ?></th>

              <td><b>[1.10 to 1.35]</b></td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>



      <!-- footer info for Pathology and thanks doctor message -->
      <div class="row" style="position:relative; top: 500px;">
        <div class="col-8 text-left mx-auto" >
          Report with thanks to <b> <?php echo $doctor_details ?> </b>
        </div>
        <div class="col-4 text-center mx-auto">
          <b>Pathologist</b>
        </div>
      </div>
      <div class="row mx-auto" style="position:relative; top: 500px;">
        <p>This is an electronically authenticated report. Report Printed Date : <b> <?= $report_create_date ?> </b></p>
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
