<?php include '../inc/header.php'; ?>
<?php

// initializing variables
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

  //echo "hello world";
  //echo var_dump($_POST);
  $pid = $_POST['pid'];
  $drid = $_POST['drid'];
  $message_result = '';
  $sbt = $_POST['sbt'];
  $conjugated = $_POST['conjugated'];
  $unconjugated = $_POST['unconjugated'];
  $spt = $_POST['spt'];
  $albumin = $_POST['albumin'];
  $globulin = $_POST['globulin'];
  $sgot = $_POST['sgot'];
  $sgpt = $_POST['sgpt'];
  $sap = $_POST['sap'];
  $hbsag = $_POST['hbsag'];
  $report_create_date = date("d/m/Y");

  $sql = "INSERT into liverfunction (pid, drid, sbt, conjugated, unconjugated,
      spt, albumin, globulin, sgot, sgpt, sap, hbsag) values
  ('{$pid}','{$drid}','{$sbt}','{$conjugated}','{$unconjugated}',
      '{$spt}','{$albumin}','{$globulin}', '{$sgot}', '{$sgpt}', '{$sap}', '{$hbsag}')";

  if($conn->query($sql)){
      $message_result = "Insertion successful";
      $report_id = $conn->insert_id;
  } else {
      $message_result = "Insertion failed ".$sql. " ".$conn->error;
  }


    // inserting into reports table
    $class_type = 'liverfunction';
    $class = 'blood';
    $sql = "INSERT into report (class_type, class, pid, drid, class_id ) values
    ('{$class_type}','{$class}','{$pid}','{$drid}', '{$report_id}')";

    $rid = '';
    if($conn->query($sql)){
        $message_result = "Insertion successful";
        $rid = $conn->insert_id;
    } else {
        $message_result = "Insertion failed ".$sql. " ".$conn->error;
    }

    //patient details
    $initials = '';
    $firstname = '';
    $surname = '';
    $sex = '';
    $age = '';
    $patient_details = '';

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
            $patient_details = "initials: " . $initials. ", Name: " . $firstname. " " . $surname. ", sex: ". $sex. ", age: ".$age;
        }
    } else {
      $patient_details =  "0 results";
    }

    $sql = "SELECT * from doctor where drid={$drid}";
    $result = $conn->query($sql);

    //dr details
    $drinitials = '';
    $drfirstname = '';
    $drsurname = '';
    $drqualification = '';
    $doctor_details = '';

    if ($result->num_rows > 0) {
          // output data of each row
        while($row = $result->fetch_assoc()) {
            $drinitials = $row['initials'];
            $drfirstname = $row['firstname'];
            $drsurname = $row['surname'];
            $drqualification = $row['qualification'];
            $doctor_details = $drinitials. ". " . $drfirstname. " " . $drsurname. " ". $drqualification. "<br>";

        }
    } else {
      $doctor_details =  "0 results";
    }

    //header('Location: patient.php');
} else if($_SERVER["REQUEST_METHOD"] == "GET") {
  $id = $_GET['id'];
  $rid = $_GET['rid'];
  $drid = "";
  $sql = "SELECT * from liverfunction where lid = {$id}";
  //echo $sql;
  $pid = "";
  $drid = "";
  $result = $conn->query($sql);
  //echo $result;
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $pid = $row['pid'];
      $drid = $row['drid'];
      //$message_result = '';
      $sbt = $row['sbt'];
      $conjugated = $row['conjugated'];
      $unconjugated = $row['unconjugated'];
      $spt = $row['spt'];
      $albumin = $row['albumin'];
      $globulin = $row['globulin'];
      $sgot = $row['sgot'];
      $sgpt = $row['sgpt'];
      $sap = $row['sap'];
      $hbsag = $row['hbsag'];
      //$report_create_date = date("d/m/Y");
      $report_create_date = date("d/m/Y",strtotime($row['create_date']));
    }
  } else {
    $report_details =  "0 results";
  }

  // inserting into reports table

  //patient detials
  $initials = '';
  $firstname = '';
  $surname = '';
  $sex = '';
  $age = '';
  $patient_details = '';

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
  //dr details
  $drinitials = '';
  $drfirstname = '';
  $drsurname = '';
  $drqualification = '';
  $doctor_details = '';

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

<title><?= $rid ?> PATHOLOGY LIVER FUNCTION REPORT  <?php echo $initials." ".$firstname." ".$surname;  ?></title>
<script>
    function myFunction() {
        window.print();
    }
