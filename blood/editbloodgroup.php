<?php
//include '../inc/connection.php';
require '../inc/db.init.php';

$pid = "";
$db_drid = "";
$id = "";
$bgtype_arr = array ("A" => "A", "B" => "B" , "AB" => "AB", "O" => "O" );
$rhfactor = 0;
$bgtype = "";
$bgrhfactor = "";
$report_create_date = "";
$report_link = "bloodgroup";

if($_SERVER["REQUEST_METHOD"] == "GET") {

  $rid = $_GET['rid'];
  $data_report = $database->get("report",
  ["class_id"],
  ["class_type" => "{$report_link}", "rid" => "{$rid}" ]);

  $id = $data_report["class_id"];

  $data_bloodgroup = $database->get("bloodgroup",
  ["pid","drid","bgtype","rhfactor","create_date"],
  ["id" => $id ]);

  $error_db = $database->error() ;
  if(is_null($error_db[2]) == 1) {
    $pid = $data_bloodgroup['pid'];
    $drid = $data_bloodgroup['drid'];
    $bgtype = $data_bloodgroup['bgtype'];
    $rhfactor = $data_bloodgroup['rhfactor'];
    $report_create_date = $data_bloodgroup['create_date'];
  }

  //echo "doctor id = ".  $db_drid;
  //patient detials
  $initials = "";
  $firstname = "";
  $patient_name = "";
  $surname = "";
  $sex = "";
  $age = "";
  $patient_details = "";

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
      <a href="editbloodgroup.php?rid=<?= $rid ?>" role="button">
          <i class="fas fa-edit": style="font-size:30px;"></i></a>
      <a href="/pathoapp" role="button">
          <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
    </div>

    <div class="row">
      <div class="col-sm-12 text-center mx-auto ">
        <h4 class="display-5 report_header" style=""><b>BLOOD GROUPING</b></h4>
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
      <form id="blood-group-form" method="post" action="updatebloodgroup.php" role="form">
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
                  <?php
                  foreach($bgtype_arr as $bg => $bg_value){
                    if($bg == $bgtype){
                      echo "<option value='".$bg."' selected>".$bg_value."</option>";
                    }
                     echo "<option value='".$bg."' >".$bg_value."</option>";
                  }
                  ?>
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
                    <input class="form-check-input" type="radio"
                    name="bgrhfactor" id="positive" value="1" <?php if($rhfactor == 1){ echo "checked";}?>>
                    <label class="form-check-label" for="positive">
                        +ve (positive)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio"
                    name="bgrhfactor" id="negative" value="0" <?php if($rhfactor == 0){ echo "checked";}?>>
                    <label class="form-check-label" for="negative">
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
