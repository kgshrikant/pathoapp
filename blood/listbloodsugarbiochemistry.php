<?php
include '../inc/connection.php';
// list query for sql
$sql_list = "SELECT r.rid, p.initials, p.firstname, p.surname, r.create_date
FROM report r inner join patient p where  p.pid = r.pid and r.class_type = 'bloodsugarbiochemistry'
order by create_date desc";

$result = $conn->query($sql_list);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>PATHOLAB</title>
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
  <!-- Our Custom CSS -->

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <!-- Google APIs -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- Font Awesome JS -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"></script>
</head>

<body>
  <div class="wrapper">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
          <a href="http://localhost/pathoapp/dashboard.php" class="btn">
            <i class="material-icons" style="font-size:45px; color: black;">home</i></a>
          <div>&nbsp</div>
          <div class="input-group mb-2">
            <input class="form-control" type="text" placeholder="Search Report by Report Id, Name .." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" id="patient-search" type="button">
                <i class="material-icons" style="font-size: 18px; color: grey;">person_search</i>
            </div>
          </div>
          <div class="input-group mb-2">
                &nbsp;<a class="btn" id="btn-list-bloodgroup" href="#">
                  <i class="material-icons" style="font-size:45px; color: black;">assignment</i> </a>
          </div>
      </nav>
      <div class="line"></div>

      <!-- patient details -->
      <div class="col-sm-10 text-center mx-auto">
          <br><br>
          <h4 class="display-5 "><ul>BLOOD SUGAR BIOCHEMISTRY</ul></h4>
      </div>
      <div id="list-reports">
        <table class="table table-striped table-bordered" id="bloodgroup-list-today" >
          <thead>
              <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>

          <?php
          $bgid = '';
          $initials = '';
          $firstname = '';
          $surname = '';
          $create_date = '';

          if ($result->num_rows > 0) {
                // output data of each row
              while($row = $result->fetch_assoc()) {
                $bsid = $row['rid'];
                $initials = $row['initials'];
                $firstname = $row['firstname'];
                $surname = $row['surname'];
                $create_date = $row['create_date'];

                echo "<tr>";
                echo "<td>$bsid </td>";
                echo "<td><b>$initials. $firstname $surname </b></td>";
                echo "<td> $create_date </td>";
                echo '<td>
                <a class="btn btn-primary" href="#" role="button"><i class="fa fa-print"></i> Print</a>
                <a class="btn btn-success" href="#" role="button"><i class="fa fa-eye"></i> View</a>
                <a class="btn btn-danger" href="#" role="button"><i class="fa fa-trash"></i> Delete</a>
                </td>';
                echo "<tr>";
              }
          }
          $conn->close();
          ?>

          </tbody>
          <tfoot>
              <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>

      </div>
    </div>
  </div>
  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">

  $(document).ready(function () {
    // show patient form
    $("#btn-show-patient-form").on("click", function () {
      $('#contact-form').toggle();
      $('#contact-form').show(200);
      $('#bloodgroup-list-today').hide(200);
    });

    // show blood group list
    $('#btn-list-bloodgroup').on("click", function () {
      $('#bloodgroup-list-today').toggle();
      $('#contact-form').hide(200);
    });

    //$('#bloodgroup-list-today').DataTable();
  });

  document.onkeydown = function(evt) {
      evt = evt || window.event;
      if (evt.keyCode == 27) {
          alert('Esc key pressed.');
          location.replace("https://www.w3schools.com");
      }
  };
  </script>
</body>

</html>
