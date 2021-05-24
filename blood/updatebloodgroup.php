<?php

// initialize Medoo
require '../inc/db.init.php';

//initialize variables
$id = "";
$bgtype = "";
$rhfactor = "";
$rid = "";

// get results
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];
  $bgtype = $_POST['bgtype'];
  $rhfactor = $_POST['bgrhfactor'];
  $drid = $_POST['drid'];
  //echo var_dump($_POST);
  //update statement
  $data = $database->update("bloodgroup",
    [
    "bgtype" => "{$bgtype}",
    "rhfactor" => "{$rhfactor}",
    "drid" => "{$drid}"
    ],
    [
      "id[=]" => $id
    ]);

    $data_report = $database->get("report",
    ["rid"],
    ["class_type" => "bloodgroup", "class_id" => "{$id}" ]);

    $rid = $data_report["rid"];
  // Returns the number of rows affected by the last SQL statement
  //echo $data->rowCount();
}
  header("Location: http://localhost/pathoapp/blood/viewbloodgroup.php?rid=$rid");

 ?>
