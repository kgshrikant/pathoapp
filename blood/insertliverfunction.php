<?php
require '../inc/db.init.php';
//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "LIVER FUNCTION";
$report_link = "liverfunction";
$class = "blood";
$class_id = "";
$message_result = "";


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


    $database->insert("{$report_link}",
    [
    "drid"=>"{$drid}", "pid"=>"{$pid}",  "sbt"=>"{$sbt}", "conjugated"=>"{$conjugated}",
    "unconjugated"=>"{$unconjugated}", "spt"=>"{$spt}",  "albumin"=>"{$albumin}", "globulin"=>"{$globulin}",
    "sgot"=>"{$sgot}", "sgpt"=>"{$sgpt}",  "sap"=>"{$sap}", "hbsag"=>"{$hbsag}"
    ]);

    // get id of recently inserted bloodchemistry
    $class_id = $database->id();
    echo $class_id . "<br>" ;

    //insert records into reports table
    if($class_id != null){
      $database->insert("report",
      [
        "class_type"=>"{$report_link}", "class"=>"{$class}", "pid"=>"{$pid}", "class_id"=>"{$class_id}"
      ]);
      // get id of recently inserted report
      $rid = $database->id();
      echo $rid;
    }


    header("Location: viewliverfunction.php?rid=$rid");
}
?>
