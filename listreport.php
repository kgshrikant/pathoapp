<?php require_once 'inc/connection.php';
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
      $sql_list = "SELECT r.rid, p.initials, p.firstname, p.surname, r.class_type, r.class_id, r.class, r.create_date
      FROM report r, patient p where r.pid = p.pid ".$type_query." order by r.create_date desc";
      //echo $sql_list;
      $report_id = '';
      $patient_initials = '';
      $patient_fullname = '';
      $report_type = '';
      $report_date = '';
      $report_type_id = '';
      $report_group = '';
      $url = '';

      $result = $conn->query($sql_list);

      if ($result->num_rows > 0) {
            // output data of each row
        while($row = $result->fetch_assoc()) {
          $class = $row['class'];
          $report_id = $row['rid'];
          $class_type = $row['class_type'];
          $create_date = $row['create_date'];
          $class_id = $row['class_id'];
          $patient_name = $row["initials"].". ".$row["firstname"]." ".$row["surname"];
          //$report_group = $row['class'];
          $urlview = $class."/view".$class_type.".php?rid=".$report_id;
          $urledit = $class."/edit".$class_type.".php?rid=".$report_id;
          $delete = "ajax/delete.php?rid=".$report_id;
          echo "<tr class='text-center text-uppercase'>";
          echo "<td>$report_id</td>";
          echo "<td class='text-uppercase text-center'>$patient_name</td>";
          echo "<td class='text-uppercase text-center'>$class_type</td>";
          echo "<td>".date('d-m-Y h:i a', strtotime($create_date))."</td>";
          echo '<td>
          <a class="btn btn-primary" href="'.$urlview.'" role="button"
          target="_blank"><i class="fa fa-print"></i> Print</a>
          <a class="btn btn-success" href="'.$urledit.'" role="button"
          target="_blank"><i class="fa fa-eye"></i> Edit</a>
          <a class="btn btn-danger delete"  href="'.$delete.'" role="button"><i class="fa fa-trash"></i> Delete</a>
          </td>';
          echo "<tr>";
        }
      }
      $conn->close();
      ?>

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
      $('#report-list').DataTable();
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
