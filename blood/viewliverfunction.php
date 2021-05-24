<?php

require '../inc/db.init.php';
//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "LIVER FUNCTION";
$report_link = "liverfunction";

//initializing variables
$pid = "";
$drid =  "";
$sbt =  "";
$conjugated =  "";
$unconjugated =  "";
$spt =  "";
$albumin =  "";
$globulin =  "";
$sgot =  "";
$sgpt =  "";
$sap =  "";
$hbsag =  "";
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
  ["class_id","class"],
  ["class_type" => "{$report_link}", "rid" => "{$rid}" ]);

  $id = $data_report["class_id"];
  $class = $data_report["class"];
  //echo $id;
  //search semen table with id

  $data_bc = $database->get("{$report_link}",
  ["pid","drid","sbt","conjugated","unconjugated","spt","albumin","globulin",
  "sgot", "sgpt","sap","hbsag", "create_date"],
  ["id" => $id ]);

  $error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $sbt = $data_bc['sbt'];
  $conjugated = $data_bc['conjugated'];
  $unconjugated = $data_bc['unconjugated'];
  $spt = $data_bc['spt'];
  $albumin = $data_bc['albumin'];
  $globulin = $data_bc['globulin'];
  $sgot = $data_bc['sgot'];
  $sgpt = $data_bc['sgpt'];
  $sap = $data_bc['sap'];
  $hbsag = $data_bc['hbsag'];
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
      padding: 0px;
      margin: 0px;
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

    <div class="row column_header mt-1">
      <div class="col-sm-3 p-1 mb-0 offset-sm-1 text-center fw-bold">
        <b>SERUM BILIRUBIN</b>
      </div>
      <div class="col-sm-4 p-1 mb-0 text-center fw-bold">
        <div class="form-group">
          <p><b>RESULT</b></p>
        </div>
      </div>
      <div class="col-sm-3 p-1 mb-0 text-center fw-bold">
        <div class="form-group">
          <p><b>NORMAL</b></p>
        </div>
      </div>
    </div>

    <!-- Total -->
    <div class="row mt-3">
      <div class="col-sm-2 offset-sm-2">
        <p class="fw-bold font-monospace">TOTAL</p>
      </div>
      <div class="col-sm-2 text-center offset-sm-1">
        <?php
        if($sbt <= 1.0){
            echo $sbt;
        }else{
            echo '<b>'.$sbt.'</b>';
        }
        ?>
      </div>
      <div class="col-sm-3 offset-sm-2 fw-bold">
        <p>Upto 1.0 mg/dl</p>
      </div>
    </div>


    <div class="row mt-1">
      <div class="col-sm-2 offset-sm-2">
        CONJUGATED
      </div>
      <div class="col-sm-2 text-center offset-sm-1">
        <?php
        if($sbt <= 0.6){
            echo $conjugated;
        }else{
            echo '<b>'.$conjugated.'</b>';
        }
        ?>
      </div>
      <div class="col-sm-3 offset-sm-2">
        <p>Upto 0.6 mg/dl</p>
      </div>

    </div>

    <div class="row mt-1">
      <div class="col-sm-2 offset-sm-2">
        UNCONJUGATED
      </div>
      <div class="col-sm-2 text-center offset-sm-1">
        <?php
        if($sbt <= 0.4){
            echo $unconjugated;
        }else{
            echo '<b>'.$unconjugated.'</b>';
        }
        ?>
      </div>
      <div class="col-sm-3 offset-sm-2">
        <p>Upto 0.4 mg/dl</p>
      </div>

    </div>

    <div class="row mt-1">
        <div class="col-sm-3 text-center column_header offset-sm-1">
            <b>SERUM PROTEINS</b>
        </div>

    </div>
    <br>
    <div class="row mt-1">
        <div class="col-sm-2 offset-sm-2">
            ALBUMIN
        </div>
        <div class="col-sm-2 text-center offset-sm-1">
            <?php
            if($albumin >= 3.5 && $albumin <= 5.5 ){
                echo $albumin;
            }else{
                echo '<b>'.$albumin.'</b>';
            }
            ?>
        </div>
        <div class="col-sm-3 offset-sm-2">
            <p>3.5 to 5.5 mg/dl</p>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-sm-2 offset-sm-2">
            GLOBULIN
        </div>
        <div class="col-sm-2 text-center offset-sm-1">
            <?php
            if($globulin >= 1.5 && $globulin <= 3.0 ){
                echo $globulin;
            }else{
                echo '<b>'.$globulin.'</b>';
            }
            ?>
        </div>
        <div class="col-sm-3 offset-sm-2">
            <p>1.5 to 3.0 mg/dl</p>
        </div>

    </div>

    <div class="row mt-1">
        <div class="col-sm-2 offset-sm-2">
            SGOT
        </div>
        <div class="col-sm-2 text-center offset-sm-1">
            <?php
            if($sgot > 5 && $sgot < 40 ){
                echo $sgot;
            }else{
                echo '<b>'.$sgot.'</b>';
            }
            ?>
        </div>
        <div class="col-sm-3 offset-sm-2">
            <p>5 to 40 units/ml</p>
        </div>

    </div>

    <div class="row mt-1">
        <div class="col-sm-2 offset-sm-2">
            SGPT :
        </div>
        <div class="col-sm-2 text-center offset-sm-1">
            <?php
            if($sgpt < 35 && $sgpt >5 ){
                echo $sgpt;
            }else{
                echo '<b>'.$sgpt.'</b>';
            }
            ?>
        </div>
        <div class="col-sm-3 offset-sm-2">
            <p>5 to 40 units/ml</p>
        </div>

    </div>

    <div class="row mt-1">
        <div class="col-sm-3 offset-sm-1 text-uppercase">
            SERUM ALKALINE PHOSPHATE
        </div>
        <div class="col-sm-2 text-center offset-sm-1">
            <?php
            if($sap < 11 && $sap > 4 ){
                echo $sap;
            }else{
                echo '<b>'.$sap.'</b>';
            }
            ?>
        </div>
        <div class="col-sm-3 offset-sm-2">
            <p>4 to 11 KA units</p>
        </div>

    </div>

    <div class="row mt-1">
        <div class="col-sm-3 offset-sm-1 text-uppercase">
            Hbs Ag Australia Antigen
        </div>
        <div class="col-sm-2 text-center offset-sm-1">
            <?php echo $hbsag; ?>
        </div>
        <div class="col-sm-3 offset-sm-2">
            <p></p>
        </div>
    </div>

    <div class="row" style="position:relative; top: 100px;">
      <div class="col-8 text-left mx-auto" >
        Report with thanks to <b> <?php echo $doctor_details ?> </b>
      </div>
      <div class="col-4 text-center mx-auto">
        <b>Pathologist</b>
      </div>
    </div>
    <div class="row mx-auto" style="position:relative; top: 100px;">
      <p>This is an electronically authenticated report. Report Printed Date : <b> <?= $report_create_date ?> </b></p>
      <p>NOTE : Assay results should be correlated clinically with other clinical findings and the total clinical status of the patient</p>
    </div>
  </div>

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
