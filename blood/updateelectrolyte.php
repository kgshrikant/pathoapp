<?php

// initialize Medoo
require '../inc/db.init.php';

//initialize variables

$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "ELECTROLYTE";
$report_link = "electrolyte";

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
  $sodium = $_POST['sodium'];
  $potassium = $_POST['potassium'];
  $calcium = $_POST['calcium'];
  //echo var_dump($_POST);
  //update statement

  $data = $database->update("{$report_link}",
    [
    "drid" => "{$drid}",
    "sodium" => "{$sodium}",
    "potassium" => "{$potassium}",
    "calcium" => "{$calcium}",
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
