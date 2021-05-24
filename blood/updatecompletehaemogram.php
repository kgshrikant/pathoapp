<?php

// initialize Medoo
require '../inc/db.init.php';

//initialize variables

$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "COMPLETE HAEMOGRAM";
$report_link = "completehaemogram";

//initializing variables
$id = "";
$drid = "";
$sodium = "";
$potassium = "";
$calcium = "";
$message_result = "";
$report_create_date = date("d/m/Y");

// get results
if($_SERVER["REQUEST_METHOD"] == "POST") {

  //$pid = $_POST['pid'];
  $id = $_POST['id'];
  $drid = $_POST['drid'];
  $tec = $_POST['tec'];
  $heamoglobin = $_POST['heamoglobin'];
  $neutrophils = $_POST['neutrophils'];
  $pcv = $_POST['pcv'];
  $mcv = $_POST['mcv'];
  $mch = $_POST['mch'];
  $monocytes = $_POST['monocytes'];
  $mchc = $_POST['mchc'];
  $basophils = $_POST['basophils'];
  $reticculolytes = $_POST['reticculolytes'];
  $tlc = $_POST['tlc'];
  $immaturecells = $_POST['immaturecells'];
  $platletscount = $_POST['platletscount'];
  $esr = $_POST['esr'];
  $parasites = $_POST['parasites'];
  $bleedingtime = $_POST['bleedingtime'];
  $ppd = $_POST['ppd'];
  $clottingtime = $_POST['clottingtime'];
  $eisnophils = $_POST['eisnophils'];
  echo var_dump($_POST);
  //update statement

  $data = $database->update("{$report_link}",
    [
      "drid" => "{$drid}",
      "tec" => "{$tec}",
      "heamoglobin" => "{$heamoglobin}",
      "neutrophils" => "{$neutrophils}",
      "pcv" => "{$pcv}",
      "mcv" => "{$mcv}",
      "mch" => "{$mch}",
      "monocytes" => "{$monocytes}",
      "mchc" => "{$mchc}",
      "basophils" => "{$basophils}",
      "reticculolytes" => "{$reticculolytes}",
      "tlc" => "{$tlc}",
      "immaturecells" => "{$immaturecells}",
      "platletscount" => "{$platletscount}",
      "esr" => "{$esr}",
      "parasites" => "{$parasites}",
      "bleedingtime" => "{$bleedingtime}",
      "ppd" => "{$ppd}",
      "clottingtime" => "{$clottingtime}",
      "eisnophils" => "{$eisnophils}",
    ],
    [
      "id[=]" => $id
    ]);

    $error_db = $database->error() ;
    echo $error_db[2];

    $data_report = $database->get("report",
    ["rid"],
    ["class_type" => "{$report_link}", "class_id" => "{$id}" ]);

    $rid = $data_report["rid"];
    echo $rid;
  // Returns the number of rows affected by the last SQL statement
  //echo $data->rowCount();
}

  header("Location: view$report_link.php?rid=$rid");

 ?>
