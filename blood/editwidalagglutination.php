<?php
//include '../inc/connection.php';
require '../inc/db.init.php';

$pid = "";
$db_drid = "";
$id = "";
$testname = "WIDAL AGGLUTINATION";
$report_link = 'widalagglutination';
$class_id = "";
$message_result = "";
$styphio = "";
$styphih = "";
$styphiah = "";
$styphibh = "";
$qualitative = "";
$create_date = "";
$report_create_date = new DateTime($create_date);

//patient DETAILS
$initials = "";
$firstname = "";
$patient_name = "";
$surname = "";
$sex = "";
$age = "";
$patient_details = "";

//dr DETAILS
$drinitials = "";
$drfirstname = "";
$drsurname = "";
$drqualification = "";
$doctor_details = "";
$fullname = "";

if($_SERVER["REQUEST_METHOD"] == "GET") {
  $rid = $_GET['rid'];

  $data_report = $database->get("report",
  ["class_id"],
  ["class_type" => "widalagglutination", "rid" => "{$rid}" ]);

  $id = $data_report["class_id"];
  //echo $id;

  $data_bc = $database->get("widalagglutination",
  ["pid", "drid", "qualitative", "styphio", "styphih", "styphiah", "styphibh", "create_date"],
  ["id" => $id ]);

  $error_db = $database->error() ;
  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $styphio = $data_bc['styphio'];
  $styphih = $data_bc['styphih'];
  $styphiah = $data_bc['styphiah'];
  $styphibh = $data_bc['styphibh'];
  $qualitative = $data_bc['qualitative'];
  $create_date = $data_bc['create_date'];
  $report_create_date = new DateTime($create_date);

  //echo "doctor id = ".  $db_drid;
  //patient detials
  $data_patient = $database->get("patient",
  ["pid","firstname","surname","sex","age","initials"],
  ["pid" => $pid ]);

  $initials = $data_patient['initials'];
  $firstname = $data_patient['firstname'];
  $surname = $data_patient['surname'];
  $sex = $data_patient['sex'];
  $age = $data_patient['age'];
  //$patient_details = "initials: " . $initials. ", Name: " . $firstname. " " . $surname. ", sex: ". $sex. ", age: ".$age;
  $patient_name = $data_patient['initials'].". ".$data_patient['firstname']." ".$data_patient['surname'];

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
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>PATHOLAB</title>
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="../css/dashboard_style.css">
  <!-- favicon css -->
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <!-- fontawesome css -->
  <link rel="stylesheet" href="../css/all.css">

  <style media="screen">
    .report_header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
  </style>

</head>
<body>
  <div class="container">
    <div class="d-print-none">
      <a href="#" class="" role="button" onclick=" window.history.back();">
        <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
      <button  onclick="window.print();">
        <i class="fas fa-print" style="font-size:30px;"></i></button>
      <a href="editbloodgroup.php?id=<?= $rid ?>" role="button">
          <i class="fas fa-edit": style="font-size:30px;"></i></a>
      <a href="/pathoapp" role="button">
          <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
    </div>

    <div class="row">
      <div class="col-sm-12 text-center mx-auto ">
          <br><br>
          <h4 class="display-5 report_header" style=""><b><?= $testname ?></b></h4>
      </div>
      <br><br>
    </div>
    <div class="line"></div>

    <!-- patient details -->
    <div id="patient-details" style="display: block;">
      <div class="row text-center mx-auto ">
        <hr style="width:100%">
        <div class="col-3">
            Patient : <b><div id="patient-name"><?= $patient_name ?></div></b>
        </div>

        <div  class="col-3 text-center mx-auto ">
            Sex : <b><div id="patient-sex"><?= $sex ?></div></b>
        </div>

        <div class="col-3 text-center mx-auto">
            Age : <b><div id="patient-age"><?= $age ?></div></b>
        </div>
      </div>
    </div>

    <div id="blood-group" style="display: block;">
      <form id="blood-group-form" method="post" action="updatewidalagglutination.php" role="form">
        <div class="messages"></div>
        <br><br>
        <div class="row">
          <div class="col-3">
            <div class="form-group">
              Ref By :
              <select id="drid" name="drid" class="form-control">
                <?php
                foreach($doctor_arr as $doctor){
                  if($doctor['drid'] == $db_drid){
                    echo "<option value='".$doctor['drid']."' selected >".$doctor['fullname']."</option>";
                  }
                   echo "<option value='".$doctor['drid']."' >".$doctor['fullname']."</option>";
                }
                ?>
              </select>
            </div>
          </div>
            <div class="col-2">
              <div class="form-group">
                  <!--<input type="hidden" id="doctor-id" type="text" name="drid" value="1"  /> -->
                  <input type="hidden" id="patient-id" type="text" name="id" value="<?= $id ?>" />
            </div>
          </div>
          <div class="col-2">
              <div class="form-group">
              </div>
          </div>
        </div>

        <!-- Collection QUALITATIVE -->
        <div class="row ">
          <label for="qualitywt" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">QUALITATIVE WIDAL TEST</label>

          <div class="col-3">
            <div class="form-group" >
              <select id="qualitywt" name="qualitywt" class="form-control">

                <option value="NEGATIVE">NEGATIVE</option>
                <option value="POSITIVE">POSITIVE</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Collection QUANTITATIVE -->
        <div class="row ">
          <label for="quantitywt" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">QUALITATIVE WIDAL TEST</label>

          <div class="col-3">
            <div class="form-group">
              <input type="text" id="qualitywt" name="qualitywt" disabled class="form-control">
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-1">
          </div>

          <div class="col-10">
            <table class="table table-grey">
              <thead style="text-align: center; font-weight: bold;" class="thead-dark">
                <tr>
                  <th>Dilution of Serum : </th>
                  <th>1/20</th>
                  <th>1/40</th>
                  <th>1/80</th>
                  <th>1/160</th>
                  <th>1/320</th>
                  <th>1/640</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>S TYPHI 'O'</td>

                  <?php
                    for( $i=0; $i<strlen($styphio) ; $i++){
                      echo "<td>";
                      echo '<select id="o' .($i+1). '" name="o' .($i+1). '" class="form-control">';
                      if(substr($styphio,$i,1) == 1){
                        echo '<option value="1" selected>+ve</option>';
                        echo '<option value="0" >-ve</option>';
                      }
                      else{
                        echo '<option value="0"selected  >-ve</option>';
                        echo '<option value="1" >+ve</option>';
                      }
                      echo "</td>";
                    }

                  ?>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>S TYPHI 'H'</td>

                  <?php
                  for( $i=0; $i<strlen($styphih) ; $i++){
                    echo "<td>";
                    echo '<select id="h' .($i+1). '" name="h' .($i+1). '" class="form-control">';
                    if(substr($styphio,$i,1) == 1){
                      echo '<option value="1" selected>+ve</option>';
                      echo '<option value="0" >-ve</option>';
                    }
                    else{
                      echo '<option value="0"selected  >-ve</option>';
                      echo '<option value="1" >+ve</option>';
                    }
                    echo "</td>";
                  }
                  ?>


                </tr>

                <tr>
                  <td>S TYPHI 'AH'</td>
                  <?php
                  for( $i=0; $i<strlen($styphiah) ; $i++){
                    echo "<td>";
                    echo '<select id="ah' .($i+1). '" name="ah' .($i+1). '" class="form-control">';
                    if(substr($styphiah,$i,1) == 1){
                      echo '<option value="1" selected>+ve</option>';
                      echo '<option value="0" >-ve</option>';
                    }
                    else{
                      echo '<option value="0"selected>-ve</option>';
                      echo '<option value="1" >+ve</option>';
                    }
                    echo "</td>";
                  }
                  ?>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>S TYPHI 'BH'</td>
                  <?php
                  for( $i=0; $i<strlen($styphibh) ; $i++){
                    echo "<td>";
                    echo '<select id="bh' .($i+1). '" name="bh' .($i+1). '" class="form-control">';
                    if(substr($styphibh,$i,1) == 1){
                      echo '<option value="1" selected>+ve</option>';
                      echo '<option value="0" >-ve</option>';
                    }
                    else{
                      echo '<option value="0"selected>-ve</option>';
                      echo '<option value="1" >+ve</option>';
                    }
                    echo "</td>";
                  }
                  ?>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="col-1">
          </div>
        </div>



        <br>
        <div class="row">
          <div class="col-md-8 text-right display-5">
              <input type="submit" class="btn btn-warning btn-send" value="Save">
          </div>
        </div>
      </form>
    </div>

    <div id="bloodgroup-list-today" style="display: none;">
      blood group list
    </div>
    <div id="display-contact" style="display: none;">
      blood Display contact
    </div>
    </div>
  </div>

  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/bloodgroup.js"></script>
  <script type="text/javascript">
  $(document).keyup(function (e) {
    //alert(e.keyCode);
    if (e.keyCode == 27) {
      window.location.href = 'http://localhost/pathoapp/';
    }else if(e.keyCode == 76) {
      window.location.href = 'http://localhost/pathoapp/listreport.php';
    }else if(e.keyCode == 65) {
      window.location.href = 'http://localhost/pathoapp/blood/addbloodgroup.php';
    }
  });
  </script>
</body>
</html>
