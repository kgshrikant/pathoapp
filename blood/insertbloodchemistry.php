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
$bsf = "";
$usf = "";
$bspp = "";
$uspp = "";
$bsr = "";
$usr = "";
$bloodurea= "";
$serumcholestrol = "";
$hdl = "";
$serumuricacid = "";
$serumtry = "";
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

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "hello world";
    //echo var_dump($_POST);
    $pid = $_POST['pid'];
    $drid = $_POST['drid'];
    $bsf = $_POST['bsf'];
    $usf = $_POST['usf'];
    $bspp = $_POST['bspp'];
    $uspp = $_POST['uspp'];
    $bsr = $_POST['bsr'];
    $usr = $_POST['usr'];
    $bloodurea= $_POST['bloodurea'];
    $serumcholestrol = $_POST['serumcholestrol'];
    $hdl = $_POST['hdl'];
    $serumuricacid = $_POST['serumuricacid'];
    $serumtry = $_POST['serumtry'];

    $database->insert("bloodchemistry",
    [
      "drid"=>"{$drid}", "pid"=>"{$pid}", "bsf"=>"{$bsf}", "usf"=>"{$usf}", "bspp"=>"{$bspp}", "bsr"=>"{$bsr}",
      "uspp"=>"{$uspp}", "bsr"=>"{$bsr}", "usr"=>"{$usr}", "bloodurea"=>"{$bloodurea}", "serumcholestrol"=>"{$serumcholestrol}",
      "hdl"=>"{$hdl}", "serumuricacid"=>"{$serumuricacid}", "serumtry"=>"{$serumtry}"
    ]);

    // get id of recently inserted bloodchemistry
    $class_id = $database->id();

    // inserting into reports table
    $class_type = 'bloodchemistry';
    $class = 'blood';

    $database->insert("report",
    [
      "class_type"=>"{$class_type}", "class"=>"{$class}", "pid"=>"{$pid}", "class_id"=>"{$class_id}"
    ]);
    // get id of recently inserted report
    $rid = $database->id();

    header("Location: viewbloodchemistry.php?rid=$rid");
}

?>
