<?php include '../inc/connection.php';

//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "BLOOD CHEMISTRY";
$bsf = "";
$usf = "";
$bspp = "";
$uspp = "";
$bsr = "";
$usr = "";
$bloodurea= "";
$serumcholestrol = "";
$hdl = "";
$serumuricacid = "";
$serumtry = "";
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
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //echo "hello world";
    //echo var_dump($_POST);
    $pid = $_POST['pid'];
    $drid = $_POST['drid'];
    $bsf = $_POST['bsf'];
    $usf = $_POST['usf'];
    $bspp = $_POST['bspp'];
    $uspp = $_POST['uspp'];
    $bsr = $_POST['bsr'];
    $usr = $_POST['usr'];
    $bloodurea= $_POST['bloodurea'];
    $serumcholestrol = $_POST['serumcholestrol'];
    $hdl = $_POST['hdl'];
    $serumuricacid = $_POST['serumuricacid'];
    $serumtry = $_POST['serumtry'];

    $sql = "INSERT into bloodchemistry (pid, drid, bsf, usf, bspp, uspp, bsr, usr, bloodurea, serumcholestrol,
        hdl, serumuricacid, serumtry) values
    ('{$pid}','{$drid}','{$bsf}','{$usf}','{$bspp}','{$uspp}','{$bsr}','{$usr}', '{$bloodurea}', '{$serumcholestrol}',
        '{$hdl}', '{$serumuricacid}', '{$serumtry}')";

    if($conn->query($sql)){
            $message_result = "Insertion successful";
        $class_id = $conn->insert_id;
    } else {
        $message_result = "Insertion failed ".$sql. " ".$conn->error;
    }

    // inserting into reports table
    $class_type = 'bloodchemistry';
    $class = 'blood';
    $sql = "INSERT into report (class_type, class, pid, class_id ) values
    ('{$class_type}','{$class}','{$pid}','{$class_id}')";

    if($conn->query($sql)){
            $message_result = "Insertion successful";
        $rid = $conn->insert_id;
    } else {
        $message_result = "Insertion failed ".$sql. " ".$conn->error;
    }

    $sql = "SELECT * from patient where pid={$pid}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
          // output data of each row
        while($row = $result->fetch_assoc()) {
            $initials = $row['initials'];
            $firstname = $row['firstname'];
            $surname = $row['surname'];
            $sex = $row['sex'];
            $age = $row['age'];
            $patient_details =  $initials. ", Name: " . $firstname. " " . $surname. ", sex: ". $sex. ", age: ".$age;
        }
    } else {
      $patient_details =  "0 results";
    }

    $sql = "SELECT * from doctor where drid={$drid}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
          // output data of each row
        while($row = $result->fetch_assoc()) {
            $drinitials = $row['initials'];
            $drfirstname = $row['firstname'];
            $drsurname = $row['surname'];
            $drqualification = $row['qualification'];
            $doctor_details =  $drinitials. ". " . $drfirstname. " " . $drsurname. " " . $drqualification. "<br>";
        }
    } else {

      $doctor_details =  "0 results";
    }
} if($_SERVER["REQUEST_METHOD"] == "GET") {
  $id = $_GET['id'];

  $sql = "SELECT * from bloodchemistry where id = {$id}";
  //echo $sql;
  $pid = "";
  $drid = "";

  $result = $conn->query($sql);
  //echo $result;
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $pid = $row['pid'];
      $drid = $row['drid'];
      $bsf = $row['bsf'];
      $usf = $row['usf'];
      $bspp = $row['bspp'];
      $uspp = $row['uspp'];
      $bsr = $row['bsr'];
      $usr = $row['usr'];
      $bloodurea= $row['bloodurea'];
      $serumcholestrol = $row['serumcholestrol'];
      $hdl = $row['hdl'];
      $serumuricacid = $row['serumuricacid'];
      $serumtry = $row['serumtry'];
      $report_create_date = date("d/m/Y",strtotime($row['create_date']));
    }
  } else {
    $report_details =  "0 results";
  }

  $sql = "SELECT * from patient where pid={$pid}";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
        // output data of each row
      while($row = $result->fetch_assoc()) {
          $initials = $row['initials'];
          $firstname = $row['firstname'];
          $surname = $row['surname'];
          $sex = $row['sex'];
          $age = $row['age'];
          $patient_details =  $initials. ", Name: " . $firstname. " " . $surname. ", sex: ". $sex. ", age: ".$age;
      }
  } else {
    $patient_details =  "0 results";
  }

  $sql = "SELECT * from doctor where drid={$drid}";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
        // output data of each row
      while($row = $result->fetch_assoc()) {
          $drinitials = $row['initials'];
          $drfirstname = $row['firstname'];
          $drsurname = $row['surname'];
          $drqualification = $row['qualification'];
          $doctor_details =  $drinitials. ". " . $drfirstname. " " . $drsurname. " " . $drqualification. "<br>";
      }
  }
}
$conn->close();
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
    <div class="d-print-none">
            <a href="#" class="" role="button" onclick=" window.history.back();">
              <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
            <button  onclick="window.print();">
              <i class="fas fa-print" style="font-size:30px;"></i></button>
            <a href="editbloodchemistry.php?id=<?= $id ?>" role="button">
                <i class="fas fa-edit": style="font-size:30px;"></i></a>
            <a href="/pathoapp" role="button">
                <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
    </div>

      <?php include '../inc/printheader.php' ; ?>
      <!-- Header -->
      <div class="row mt-5">
          <div class="col-sm-12 text-center mx-auto ">
              <h4 class="display-5 report_header" style=""><b>BLOOD CHEMISTRY</b></h4>
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
      <div class="row column-header mt-5">
          <div class="col-sm-12 text-center ">
              <h4 class="display-5" ></h4>
          </div>
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
          <?= $uspp;?>
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
          <?php echo $bsr ?>
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
          <?php echo $usr ?>
        </div>
        <div class="col-sm-3 text-center mx-auto">

        </div>
        <div class="col-sm-3 text-left mx-auto">
          <p></p><br>
        </div>
      </div>

      <!-- Blood Urea : -->
      <div class="row border-bottom-5 border-bottom">
        <div class="col-sm-3 text-left">
          <div class="field">
            <b>Blood Urea :</b>
          </div>
        </div>
        <div class="col-sm-3 text-center">
          <?php echo $bloodurea ?>
        </div>
        <div class="col-sm-3 text-center mx-auto">

        </div>
        <div class="col-sm-3 text-left mx-auto">
          <p></p><br>
        </div>
      </div>

      <!-- Serum Cholestrol  : -->
      <div class="row border-bottom-5 border-bottom">
        <div class="col-sm-3 text-left">
          <div class="field">
            <b>Serum Cholestrol  :</b>
          </div>
        </div>
        <div class="col-sm-3 text-center">
          <?= $serumcholestrol ?>
        </div>
        <div class="col-sm-3 text-center mx-auto">

        </div>
        <div class="col-sm-3 text-left mx-auto">
          <p></p><br>
        </div>
      </div>

      <!-- H.D.L.  : -->
      <div class="row border-bottom-5 border-bottom">
        <div class="col-sm-3 text-left">
          <div class="field">
            <b>H.D.L.  :</b>
          </div>
        </div>
        <div class="col-sm-3 text-center">
          <?= $hdl ?>
        </div>
        <div class="col-sm-3 text-center mx-auto">

        </div>
        <div class="col-sm-3 text-left mx-auto">
          <p></p><br>
        </div>
      </div>

      <!-- Serum Trygliycerides : -->
      <div class="row border-bottom-5 border-bottom">
        <div class="col-sm-3 text-left">
          <div class="field">
            <b>Serum Trygliycerides :</b>
          </div>
        </div>
        <div class="col-sm-3 text-center">
          <?= $serumtry ?>
        </div>
        <div class="col-sm-3 text-center mx-auto">

        </div>
        <div class="col-sm-3 text-left mx-auto">
          <p></p><br>
        </div>
      </div>

      <!-- Serum Uric Acid : -->
      <div class="row border-bottom-5 border-bottom">
        <div class="col-sm-3 text-left">
          <div class="field">
            <b>Serum Uric Acid :</b>
          </div>
        </div>
        <div class="col-sm-3 text-center">
          <?= $serumuricacid ?>
        </div>
        <div class="col-sm-3 text-center mx-auto">

        </div>
        <div class="col-sm-3 text-left mx-auto">
          <p></p><br>
        </div>
      </div>


      <br>
      <div class="row">
        <div class="col-8 text-left mx-auto" style="position:relative; top: 400px;">
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
