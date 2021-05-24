<?php

require '../inc/db.init.php';
//form fields
$pid = "";
$drid = "";
$report_id = "";
$rid = "";
$message_result = "";
$testname = "WIDAL AGGLUTINATION";
$report_link = 'widalagglutination';
$class_id = "";
$message_result = "";
$styphio = "";
$styphih = "";
$styphiah = "";
$styphibh = "";
$qualitative = "";
$create_date = "";
$report_create_date = new DateTime($create_date);

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

$report_create_date = date("d/m/Y");

if($_SERVER["REQUEST_METHOD"] == "GET") {

  // get id details from report table
   $rid = $_GET['rid'];
   $data_report = $database->get("report",
   ["class_id"],
   ["class_type" => "widalagglutination", "rid" => "{$rid}" ]);

   $id = $data_report["class_id"];

  //search semen table with id
  $data_bc = $database->get("widalagglutination",
  ["pid", "drid", "qualitative", "styphio", "styphih", "styphiah", "styphibh", "create_date"],
  ["id" => $id ]);

  $error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $styphio = $data_bc['styphio'];
  $styphih = $data_bc['styphih'];
  $styphiah = $data_bc['styphiah'];
  $styphibh = $data_bc['styphibh'];
  $qualitative = $data_bc['qualitative'];
  $create_date = $data_bc['create_date'];
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
      <a href="/pathoapp/blood/add<?= $report_link?>.php" class="" role="button">
        <i class='fas fa-plus' style='font-size:30px;color:green'></i></a>
      <button  onclick="window.print();">
        <i class="fas fa-print" style="font-size:30px;"></i></button>
      <a href="edit<?= $report_link?>.php?rid=<?= $rid ?>" role="button">
          <i class="fas fa-edit": style="font-size:30px;"></i></a>
      <a href="/pathoapp/listreport.php?type=widalagglutination" role="button">
          <i class="fas fa-list": style="font-size:30px; color:green;"></i></a>

    </div>

    <?php include '../inc/printheader.php' ; ?>
    <?php include '../inc/view-patient-details.php' ; ?>


    <!-- Columns -->
    <div class="row m-4" >
      <div class="column_header col-sm-3 text-center mx-auto" >
          <b>TEST DESCRIPTION</b>
      </div>
      <div class="column_header col-sm-9 text-center mx-auto column-header " >
          <b>RESULT</b>
      </div>
      <!--<div class="column_header col-sm-3 text-center mx-auto column-header ">
          <b>UNITS</b>
      </div>
      <div class="column_header col-sm-3 text-center mx-auto column-header ">
          <b>REFERENCES</b>
      </div> -->
    </div>

    <div class="row m-4">
      <div class="col-sm-3 text-center">
        <b>S TYPHI 'O', 'H', 'AH', 'BH'</b>
      </div>
      <div class="col-sm-9 text-center" style="font-weight: bold;">
        <?php
          $flag = array(0,0,0,0);
          //if any substring after index 2 is 1 then widal is positive
          for( $i=0; $i<6 ; $i++){
            if(substr($styphio,$i,1) == 1 && $i>2 ){
              $flag[0] = 1;
            }
            if(substr($styphih,$i,1) == 1 && $i>2 ){
              $flag[1] = 1;
            }
            if(substr($styphiah,$i,1) == 1 && $i>2 ){
              $flag[2] = 1;
            }
            if(substr($styphibh,$i,1) == 1 && $i>2 ){
              $flag[3] = 1;
            }
            //echo $flag."<br>";
          }
          
          if($flag[0] == 1){
            echo "'O' POSITIVE <br>";
          }
          if($flag[1] == 1){
            echo "'H' POSITIVE <br>";
          }
          if($flag[2] == 1){
            echo "'OH' POSITIVE <br>";
          }
          if($flag[3] == 1){
            echo "'AH' POSITIVE <br>";
          }

          //var_dump($flag);
        ?>
      </div>

    </div>
    <br>
    <!-- Blood Sugar Fasting -->
    <div class="row mt-5">
      <div class="col-1">
      </div>

      <div class="col-10">
        <table class="table table-grey ">
          <thead style="text-align: center; " class="thead-light text-uppercase">
            <tr>
              <th>Dilution of Serum : </th>
              <th>1/20</th>
              <th>1/40</th>
              <th>1/80</th>
              <th>1/160</th>
              <th>1/320</th>
              <th>1/640</th>
            </tr>
          </thead>

          <tbody style="text-align: center; font-size: large;">
            <tr class="">
              <td>S TYPHI 'O'</td>
              <?php
                for( $i=0; $i<strlen($styphio) ; $i++){
                  echo "<td>";
                  if(substr($styphio,$i,1) == 1)
                    echo "<b>+ve</b>";
                  else
                    echo "-ve";

                  echo "</td>";
                }
              ?>
            </tr>
            <tr>
              <td>S TYPHI 'H'</td>
              <?php
                for( $i=0; $i<strlen($styphih) ; $i++){
                  echo "<td>";
                  if(substr($styphih,$i,1) == 1)
                    echo "<b>+ve</b>";
                  else
                    echo "-ve";

                  echo "</td>";
                }
              ?>
            </tr>

            <tr>
              <td>S TYPHI 'AH'</td>
              <?php
                for( $i=0; $i<strlen($styphiah) ; $i++){
                  echo "<td>";
                  if(substr($styphiah,$i,1) == 1)
                    echo "<b>+ve</b>";
                  else
                    echo "-ve";

                  echo "</td>";
                }
              ?>
            </tr>
            <tr>
              <td>S TYPHI 'BH'</td>

              <?php
                for( $i=0; $i<strlen($styphibh) ; $i++){
                  echo "<td>";
                  if(substr($styphibh,$i,1) == 1)
                    echo "<b>+ve</b>";
                  else
                    echo "-ve";

                  echo "</td>";
                }
              ?>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-1">
      </div>
    </div>


    <div class="row" style="position:relative; top: 350px;">
      <div class="col-8 text-left mx-auto" >
        Report with thanks to <b> <?php echo $doctor_details ?> </b>
      </div>
      <div class="col-4 text-center mx-auto">
        <b>Pathologist</b>
      </div>
    </div>
    <div class="row mx-auto" style="position:relative; top: 350px;">
      <p>This is an electronically authenticated report. Report Printed Date : <b> <?= $report_create_date->format('d-M-Y') ?> </b></p>
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
      window.location.href = 'http://localhost/pathoapp/listreport.php?type=widalagglutination';
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
