<?php
require '../inc/db.init.php';

$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "LIPID PROFILE";
$report_link = "lipidprofile";
$class = "blood";
$class_id = "";
$message_result = "";

//form fields
$pid = "";
$drid = "";
$sodium = "";
$potassium = "";
$calcium = "";
$report_id = "";
$message_result = "";
$report_create_date = date("d/m/Y");

// patient details
$initials =  "";
$firstname =  "";
$surname =  "";
$sex =  "";
$age =  "";
$patient_details =  "";

//dr details
$drinitials = '';
$drfirstname = '';
$drsurname = '';
$drqualification = '';
$doctor_details = '';


$report_create_date = date("Y/m/d");
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //echo "hello world";
  //echo var_dump($_POST);
  $pid = $_POST['pid'];
  $drid = $_POST['drid'];
  $report_id = "";
  $message_result = "";
  $report_create_date = date("d/m/Y");

  $ldl = $_POST['ldl'];
  $hdl = $_POST['hdl'];
  $serumc = $_POST['serumc'];
  $serumt = $_POST['serumt'];

  $database->insert("{$report_link}",
  [
  "drid"=>"{$drid}", "pid"=>"{$pid}",  "ldl"=>"{$ldl}", "hdl"=>"{$hdl}",
  "serumc"=>"{$serumc}", "serumt"=>"{$serumt}",
  ]);

  // get id of recently inserted bloodchemistry
  $class_id = $database->id();
  //echo $class_id . "<br>" ;

  //insert records into reports table
  if($class_id != null) {
    $database->insert("report",
    [
      "class_type"=>"{$report_link}", "class"=>"{$class}", "pid"=>"{$pid}", "class_id"=>"{$class_id}"
    ]);
    // get id of recently inserted report
    $rid = $database->id();
    //echo $rid;
  }

  header("Location: viewlipidprofile.php?rid=$rid");
}
?>
