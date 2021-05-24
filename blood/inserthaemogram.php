<?php
require '../inc/db.init.php';
//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "HAEMOGRAM";
$report_link = "haemogram";
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
    $tec = $_POST['tec'];
    $haemoglobin = $_POST['haemoglobin'];
    $neutrophils = $_POST['neutrophils'];
    $monocytes = $_POST['monocytes'];
    $basophils = $_POST['basophils'];
    $lymphocytes = $_POST['lymphocytes'];
    $tlc = $_POST['tlc'];
    $platletscount = $_POST['platletscount'];
    $esr = $_POST['esr'];
    $parasites = $_POST['parasites'];
    $bleedingtime = $_POST['bleedingtime'];
    $ppd = $_POST['ppd'];
    $clottingtime = $_POST['clottingtime'];
    $eosinophil = $_POST['eosinophil'];
    $sickling = $_POST['sickling'];

    $database->insert("haemogram",
    [
    "drid"=>"{$drid}", "pid"=>"{$pid}", "tec"=>"{$tec}", "haemoglobin"=>"{$haemoglobin}",
    "neutrophils"=>"{$neutrophils}", "eosinophil"=>"{$eosinophil}", "monocytes"=>"{$monocytes}",
    "basophils"=>"{$basophils}", "monocytes"=>"{$monocytes}", "esr"=>"{$esr}", "ppd"=>"{$ppd}",
    "platletscount"=>"{$platletscount}", "parasites"=>"{$parasites}", "lymphocytes"=>"{$lymphocytes}",
    "bleedingtime"=>"{$bleedingtime}", "clottingtime"=>"{$clottingtime}", "sickling"=>"{$sickling}",
    "tlc" => "{$tlc}",
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

    header("Location: viewhaemogram.php?rid=$rid");
}
?>
