<?php

// initialize Medoo
require '../inc/db.init.php';

//initialize variables
$id = "";
$pid = "";
$drid = "";
$ldl = "";
$hdl = "";
$serumc = "";
$serumt = "";

$drid = "";
$report_link = "liverfunction";
// get results
if($_SERVER["REQUEST_METHOD"] == "POST") {

  //$pid = $_POST['pid'];
  $id = $_POST['id'];
  $drid = $_POST['drid'];
  //$message_result = '';
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

  echo var_dump($_POST);
  //update statement

  $data = $database->update("{$report_link}",
    [
    "drid" => "{$drid}",
    "sbt" => "{$sbt}",
    "conjugated" => "{$conjugated}",
    "unconjugated" => "{$unconjugated}",
    "spt" => "{$spt}",
    "albumin" => "{$albumin}",
    "globulin" => "{$globulin}",
    "sgot" => "{$sgot}",
    "sgpt" => "{$sgpt}",
    "sap" => "{$sap}",
    "hbsag" => "{$hbsag}",
    ],
    [
      "id[=]" => $id
    ]);

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
