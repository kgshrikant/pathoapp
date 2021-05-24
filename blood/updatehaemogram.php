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
$report_link = "haemogram";
// get results
if($_SERVER["REQUEST_METHOD"] == "POST") {

  //$pid = $_POST['pid'];
  $id = $_POST['id'];
  $drid = $_POST['drid'];
  $ldl = $_POST['ldl'];
  $hdl = $_POST['hdl'];
  $serumc = $_POST['serumc'];
  $serumt = $_POST['serumt'];
  //echo var_dump($_POST);
  //update statement

  $data = $database->update("{$report_link}",
    [
    "drid" => "{$drid}",
    "ldl" => "{$ldl}",
    "hdl" => "{$hdl}",
    "serumc" => "{$serumc}",
    "serumt" => "{$serumt}",
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
