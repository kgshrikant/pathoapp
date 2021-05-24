<?php
require '../inc/db.init.php';
//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "BLOOD CHEMISTRY";
$report_link = "bloodsugarbiochemistry";

$bsf = "";
$usf = "";
$bspp = "";
$uspp = "";
$bspr = "";
$uspr = "";

$class_id = "";
$message_result = "";

// patient details
$initials =  "";
$firstname =  "";
$surname =  "";
$sex =  "";
$age =  "";
$patient_details =  "";

$report_create_date = date("Y/m/d");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "hello world";
    //echo var_dump($_POST);
    $pid = $_POST['pid'];
    $drid = $_POST['drid'];
    $bsf = $_POST['bsf'];
    $usf = $_POST['usf'];
    $bspp = $_POST['bspp'];
    $uspp = $_POST['uspp'];
    $bspr = $_POST['bspr'];
    $uspr = $_POST['uspr'];

    $database->insert("{$report_link}",
    [
      "drid"=>"{$drid}", "pid"=>"{$pid}", "bsf"=>"{$bsf}", "usf"=>"{$usf}",
      "bspp"=>"{$bspp}", "uspp"=>"{$uspp}", "bspr"=>"{$bspr}", "uspr"=>"{$uspr}"
    ]);

    // get id of recently inserted bloodchemistry
    $class_id = $database->id();

    $class_type = $report_link;
    $class = 'blood';

    $database->insert("report",
    [
      "class_type"=>"{$class_type}", "class"=>"{$class}",
      "pid"=>"{$pid}", "class_id"=>"{$class_id}"
    ]);
    // get id of recently inserted report
    $rid = $database->id();
    header("Location: view$class_type.php?rid=$rid");
}

?>
