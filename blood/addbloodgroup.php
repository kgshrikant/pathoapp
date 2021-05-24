<?php
require '../inc/db.init.php';
$report_link = "bloodgroup";
$data_doctor = $database->select("doctor",
["drid","initials","firstname","surname"],
["drid[>]" => 0]
);

$doctor_arr = array();
foreach($data_doctor as $doctor) {
    $drid = $doctor["drid"];
    $fullname = $doctor['initials']." ".$doctor['firstname']." ".$doctor['surname'];
    $doctor_arr[] = array("drid" => $drid, "fullname" => $fullname);
    //echo $drid." ".$fullname."<br/>";
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>PATHOLAB</title>

  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="../css/dashboard_style.css">
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <!-- fontawesome APIs -->
  <link rel="stylesheet" href="../css/all.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Bootstrap Tokenfield -->
  <link rel="stylesheet" href="../css/bootstrap-tokenfield.min.css">
  <style type="text/css">
    .heading{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .upper{
      text-transform: uppercase;
    }
    .form-group{
      margin-bottom: 0.2rem;
    }
    ul{
      background-color: #eee;
      cursor: pointer;
    }
    li{
      padding:12px;
    }
  </style>
</head>

<body>
  <div class="container">

    <!-- patient search page links and add Patient modal page -->
    <!-- patient details -->
    <?php include("../inc/search-add-patient.php"); ?>
    <br>
    <div class="row">
        <div class="col-sm-12 text-center mx-auto ">
            <h4 class="display-5 report_header" style=""><b>BLOOD GROUPING</b></h4>
        </div>
    </div>

    <div id="blood-group" style="display: block;">
      <form id="pathology-form" method="post" action="insertbloodgroup.php" role="form">
          <div class="messages"></div>
          <br><br>
          <div class="row">
            <div class="col-md-3 offet-md-2">
              <div class="form-group">
                  Ref By :
                  <select id="drid" name="drid" class="form-control">
                    <?php
                    foreach($doctor_arr as $doctor){
                       echo "<option value='".$doctor['drid']."' >".$doctor['fullname']."</option>";
                    }
                    ?>
                  </select>
              </div>
            </div>
              <div class="col-2">
                <div class="form-group">
                    <!--<input type="hidden" id="doctor-id" type="text" name="drid" value="1"  /> -->
                    <input type="hidden" id="patient-id" type="text" name="pid"  />
              </div>
            </div>
            <div class="col-2">
                <div class="form-group">

                  <p></p>
                </div>
            </div>
          </div>

          <div class="row">
              <div class="col-2">

              </div>
              <div class="col-2">

              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label for="bgtype">Blood Group : </label>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <select class="custom-select" name="bgtype">
                          <option selected value="A">A</option>
                          <option value="B">B</option>
                          <option value="AB">AB</option>
                          <option value="O">O</option>
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">

                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-2">

              </div>
              <div class="col-2">

              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label for="rhfactor">RH Factor : </label>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="bgrhfactor" id="gridRadios1" value="1" checked>
                          <label class="form-check-label" for="gridRadios1">
                              +ve (positive)
                          </label>
                      </div>
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="bgrhfactor" id="gridRadios2" value="0">
                          <label class="form-check-label" for="gridRadios2">
                              -ve (negative)
                          </label>
                      </div>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                  </div>
              </div>
          </div>
          <br>
          <div class="row">
              <div class="col-md-8 text-right display-5">
                  <input type="submit" id ="addformbtn" disabled="disabled"
                  class="btn btn-warning btn-send" value="Save">
              </div>
          </div>
      </form>
    </div>


    </div>
  </div>
  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- Key Events JS -->
  <script src="../js/bloodgroup.js"></script>
  <!-- Jquery UI -->
  <script src="../js/jquery-ui.min.js"></script>
  <!-- Bootstrap Tokenfield  -->
  <script src="../js/bootstrap-tokenfield.js"></script>
  <!-- custom jquery for patient search and add patient form -->
  <script src="../js/addcontact.js"></script>
  <script type="text/javascript">

  </script>
</body>
</html>
