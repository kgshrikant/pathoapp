<?php

require '../inc/db.init.php';


//fetch.php;
$pid = "";
$age = "";
$sex = "";
$fullname = "";

//echo "<br>";
$patient_list = array();
$output = '<ul class="list-unstyled">';

if(isset($_POST['query'])){
  $query = strtoupper($_POST['query']);

  $data_patient = $database->select("patient","*",
  ["OR" =>
    [
      "firstname[~]" => "{$query}",
      "surname[~]" => "{$query}"
    ]
  ]);

  foreach($data_patient as $patient) {
      $pid = $patient["pid"];
      $age = $patient["age"];
      $sex = $patient["sex"];
      $firstname = $patient["firstname"];
      $surname = $patient["surname"];
      $initials = $patient['initials'];

      $fullname = $initials." ".$firstname.",".$surname.",".$sex .",".$age;
      $complete = $pid.",".$fullname ;
      $patient_list[] = array("complete" => $complete,"fullname"=> $fullname);
      //echo $pid." ".$fullname."<br/>";
      $output .= '<li>'.$complete.'</li>';
  }

  if(count($patient_list) == 0 ){
      $output .= '<li> Patient Not Found </li>';
  }
  $output .= '</ul>';
}

echo $output;
?>
