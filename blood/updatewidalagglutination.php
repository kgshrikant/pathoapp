<?php

// initialize Medoo
require '../inc/db.init.php';

//initialize variables
$id = "";
$styphio = "";
$styphih = "";
$styphiah = "";
$styphibh = "";
$drid = "";
$report_link = "widalagglutination";
// get results
if($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = $_POST['id'];
  $styphio = $_POST['o1'].$_POST['o2'].$_POST['o3'].$_POST['o4'].$_POST['o5'].$_POST['o6'];
  $styphih = $_POST['h1'].$_POST['h2'].$_POST['h3'].$_POST['h4'].$_POST['h5'].$_POST['h6'];
  $styphiah = $_POST['ah1'].$_POST['ah2'].$_POST['ah3'].$_POST['ah4'].$_POST['ah5'].$_POST['ah6'];
  $styphibh = $_POST['bh1'].$_POST['bh2'].$_POST['bh3'].$_POST['bh4'].$_POST['bh5'].$_POST['bh6'];
  $drid = $_POST['drid'];
  echo var_dump($_POST);
  //update statement
  $data = $database->update("widalagglutination",
    [
    "styphio" => "{$styphio}",
    "styphih" => "{$styphih}",
    "styphiah" => "{$styphiah}",
    "styphibh" => "{$styphibh}",
    "drid" => "{$drid}"
    ],
    [
      "id[=]" => $id
    ]);

    $data_report = $database->get("report",
    ["rid"],
    ["class_type" => "widalagglutination", "class_id" => "{$id}" ]);

    $rid = $data_report["rid"];
    echo $rid;
  // Returns the number of rows affected by the last SQL statement
  //echo $data->rowCount();
}

  header("Location: viewwidalagglutination.php?rid=$rid");

 ?>
