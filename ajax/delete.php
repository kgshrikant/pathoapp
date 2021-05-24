<?php
  require_once '../inc/connection.php';

  if($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $rid = $_GET['rid'];
    $sql = "SELECT * from report where rid = {$rid}";
    $result = $conn->query($sql);
    $class_id = "";
    $class_type = "";
    if ($result->num_rows > 0) {
          // output data of each row
        while($row = $result->fetch_assoc()) {
          $class_id = $row['class_id'];
          $class_type = $row['class_type'];
        }

        $sql_report = "delete from report where rid = {$rid}";
        //echo $sql_report."<br>";
        $result = $conn->query($sql_report);

        $sql_pathotable = "delete from {$class_type} where id = {$class_id}";
        //echo $sql_pathotable."<br>";
        $result = $conn->query($sql_pathotable);

    } else {
      $patient_details =  "0 results";
    }
    //closing the connection
    $conn->close();
    header("Location: http://localhost/pathoapp/listreport.php");
  }





 ?>
