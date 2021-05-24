<?php
require_once 'connection.php';

$sql = "SELECT drid, initials, firstname, surname from doctor";
$result = mysqli_query($con,$sql);
$doctor_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $drid = $row['drid'];
    $fullname = $row['initials'] + " " + $row['firstname']+ " " + $row['surname'];
    $doctor_arr[] = array("drid" => $drid, "name" => $fullname);
}
echo json_encode($doctor_arr);

?>
