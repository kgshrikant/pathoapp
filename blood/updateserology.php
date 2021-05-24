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
  $drid = $_POST['drid'];
  $hiv1 = $_POST['hiv1'];
  $hiv2 = $_POST['hiv2'];
  $vdrl = $_POST['vdrl'];
  $hbsag = $_POST['hbsag'];
  $anti_hcv = $_POST['anti_hcv'];
  echo var_dump($_POST);
  //update statement
  $data = $database->update("serology",
    [
    "hiv1" => "{$hiv1}",
    "hiv2" => "{$hiv2}",
    "vdrl" => "{$vdrl}",
    "hbsag" => "{$hbsag}",
    "anti_hcv" => "{$anti_hcv}",
    "drid" => "{$drid}"
    ],
    [
      "id[=]" => $id
    ]);

    $data_report = $database->get("report",
    ["rid"],
    ["class_type" => "serology", "class_id" => "{$id}" ]);

    $rid = $data_report["rid"];
  // Returns the number of rows affected by the last SQL statement
  //echo $data->rowCount();
}
  header("Location: http://localhost/pathoapp/blood/viewserology.php?rid=$rid");

 ?>