</script>
</head>
<body>

    <div class="container border border-dark" style="border-radius: 10px;">
      <div class="">
              <a href="#" class="" role="button" onclick=" window.history.back();">
                <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
              <button  onclick="window.print();">
                <i class="fas fa-print" style="font-size:30px;"></i></button>
              <a href="#" role="button">
                  <i class="fas fa-edit": style="font-size:30px;"></i></a>
      </div>
      <?php include '../inc/printheader.php'; ?>
      <div class="row">
          <div class="col-sm-10">
              <!--<?php echo var_dump($_POST); ?><br> -->
              <!--<?php echo $message_result; ?>  -->
          </div>
      </div>
      <div class="row">
          <div class="col-sm-10 text-center mx-auto ">

              <h4 class="display-5" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px;">LIVER FUNCTION</h4>
          </div>

      </div>

      <!-- Report id and date -->
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
          <i class="fas fa-venus" style="font-size:20px; color:red; padding:3px"></i>
        </div>
      </div>
      <div class="row mx-auto" style="padding:10px;">
          <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
            Report id &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          </div>
          <div class="col-sm-4 text-left">
              :&nbsp <b><?= sprintf("%07d", $rid)?></b>
          </div>

          <div class="col-sm-3 text-right">
              Report Date
          </div>
          <div class="col-sm-3 text-left">
              :<b> <?= $report_create_date ?> </b>
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
      <hr style="width:100%">


      <div class="row ">
          <div class="col-sm-4 text-right">
                  <b>SERUM BILIRUBIN:</b>
          </div>
          <div class="col-sm-4">
              <div class="form-group">
              </div>
          </div>
          <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                  <p><b>NORMAL</b></p>
              </div>
          </div>
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              Total :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php
              if($sbt <= 1.0){
                  echo $sbt;
              }else{
                  echo '<b>'.$sbt.'</b>';
              }
              ?>
          </div>
          <div class="col-sm-4">
              <p>Upto 1.0 mg/dl</p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              Conjugated :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php
              if($sbt <= 0.6){
                  echo $conjugated;
              }else{
                  echo '<b>'.$conjugated.'</b>';
              }
              ?>
          </div>
          <div class="col-sm-4">
              <p>Upto 0.6 mg/dl</p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              Unconjugated :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php
              if($sbt <= 0.4){
                  echo $unconjugated;
              }else{
                  echo '<b>'.$unconjugated.'</b>';
              }
              ?>
          </div>
          <div class="col-sm-4">
              <p>Upto 0.4 mg/dl</p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              <b>SERUM PROTEINS :</b>
          </div>
          <div class="col-sm-4 text-center mx-auto">

          </div>
          <div class="col-sm-4">
          </div>
      </div>
      <br>
      <div class="row">
          <div class="col-sm-4 text-right">
              Albumin :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php
              if($albumin >= 3.5 && $albumin <= 5.5 ){
                  echo $albumin;
              }else{
                  echo '<b>'.$albumin.'</b>';
              }
              ?>
          </div>
          <div class="col-sm-4">
              <p>3.5 to 5.5 mg/dl</p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              Globulin :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php
              if($globulin >= 1.5 && $globulin <= 3.0 ){
                  echo $globulin;
              }else{
                  echo '<b>'.$globulin.'</b>';
              }
              ?>
          </div>
          <div class="col-sm-4">
              <p>1.5 to 3.0 mg/dl</p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              SGOT :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php
              if($sgot > 5 && $sgot < 40 ){
                  echo $sgot;
              }else{
                  echo '<b>'.$sgot.'</b>';
              }
              ?>
          </div>
          <div class="col-sm-4">
              <p>5 to 40 units/ml</p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              SGPT :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php
              if($sgpt < 35 && $sgpt >5 ){
                  echo $sgpt;
              }else{
                  echo '<b>'.$sgpt.'</b>';
              }
              ?>
          </div>
          <div class="col-sm-4">
              <p>5 to 40 units/ml</p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              SERUM ALKALINE PHOSPHATE :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php
              if($sap < 11 && $sap > 4 ){
                  echo $sap;
              }else{
                  echo '<b>'.$sap.'</b>';
              }
              ?>
          </div>
          <div class="col-sm-4">
              <p>4 to 11 KA units</p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row">
          <div class="col-sm-4 text-right">
              Hbs Ag Australia Antigen :
          </div>
          <div class="col-sm-4 text-center mx-auto">
              <?php echo $hbsag; ?>
          </div>
          <div class="col-sm-4">
              <p></p>
          </div>
          <hr style="width:100%">
      </div>

      <div class="row" style="position:relative; top:20px; margin:20px;">

        <div class="col-8 text-left mx-auto" >
          Report with thanks to <b> <?php echo $doctor_details ?> </b>
        </div>
        <div class="col-4 text-center mx-auto" style="margin-left:20px;" >
          <b>Pathologist</b>
          <p><b>DR.K. GOPINATH, MBBS DCP</b></p>
        </div>
      </div>

      <div class="row mx-auto " style="position:relative; top:0px; margin:50px;">
        <p>This is an electronically authenticated report. Report Printed Date : <b> <?php echo date("d-m-Y") ?> </b></p>
        <p>NOTE : Assay results should be correlated clinically with other clinical findings and the total clinical status of the patient</p>
      </div>

  </div>
</body>
<script src="../js/jquery-3.3.1.slim.min.js" ></script>
<script src="../js/popper.min.js" ></script>
<script src="../js/bootstrap.min.js" ></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
