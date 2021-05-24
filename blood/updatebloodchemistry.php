<?php

// initialize Medoo
require '../inc/db.init.php';

//initialize variables
$id="";
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
$serumcreatine = "";
$hdl = "";
$serumuricacid = "";
$serumtry = "";
$class_id = "";
$message_result = "";

$report_link = "bloodchemistry";
// get results
if($_SERVER["REQUEST_METHOD"] == "POST") {

  //$pid = $_POST['pid'];
  $id = $_POST['id'];
  $drid = $_POST['drid'];
  $drid = $_POST['drid'];
  $bsf = $_POST['bsf'];
  $usf = $_POST['usf'];
  $bspp = $_POST['bspp'];
  $uspp = $_POST['uspp'];
  $bsr = $_POST['bsr'];
  $usr = $_POST['usr'];
  $serumcreatine = $_POST['serumcreatine'];
  $bloodurea= $_POST['bloodurea'];
  $serumcholestrol = $_POST['serumcholestrol'];
  $hdl = $_POST['hdl'];
  $serumuricacid = $_POST['serumuricacid'];
  $serumtry = $_POST['serumtry'];
  echo var_dump($_POST);
  //update statement

  $data = $database->update("{$report_link}",
    [
    "drid" => "{$drid}",
    "bsf" => "{$bsf}",
    "usf" => "{$usf}",
    "bspp" => "{$bspp}",
    "uspp" => "{$uspp}",
    "bsr" => "{$bsr}",
    "usf" => "{$usf}",
    "uspp" => "{$uspp}",
    "bsr" => "{$bsr}",
    "usr" => "{$usr}",
    "serumcreatine" => "{$serumcreatine}",
    "bloodurea" => "{$bloodurea}",
    "serumcholestrol" => "{$serumcholestrol}",
    "hdl" => "{$hdl}",
    "serumuricacid" => "{$serumuricacid}",
    "serumtry" => "{$serumtry}"
    ],
    [
      "id[=]" => $id
    ]);

    $data_report = $database->get("report",
    ["rid"],
    ["class_type" => "bloodchemistry", "class_id" => "{$id}" ]);

    $rid = $data_report["rid"];
    echo $rid;
  // Returns the number of rows affected by the last SQL statement
  //echo $data->rowCount();
}

  header("Location: view$report_link.php?rid=$rid");

 ?>
