<?php
require '../inc/db.init.php';

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
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="../css/dashboard_style.css">
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <!-- Fontawesome -->
  <link rel="stylesheet" href="../css/all.css">

  <style media="screen">
    .column-header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
      margin: 10px;
    }
    .patient-header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .report-header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
  </style>
</head>

<body>

    <div class="container">
      <div class="row">
        <div class="col-1 offset-1">
          <a href="http://localhost/pathoapp/" class="btn">
            <i class="fas fa-home" style="font-size: 45px;" ></i></a>
        </div>
        <div class="col-6">
          <div class="input-group margin-bottom-sm" style="margin-top:9px; padding: 5px; float:left; ">
            <input class="form-control" id="patient-search" type="text" placeholder="Search Patients .." >
            <div class="input-group-btn" >
              <button class="btn btn-warning" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="col-3">
            <a class="btn" id="btn-show-patient-form" href="#">
            <i class="fas fa-user-plus" style="font-size:45px; color: black;"></i> </a>
            <a class="btn" id="btn-list" href="#">
            <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
        </div>
      </div>
      <div class="line"></div>
      <div id="patient-form" style="display: block;">
        <form id="addpatientform" method="POST">
            <div class="form-group" style="padding:10px;">
                <div class="row" >
                    <div class="col-1.5 text-center">
                        <label for="initials">INITIALS</label>
                        <select id="initials" name="initials" class="form-control">
                            <option value="MR">MR.</option>
                            <option value="MRS">MRS.</option>
                            <option value="MS">MS.</option>
                            <option value="SMT">SMT.</option>
                            <option value="MASTER">MASTER</option>
                            <option value="DR">DR.</option>
                            <option value="DR MRS">DR. MRS.</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="initials">FIRSTNAME</label>
                        <input type="text" id="firstname" class="form-control" name="firstname" placeholder="FIRSTNAME"
                        required="required" data-error="Firstname is required.">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-2">
                        <label for="initials">SURNAME</label>
                        <input type="text" id="surname" class="form-control" name="surname" placeholder="SURNAME"
                        required="required" data-error="Surname is required.">
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="col-1.5" >
                        <label for="sex">SEX</label>
                        <select id="sex" name="sex" class="form-control">
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                            <option value="OTHERS">OTHERS</option>
                        </select>
                    </div>
                    <div class="col-1" >
                        <label for="age">AGE</label>
                        <input type="text" id="age" class="form-control" name="age" placeholder="AGE">
                    </div>
                    <div class="col-2">
                        <br>
                        <button type="submit" id="btn-save-patient" class="btn btn-primary" style="padding: 10px;"
                        value="Add Patient"><i class="fas fa-user-plus"></i> SAVE</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <!-- display patient details on saving patients details -->
      <div id="patient-details" class="border border-dark rounded" style="display: block; padding:20px;">
        <div class="row text-center mx-auto ">
          <div class="col-12 text-center mx-auto ">
            <p class="display-5" style="patient-header">
              <b>PATIENT DETAILS</b></p>
          </div>
        </div>
        <div class="row text-center mx-auto" style="">
            <div class="col-6 text-left"  >
                <p id="patient-name">PATIENT : </p>
            </div>
            <div  class="col-3 text-left mx-auto ">
                <p id="patient-sex" >SEX : </p>
            </div>
            <div class="col-3 text-left mx-auto">
                <p id="patient-age" >Age : </p>
            </div>
        </div>
      </div>
      <!-- Pathology form -->
      <div id="pathology" style="display: block; padding: 20px;">
        <form id="pathology-form" method="post" action="viewlipidprofile.php" role="form">
          <!-- Partient Doctor Fields -->
          <div class="row">
            <div class="col-2.5">
              <div class="form-group">
                  <label for="drid">Referred By : </label>
                  <select id="drid" name="drid"  class="form-control" >
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
          </div>
          <!-- Report Header -->
          <div class="row text-center mx-auto ">
            <div class="col-12 text-center mx-auto ">
              <h4 class="display-5 report-header">
                <b>LIPID PROFILE</b></h4>
            </div>
          </div>

          <div class="row text-center">
            <div class="col-sm-3 text-center mx-auto column-header" >
                <b>TEST DESCRIPTION</b>
            </div>
            <div class="col-sm-3 text-center mx-auto column-header" >
                <b>RESULT</b>
            </div>
            <div class="col-sm-3 text-center mx-auto column-header"
                <b>UNITS</b>
            </div>
            <div class="col-sm-3 text-center mx-auto column-header">
                <b>REFERENCE RANGES</b>
            </div>
          </div>

        <!--LDL -->
          <div class="row">
            <div class="col-3 text-center" >
              <label for="ldl"><b> LDL :</b> </label>
            </div>
            <div class="col-3">
              <div class="form-group">
                <input id="ldl" type="text" name="ldl" class="form-control" placeholder="LDL *"
                data-error="name is required.">
              </div>
            </div>
            <div class="col-3 text-center">
              <div class="">
                mg/dl
              </div>
            </div>
            <div class="col-3 text-center">
              <div class="">
                <p>[90-170]</p>
              </div>
            </div>
          </div>

          <!--HDL -->
          <div class="row">
            <div class="col-3 text-center" >
              <label for="hdl"><b> HDL :</b> </label>
            </div>
            <div class="col-3">
              <div class="form-group">
                <input id="hdl" type="text" name="hdl" class="form-control" placeholder="HDL *"
                data-error="name is required.">
              </div>
            </div>
            <div class="col-3 text-center">
              <div class="">
                mg/dl
              </div>
            </div>
            <div class="col-3 text-center">
              <div class="">
                <p>[30-70]</p>
              </div>
            </div>
          </div>

          <!--Serum Cholesterol -->
          <div class="row">
            <div class="col-3 text-center" >
              <label for="serumc"><b> Serum Cholesterol :</b> </label>
            </div>
            <div class="col-3">
              <div class="form-group">
                <input id="serumc" type="text" name="serumc" class="form-control"
                placeholder="Serum Cholesterol *" data-error="name is required.">
              </div>
            </div>
            <div class="col-3 text-center">
              <div class="">
                mg/dl
              </div>
            </div>
            <div class="col-3 text-center">
              <div class="">
                <p>[150-250]</p>
              </div>
            </div>
          </div>


          <!--Serum Tryglyceride -->
          <div class="row">
            <div class="col-3 text-center" >
              <label for="serumt"><b> Serum Tryglyceride :</b> </label>
            </div>
            <div class="col-3">
              <div class="form-group">
                <input id="serumt" type="text" name="serumt" class="form-control"
                placeholder="Serum Tryglyceride *" required="required" data-error="name is required.">
              </div>
            </div>
            <div class="col-3 text-center">
              <div class="">
                mg/dl
              </div>
            </div>
            <div class="col-3 text-center">
              <div class="">
                <p>[60-165]</p>
              </div>
            </div>
          </div>

          <br><br>
          <div class="row">
              <div class="col-md-6 text-left">
              </div>
              <div class="col-md-6 text-left">
                  <input type="submit" class="btn btn-warning btn-send" value="Save">
              </div>
          </div>


          <div class="row">
              <div class="col-md-12">
                  <p class="text-muted"><strong>*</strong> These fields are required.</p>
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
  <!-- Custom
  1. Add contact JS
  2. Hide form
  3. Validate Form -->
  <script src="../js/addcontact.js"></script>

</body>
</html>
