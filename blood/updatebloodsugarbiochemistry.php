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
$report_link = "bloodsugarbiochemistry";
$bsf = "";
$usf = "";
$bspp = "";
$uspp = "";
$bspr = "";
$uspr = "";

$class_id = "";
$message_result = "";


// get results
if($_SERVER["REQUEST_METHOD"] == "POST") {

  //$pid = $_POST['pid'];
  $id = $_POST['id'];
  $drid = $_POST['drid'];
  $bsf = $_POST['bsf'];
  $usf = $_POST['usf'];
  $bspp = $_POST['bspp'];
  $uspp = $_POST['uspp'];
  $bspr = $_POST['bspr'];
  $uspr = $_POST['uspr'];
  echo var_dump($_POST);
  //update statement

  $data = $database->update("{$report_link}",
    [
    "drid" => "{$drid}",
    "bsf" => "{$bsf}",
    "usf" => "{$usf}",
    "bspp" => "{$bspp}",
    "uspp" => "{$uspp}",
    "bspr" => "{$bspr}",
    "uspr" => "{$uspr}"
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
