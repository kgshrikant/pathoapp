<?php
require '../inc/db.init.php';
$report_link = "bloodchemistry";
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

  <title>SEROLOGY TEST</title>
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
    .col-sm-4 {
      //padding-botton : 5px;
      //margin: 0px;
      //padding : 0px;

    }
    .form-control{
      padding : 0px;
      //margin-top: 5px;
    }
    .form-group{
      //padding: 0px
      //margin: 0px;
      margin-bottom: 5px;
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
    <div class="row">
      <div class="col-1 offset-1">
        <a href="/pathoapp/" class="btn">
          <i class="fas fa-home" style="font-size: 45px;" ></i></a>
      </div>
      <div class="col-6">
        <div class="input-group margin-bottom-sm" style="margin-top:9px; padding: 5px; float:left; ">
          <input class="form-control" name="patient-search" id="patient-search" type="text"
          placeholder="Search Patients .." >
          <div class="input-group-btn" >
            <button class="btn btn-warning" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div><br>
        <div id="search-result"></div>
      </div>
      <div class="col-3">
        <a class="btn" id="btn-show-patient-form" href="#">
        <i class="fas fa-user-plus" style="font-size:45px; color: black;"></i> </a>
        <a class="btn" id="btn-list" href="/pathoapp/<?= $report_link ?>">
        <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
      </div>
    </div>
    <div id="patient-form" style="display: block;">
      <div class="row text-center mx-auto ">
        <div class="col-12 text-center mx-auto ">
          <h4 class="display-5 report-header">SEROLOGY TEST</h4>
        </div>
      </div>
      <br>
      <form id="addpatientform" method="POST">
        <div class="form-group">
          <div class="row">
            <div class="col-sm-1.5">
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
            <div class="col-sm-2">
              <label for="initials">FIRSTNAME</label>
              <input type="text" id="firstname" class="form-control" name="firstname" placeholder="FIRSTNAME"
              required="required" data-error="Firstname is required.">

            </div>
            <div class="col-sm-2">
              <label for="initials">SURNAME</label>
              <input type="text" id="surname" class="form-control" name="surname" placeholder="SURNAME"
              required="required" data-error="Surname is required.">

            </div>

            <div class="col-sm-1.5" >
              <label for="sex">SEX</label>
              <select id="sex" name="sex" class="form-control">
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
                <option value="OTHERS">OTHERS</option>
              </select>
            </div>
            <div class="col-sm-1" >
              <label for="age">AGE</label>
              <input type="text" id="age" class="form-control" name="age" placeholder="AGE">
            </div>
            <div class="col-sm-2">
              <br>
              <button type="submit" id="btn-save-patient" class="btn btn-primary"
              value="Add Patient">ADD PATIENT </button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- patient details -->
    <div id="patient-details" class="border border-dark rounded" style="display: block; padding:20px;">
      <div class="row text-center mx-auto ">
        <div class="col-12 text-center mx-auto ">
          <h4 class="display-5 report-header">PATIENT DETAILS</h4>
        </div>
      </div>
      <div class="row text-center mx-auto text-uppercase">
        <hr style="width:100%">

        <div class="col-sm-3">
            Patient : <b><div id="patient-name"></div></b>
        </div>

        <div  class="col-sm-3 text-center mx-auto ">
            Sex : <b><div id="patient-sex"></div></b>
        </div>

        <div class="col-sm-3 text-center mx-auto">
            Age : <b><div id="patient-age"></div></b>
        </div>
      </div>
    </div>

    <!-- Pathology Form -->
    <div id="main-form" class="text-uppercase">
      <form id="pathology-form" method="post" action="insertserology.php" role="form">
        <!-- Doctor Details -->
        <br>
        <div class="row">
          <div class="col-sm-4">
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

          <div class="col-sm-4">
              <input type="hidden" id="patient-id" type="text" name="pid"  />
          </div>
          <div class="col-sm-4">

          </div>
        </div>

        <!-- Header -->

        <!-- HIV1 : -->
        <div class="row mt-3">
          <label for="hiv1" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">HIV 1</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="hiv1" name="hiv1"  class="form-control" >
                <option value=""></option>
                <option value="0">NON REACTIVE</option>
                <option value="1">REACTIVE</option>
              </select>
            </div>
          </div>
        </div>

        <!-- HIV2 : -->
        <div class="row mt-3">
          <label for="hiv2" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">HIV 2</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="hiv1" name="hiv2"  class="form-control" >
                <option value=""></option>
                <option value="0">NON REACTIVE</option>
                <option value="1">REACTIVE</option>
              </select>
            </div>
          </div>
        </div>

        <!-- vdrl : -->
        <div class="row mt-3">
          <label for="vdrl" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">VDRL</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="vdrl" name="vdrl"  class="form-control" >
                <option value=""></option>
                <option value="0">NON REACTIVE</option>
                <option value="1">REACTIVE</option>
              </select>
            </div>
          </div>
        </div>

        <!-- HbsAg : -->
        <div class="row mt-3">
          <label for="hbsag" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">HbsAg</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="hbsag" name="hbsag"  class="form-control" >
                <option value=""></option>
                <option value="0">NON REACTIVE</option>
                <option value="1">REACTIVE</option>
              </select>
            </div>
          </div>
        </div>

        <!-- ANTI HCV : -->
        <div class="row mt-3">
          <label for="anti_hcv" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">ANTI HCV</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="anti_hcv" name="anti_hcv"  class="form-control" >
                <option value=""></option>
                <option value="0">NON REACTIVE</option>
                <option value="1">REACTIVE</option>
              </select>
            </div>
          </div>
        </div>

        <br><br>
        <div class="row">

          <div class="col-md-1 text-center">
          </div>
          <div class="col-md-6 text-center">
            <input type="submit" id ="addformbtn" disabled="disabled" class="btn btn-warning btn-send" value="Save">
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


  <script src="../js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/addcontact.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>
  <!-- Key Events JS -->

  <script type="text/javascript">

  $(function(){
      $( "#pathology-form" ).validate({
        rules: {
          hiv1: "required",
          hiv2 : "required",
          vdrl: "required",
          hbasg : "required",
          anti_hcv: "required"

        },
        messages: {
          hiv1: {
            required: "Please select thehiv1",
            minlength: ""
          },

        },

        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `invalid-feedback` class to the error element
          error.addClass( "invalid-feedback" );

          if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.next( "label" ) );
          } else {
            error.insertAfter( element );
          }
        },

        highlight: function ( element, errorClass, validClass ) {
          $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
      });
    });
  </script>
</body>
</html>
