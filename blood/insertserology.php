<?php
//include '../inc/header.php';
require '../inc/db.init.php';

$pid = "";
$drid = "";
$hiv1 = "";
$hiv2 = "";
$vdrl = "";
$hbsag = "";
$anti_hcv = "";

$message_result = "";
$report_id = "";
$message_result = "";
$report_create_date = "";
$sex_code = "";
$report_link = "serology";

  echo var_dump($_POST);
if($_SERVER["REQUEST_METHOD"] == "POST"){

//  echo var_dump($_POST);
  //patient id details
  $pid = $_POST['pid'];
  $drid = $_POST['drid'];
  $hiv1 = $_POST['hiv1'];
  $hiv2 = $_POST['hiv2'];
  $vdrl = $_POST['vdrl'];
  $hbsag = $_POST['hbsag'];
  $anti_hcv = $_POST['anti_hcv'];

// insert query to bloodgroup table

  $database->insert("serology",
  [
    "drid"=>"{$drid}",
    "pid"=>"{$pid}",
    "hiv1"=>"{$hiv1}",
    "hiv2"=>"{$hiv2}",
    "vdrl"=>"{$vdrl}",
    "hbsag"=>"{$hbsag}",
    "anti_hcv"=>"{$anti_hcv}",

  ]);

  $class_id = $database->id();
  $class_type = 'serology';
  $class = 'blood';

  $database->insert("report",
  [
    "class_type"=>"{$class_type}",
    "class"=>"{$class}",
    "pid"=>"{$pid}",
    "class_id"=>"{$class_id}",
  ]);

  $rid = $database->id();

}

  header("Location: view{$report_link}.php?rid={$rid}");
?>
