<?php
$db_hostname='localhost';
$db_database='pathodb';
$db_username='root';
$db_password='';

$conn = mysqli_connect($db_hostname, $db_username,$db_password, $db_database);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
