<?php

require '../inc/db.init.php';
//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "COMPLETE HAEOMOGRAM";
$report_link = "completehaemogram";
$class = "";

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

  $data_bc = $database->get("completehaemogram",
  [
    "drid", "pid", "tec", "heamoglobin", "neutrophils", "pcv", "mcv", "mch",
	  "monocytes", "mchc", "basophils", "reticculolytes", "tlc", "immaturecells", "platletscount",
	  "esr", "parasites", "bleedingtime", "ppd", "clottingtime", "eisnophils", "sickling", "create_date"
  ],
  [
    "id" => $id
  ]);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $tec = $data_bc['tec'];
  $heamoglobin = $data_bc['heamoglobin'];
  $neutrophils = $data_bc['neutrophils'];
  $pcv = $data_bc['pcv'];
  $mcv = $data_bc['mcv'];
  $mch = $data_bc['mch'];
  $monocytes= $data_bc['monocytes'];
  $mchc= $data_bc['mchc'];
  $basophils =  $data_bc['basophils'];
  $reticculolytes = $data_bc['reticculolytes'];
  $tlc = $data_bc['tlc'];
  $immaturecells = $data_bc['immaturecells'];
  $platletscount = $data_bc['platletscount'];
  $esr = $data_bc['esr'];
  $parasites = $data_bc['parasites'];
  $bleedingtime = $data_bc['bleedingtime'];
  $ppd= $data_bc['ppd'];
  $clottingtime =  $data_bc['clottingtime'];
  $eisnophils = $data_bc['eisnophils'];
  $sickling =  $data_bc['sickling'];

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


  <div class="row ">
    <div class="col-sm-12 text-center mx-auto report_header">
      <h4 ><b><?= $testname ?></b></h4>
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
  <!-- Doctor Details -->
  <div class="row mx-auto text-uppercase" style="padding:10px;">
    <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
      Referred By &nbsp&nbsp
    </div>
    <div class="col-sm-4 text-left">
        : &nbsp <b><?php  echo $drinitials." ".$drfirstname." ".$drsurname; ?></b>,
        (<?php  echo $drqualification; ?>)</b>
    </div>

  </div>


  <!-- Columns -->
  <div class="row text-center ">
    <div class="column_header col-sm-4 text-center mx-auto" >
        <b>TEST DESCRIPTION</b>
    </div>
    <div class="column_header col-sm-4 text-center mx-auto column-header " >
        <b>RESULT</b>
    </div>
    <div class="column_header col-sm-4 text-center mx-auto column-header ">
        <b>REFERENCES</b>
    </div>
  </div>

    <!-- REPORT COLUMN HEADING -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          TOTAL ERYTHROCYTE COUNT
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?php echo $tec ?> millions/cumm
        </div>
        <div class="col-sm-4 text-left mx-auto">
          M : 4.2-6.5 / F: 3.9-5.5
        </div>
    </div>

    <!-- HAEMOGLOBIN -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          HAEMOGLOBIN
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?php

          if($sex_code == "mars"){
            //male
            if($heamoglobin< 13 || $heamoglobin > 18){
              echo '<b>'.$heamoglobin.' gm% </b>';
            }else{
              echo $heamoglobin.' gm%';
            }
          }else{
            //female
            if($heamoglobin< 11.5 || $heamoglobin > 16.2){
              echo '<b>'.$heamoglobin.' gm% </b>';
            }else{
              echo $heamoglobin.' gm%';
            }
          }
          ?>
        </div>
        <div class="col-sm-4 text-left mx-auto">
          M : 13-18 / F : 11.5-16.2
        </div>
    </div>

    <!--   P.C.V. (%) -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          P.C.V. (%)
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?php echo $pcv ?>
        </div>
        <div class="col-sm-4 text-left mx-auto">
          M : 40-55 / F : 35-47
        </div>
    </div>

      <!--   M.C.V. (femolitres) -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          M.C.V. (femolitres)
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?php echo $mcv ?>
        </div>
        <div class="col-sm-4 text-left mx-auto">
          75-97
        </div>

    </div>

    <!--   M.C.H. (picograms) -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          M.C.H. (picograms)
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?php echo $mch ?>
        </div>
        <div class="col-sm-4 text-left mx-auto">
          27-32
        </div>

    </div>

    <!-- M.C.H.C. (%) -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          M.C.H.C. (%)
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?php echo $mchc ?>
        </div>
        <div class="col-sm-4 text-left mx-auto">
          32-36
        </div>
    </div>

    <!-- RETICCULOCYTES -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          RETICCULOCYTES
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?php echo $reticculolytes ?>
        </div>
        <div class="col-sm-4 text-left mx-auto">
          0.2-2
        </div>
    </div>

    <!-- TOTAL LEUCOCYTE count -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          TOTAL LEUCOCYTE count
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?= $tec ?>
        </div>
        <div class="col-sm-4 text-left mx-auto">
          ADULT : 4,000 - 11,000 / cu mm
        </div>
    </div>

    <!-- DIFFERENTIAL LEUCOCYTE COUNT -->
    <div class="row text-center ">
      <div class="column_header col-sm-4 text-center mx-auto" >
          <b>DIFFERENTIAL LEUCOCYTE COUNT</b>
      </div>
      <div class="column_header col-sm-4 text-center mx-auto column-header " >
          <b>RESULT</b>
      </div>
      <div class="column_header col-sm-4 text-center mx-auto column-header ">
          <b>REFERENCES</b>
      </div>
    </div>


    <!-- NEUTROPHILS -->
    <div class="row">
        <div class="col-sm-3 offset-sm-1">
          NEUTROPHILS
        </div>
        <div class="col-sm-3 offset-sm-1">
          <?= $neutrophils ?>
        </div>
        <div class="col-sm-2 text-left offset-sm-1">
          (40-75)%
        </div>
    </div>

    <!-- LYMPHOCYTES -->
    <div class="row">
      <div class="col-sm-3 offset-sm-1">
        LYMPHOCYTES
      </div>
      <div class="col-sm-3 offset-sm-1">
        <?= $neutrophils ?>
      </div>
      <div class="col-sm-2 text-left offset-sm-1">
        (20-45)%
      </div>
    </div>

    <!-- EOSINOPHILS -->
    <div class="row">
      <div class="col-sm-3 offset-sm-1">
        EOSINOPHILS
      </div>
      <div class="col-sm-3 offset-sm-1">
        <?= $eisnophils ?>
      </div>
      <div class="col-sm-2 text-left offset-sm-1">
        (1-6) %
      </div>
    </div>

    <!-- MONOCYTES -->
    <div class="row">
      <div class="col-sm-3 offset-sm-1">
        MONOCYTES
      </div>
      <div class="col-sm-3 offset-sm-1">
        <?= $monocytes ?>
      </div>
      <div class="col-sm-2 text-left offset-sm-1">
        (2-10) %
      </div>
    </div>

    <!-- BASOPHILS -->
    <div class="row">
      <div class="col-sm-3 offset-sm-1">
        BASOPHILS
      </div>
      <div class="col-sm-3 offset-sm-1">
        <?= $basophils ?>
      </div>
      <div class="col-sm-2 text-left offset-sm-1">
        (0-1) %
      </div>
    </div>

    <!--   Bleeding time -->
    <div class="row">
      <div class="col-sm-3 offset-sm-1 text-uppercase">
        Immature Cells
      </div>
      <div class="col-sm-3 offset-sm-1">
        <?= $immaturecells ?>
      </div>
      <div class="col-sm-2 text-left offset-sm-1">
        (0-1) %
      </div>
    </div>

    <!--   Bleeding time -->
    <div class="row">
      <div class="col-sm-3 offset-sm-1 text-uppercase">
          Bleeding time
      </div>
      <div class="col-sm-3 offset-sm-1">
        <?= $bleedingtime ?>
      </div>
      <div class="col-sm-2 text-left offset-sm-1">
        (2-7) mins
      </div>
    </div>

    <!--  Clotting Time -->
    <div class="row">
      <div class="col-sm-3 offset-sm-1 text-uppercase">
        Clotting Time
      </div>
      <div class="col-sm-3 offset-sm-1">
        <?= $clottingtime ?>
      </div>
      <div class="col-sm-2 text-left offset-sm-1">
        (5-11) mins
      </div>
    </div>

    <!--  Platlets Time -->
    <div class="row">
      <div class="col-sm-3 offset-sm-1 text-uppercase">
        Platlets Count
      </div>
      <div class="col-sm-3 offset-sm-1">
        <?= $platletscount ?>
      </div>
      <div class="col-sm-2 text-left offset-sm-1">
        (1.5-4.0) Lacs
      </div>
    </div>

    <!-- ABNORMALATIES OF ERITHROCYTE -->
    <div class="row">
        <div class="col-sm-8 text-center column_header">
          <b>ABNORMALATIES OF ERITHROCYTE</b>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 text-center mx-auto">
          MICROSYSTOSIS
        </div>
        <div class="col-sm-4 text-center mx-auto">
          MACROSYSTOSIS
        </div>
        <div class="col-sm-4 text-center mx-auto">
          ANISOSYSTOSIS
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 text-center mx-auto">
          SPHEROCYTES
        </div>
        <div class="col-sm-4 text-center mx-auto">
          HYPOCHROMIA
        </div>
        <div class="col-sm-4 text-center mx-auto">
          POLYCHROMOTOPHILIA
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 text-center mx-auto">
          TARGET CELLS
        </div>
        <div class="col-sm-4 text-center mx-auto">
          POLYCYSTOSIS
        </div>
        <div class="col-sm-4 text-center mx-auto">
          BASOPHILIC STIPLING
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 text-center mx-auto">
          SICKLING
        </div>
        <div class="col-sm-4 text-center mx-auto">
          <?= $sickling ?>
        </div>
        <div class="col-sm-4 text-center mx-auto">
          After 12 hours
        </div>

    </div>
    <div class="row">
        <div class="col-sm-4 text-center mx-auto">
          PARASITES (MP)
        </div>
        <div class="col-sm-4 text-center mx-auto">
          <?= ($parasites == 1 ? "<b>SEEN</b>" : "NOT SEEN") ?>
        </div>
        <div class="col-sm-4 text-center mx-auto">

        </div>
    </div>

    <div class="row">
        <div class="col-sm-8 text-center column_header">
          <b>ABNORMALATIES OF LEUCOCYTES</b>
        </div>
      <hr style="width:100%">
    </div>

    <div class="row">
        <div class="col-sm-4 text-center mx-auto">
          E.S.R. (westergren)
        </div>
        <div class="col-sm-3 text-center mx-auto">
          <?= $esr ?>
        </div>
        <div class="col-sm-4 text-left ">
          mm at the end of 1 hr <br>
          Male   : 0-15 mm at the end of 1 hour <br>
          Female : 0-20 mm at the end of 1 hour <br>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 text-center mx-auto">
          PPD Test
        </div>
        <div class="col-sm-4 text-center mx-auto">
          <?= $ppd ?>
        </div>
        <div class="col-sm-4 text-center mx-auto">
          After 48 hours
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 text-center mx-auto">
          REMARKS
        </div>
        <div class="col-sm-4 text-center mx-auto">

        </div>
        <div class="col-sm-4 text-center mx-auto">

        </div>
    </div>

    <br>
    <div class="row" style="position:relative; ">
      <div class="col-8 text-left mx-auto" >
        Report with thanks to <b> <?php echo $doctor_details ?> </b>
      </div>
      <div class="col-4 text-center mx-auto">
        <b>Pathologist</b>
      </div>
    </div>
    <div class="row mx-auto" style="position:relative; ">

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
      window.location.href = 'http://localhost/pathoapp/listreport.php?type=<?= $class ?>';
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
