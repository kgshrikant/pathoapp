<?php
require '../inc/db.init.php';
//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "COMPLETE HAEMOGRAM";
$report_link = "completehaemogram";
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
    $heamoglobin = $_POST['heamoglobin'];
    $neutrophils = $_POST['neutrophils'];
    $pcv = $_POST['pcv'];
    $mcv = $_POST['mcv'];
    $mch = $_POST['mch'];
    $monocytes = $_POST['monocytes'];
    $mchc = $_POST['mchc'];
    $basophils = $_POST['basophils'];
    $reticculolytes = $_POST['reticculolytes'];
    $tlc = $_POST['tlc'];
    $immaturecells = $_POST['immaturecells'];
    $platletscount = $_POST['platletscount'];
    $esr = $_POST['esr'];
    $parasites = $_POST['parasites'];
    $bleedingtime = $_POST['bleedingtime'];
    $ppd = $_POST['ppd'];
    $clottingtime = $_POST['clottingtime'];
    $eisnophils = $_POST['eisnophils'];

    //echo "<br> MCV {$mcv} <br>";
    $database->insert("completehaemogram",
    [
      "drid"=>"{$drid}", "pid"=>"{$pid}", "tec"=>"{$tec}", "heamoglobin"=>"{$heamoglobin}",
     "neutrophils"=>"{$neutrophils}", "pcv"=>"{$pcv}", "mcv"=>"{$mcv}", "mch"=>"{$mch}",
     "monocytes"=>"{$monocytes}", "mchc"=>"{$mchc}", "basophils"=>"{$basophils}", "reticculolytes"=>"{$reticculolytes}",
     "tlc"=>"{$tlc}", "immaturecells"=>"{$immaturecells}", "platletscount"=>"{$platletscount}",
     "esr"=>"{$esr}", "parasites"=>"{$parasites}", "bleedingtime"=>"{$bleedingtime}",
     "ppd"=>"{$ppd}", "clottingtime"=>"{$clottingtime}", "eisnophils"=>"{$eisnophils}"
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
    }




    echo $rid;
    header("Location: viewcompletehaemogram.php?rid=$rid");
}
?>
