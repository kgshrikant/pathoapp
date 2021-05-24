<?php
require '../inc/db.init.php';
//form fields
$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "widalagglutination";

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
echo var_dump($_POST);
if($_SERVER["REQUEST_METHOD"] == "POST") {

  //echo var_dump($_POST);
  $pid = $_POST['pid'];
  $drid = $_POST['drid'];


  $qualitywt = $_POST['qualitywt'];
  $styphio = $_POST['o1'].$_POST['o2'].$_POST['o3'].$_POST['o4'].$_POST['o5'].$_POST['o6'];

  $styphih = $_POST['h1'].$_POST['h2'].$_POST['h3'].$_POST['h4'].$_POST['h5'].$_POST['h6'];

  $styphiah = $_POST['ah1'].$_POST['ah2'].$_POST['ah3'].$_POST['ah4'].$_POST['ah5'].$_POST['ah6'];

  $styphibh = $_POST['bh1'].$_POST['bh2'].$_POST['bh3'].$_POST['bh4'].$_POST['bh5'].$_POST['bh6'];

  $database->insert("widalagglutination",
  [
    "drid"=>"{$drid}", "pid"=>"{$pid}", "qualitative"=>"{$qualitywt}",
    "styphio"=>"{$styphio}", "styphih"=>"{$styphih}", "styphiah"=>"{$styphiah}",
    "styphibh"=>"{$styphibh}"
  ]);

  /*
  , "quantitywt"=>"{$quantitywt}",
  "styphio"=>"{$styphio}" , "styphih"=>"{$styphih}",
  "styphiah"=>"{$styphiah}" , "styphibh"=>"{$styphibh}"
  */

  // get id of recently inserted bloodchemistry
  $class_id = $database->id();
  //echo $class_id."<br>";
  // inserting into reports table
  $class_type = 'widalagglutination';
  $class = 'blood';


  $database->insert("report",
  [
    "class_type"=>"{$class_type}", "class"=>"{$class}", "pid"=>"{$pid}", "class_id"=>"{$class_id}"
  ]);
  // get id of recently inserted report
  $rid = $database->id();

  //echo "<br>widalagglutination Id: {$class_id} <br>";
  //echo "Report Id: {$rid} <br>";

  /*
  $data_patient = $database->get("patient",
  ["pid","firstname","surname","sex","age","initials"],
  ["pid" => $pid
  ]);

  $initials = $data_patient['initials'];
  $firstname = $data_patient['firstname'];
  $surname = $data_patient['surname'];
  $sex = $data_patient['sex'];
  $age = $data_patient['age'];
  $patient_details = "initials: " . $initials. ", Name: " . $firstname. " " . $surname. ", sex: ". $sex. ", age: ".$age;

  $data_doctor = $database->get("doctor",
  ["initials","firstname","surname","qualification"],
  ["drid" => $drid ]);

  $drinitials = $data_doctor['initials'];
  $drfirstname = $data_doctor['firstname'];
  $drsurname = $data_doctor['surname'];
  $drqualification = $data_doctor['qualification'];
  $doctor_details = $drinitials. "." . $drfirstname. " " . $drsurname. " ". $drqualification;
  */

  header("Location: viewwidalagglutination.php?rid=$rid");
}

?>
