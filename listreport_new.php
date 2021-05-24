<?php

require 'inc/db.init.php';
//require_once 'inc/connection.php';
$type="";
$type_query="";
if(isset($_GET['type'])) {
  $type = $_GET['type'];
  $type_query="and class_type = '".$type."'";
  //echo $type_query;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/all.css" >
    <link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico' />
    <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css" >

</head>

<body>
  <div class="container">
    <div class="">
      <div class="col-2">
        <a href="/pathoapp" class="btn">
          <i class="fas fa-home" style="font-size: 45px;" ></i></a>
        <a class="btn" id="btn-list" href="/pathoapp/listreport.php">
          <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
      </div>
    </div>
    <div class="text-center mx-auto">
      <h1>REPORTS</h1>
    </div>
    <table id="report-list" class="table table-striped table-bordered" >
      <thead>
        <tr class="text-center text-uppercase font-weight-bold">
            <th>REPORT ID</th>
            <th>PATIENT</th>
            <th>REPORT TYPE</th>
            <th>DATE</th>
            <th>ACTION</th>
        </tr>
      </thead>
      <tbody>

      <?php
      // list query for sql
      $data_report = $database->select("report", [
        "[><]patient" => ["report.pid" => "pid"]
      ], [
      	"report.rid", "patient.initials", "patient.firstname", "patient.surname",
        "report.class_type", "report.class", "report.create_date"
        //"LIMIT" => 10
      ],[
        "LIMIT" => 1000,
        "ORDER" => ["report.rid" => "DESC"]
      ]);

      //var_dump($database->log());
      //var_dump($data_report);
      //var_dump($error_db);
      foreach($data_report as $report) : ?>
        <tr>
            <td class="text-center"><?= $report["rid"] ?></td>
            <td class="text-right"><?= $report["initials"] ?> <?= $report["firstname"] ?> <?= $report["surname"] ?></td>
            <td class="text-center"><?= $report["class_type"] ?></td>
            <td class="text-center"><?= date("l d/m/Y",strtotime($report['create_date'])) ?></td>
            <td>
              <a class="btn btn-primary"
              href="<?=$report["class"]?>/view<?= $report["class_type"]?>.php?rid=<?= $report["rid"] ?>"
              role="button" target="_blank"><i class="fa fa-eye"></i> View</a>
              <a class="btn btn-secondary"
              href="<?=$report["class"]?>/edit<?= $report["class_type"]?>.php?rid=<?= $report["rid"] ?>"
              role="button" target="_blank"><i class="fa fa-edit"></i> Edit</a>
              <a class="btn btn-danger delete disabled"  href="#" role="button"><i class="fa fa-trash"></i> Delete</a>
            </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th>REPORT ID</th>
          <th>PATIENT</th>
          <th>REPORT TYPE</th>
          <th>DATE</th>
          <th>ACTION</th>
        </tr>
        </tfoot>
    </table>
    <!-- Page Content  -->
    </div>
  </div>
  </div>
  <script src="js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#report-list').DataTable(
        {
            "order": [[ 0, "desc" ]]
        }
      );
      $("a.delete").click(function(){
        //alert('hello');
        if (!confirm("Do you want to delete")){
          return false;
        }
      });
    });
  </script>
</body>
</html>
