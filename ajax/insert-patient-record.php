<?php
require '../inc/db.init.php';
// Check connection

//Create variables
$firstname = $_POST['firstname'];
$surname = $_POST['surname'];
//$fullname = $firstname." ".$surname;
$age = $_POST['age'];
$sex = $_POST['sex'];
$initials = $_POST['initials'];

$database->insert("patient",
[
  "initials"=>"{$initials}",
  "firstname"=>"{$firstname}",
  "surname"=>"{$surname}",
  "age"=>"{$age}",
  "sex"=>"{$sex}"
]);

echo $database->id();

?>
