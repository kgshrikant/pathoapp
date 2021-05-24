<?php
//include '../inc/header.php';
require '../inc/db.init.php';

$pid = "";
$drid = "";
$bgtype = "";
$bgrhfactor = "";
$message_result = "";
$report_id = "";
$message_result = "";
$report_create_date = "";
$sex_code = "";
$report_link = "bloodgroup";
//patient details
$initials = '';
$firstname = '';
$surname = '';
$sex = '';
$age = '';
//doctor details
$drinitials = '';
$drfirstname = '';
$drsurname = '';
$drqualification = '';
$doctor_details = '';


if($_SERVER["REQUEST_METHOD"] == "POST"){

  echo var_dump($_POST);
  //patient id details
  $pid = $_POST['pid'];
  $drid = $_POST['drid'];
  $bgtype = $_POST['bgtype'];
  $bgrhfactor = $_POST['bgrhfactor'];

// insert query to bloodgroup table

  $database->insert("bloodgroup",
  [
    "drid"=>"{$drid}",
    "pid"=>"{$pid}",
    "bgtype"=>"{$bgtype}",
    "rhfactor"=>"{$bgrhfactor}",
  ]);

  $class_id = $database->id();
  $class_type = 'bloodgroup';
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
