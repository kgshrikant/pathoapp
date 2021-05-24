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
  <!-- fontawesome APIs -->
  <link rel="stylesheet" href="../css/all.css">
  <!-- datetimepicker APIs -->
  <link rel="stylesheet" href="../css/jquery-ui.css">

  <link rel="stylesheet" href="../css/jquery.simple-dtpicker.css"/ >

  <style>
    .heading{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .upper{
      text-transform: uppercase;
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
      <a href="http://localhost/pathoapp/" class="btn">
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
        <a class="btn" id="btn-list" href="#">
        <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
    </div>
  </div>

    <div id="patient-form" style="display: block;">
      <form id="addpatientform" method="POST">
        <div class="form-group">
          <div class="row">
              <div class="col-1.5">
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
                  <button type="submit" id="btn-save-patient" class="btn btn-primary"
                  value="Add Patient">ADD PATIENT </button>
              </div>
          </div>
        </div>
      </form>
    </div>
    <!-- patient details -->
    <div id="patient-details" class="border border-dark rounded"
    style="display: block; padding:20px;">
      <div class="row text-center mx-auto ">
        <div class="col-sm-12 text-center mx-auto ">
          <h5 class="heading"> <b>PATIENT DETAILS</b></h5>

        </div>
      </div>
      <div class="row text-center mx-auto ">

          <div class="col-3">
              Patient : <b><div id="patient-name"></div></b>
          </div>
          <div  class="col-3 text-center mx-auto ">
              Sex : <b><div id="patient-sex"></div></b>
          </div>
          <div class="col-3 text-center mx-auto">
              Age : <b><div id="patient-age"></div></b>
          </div>
      </div>
    </div>

    <div id="main-form" style="display: block;">
      <form id="pathology-form" method="post" action="insertsemen.php" role="form">
        <div class="messages"></div>
        <br><br>
        <!-- Physical Examination -->
        <div class="row mt-1">
            <div class="col-sm-12 text-center mx-auto ">
              <h5 class="heading"> <b>SEMINAL FLUID</b></h5>
            </div>
        </div>
        <!-- Columns -->
        <div class="row">
          <div class="col-sm-3 text-center mx-auto" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>TEST DESCRIPTION</b>
          </div>
          <div class="col-sm-3 text-center mx-auto" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>RESULT</b>
          </div>
          <div class="col-sm-3 text-center mx-auto" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>UNITS</b>
          </div>
          <div class="col-sm-3 text-center mx-auto" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>BIOLOGICAL REFERENCE </b>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
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
              <input type="hidden" id="patient-id" type="text" name="pid"  />
          </div>
          <div class="col-2">
          </div>
        </div>
        <br>

        <!-- Collection Time Start datetimepicker_start -->
        <div class="row ">
          <label for="time_start" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">Collection Time Start</label>

          <div class="col-3">
            <div class="form-group" >
              <input id="datetimepicker_start" type="text" name="time_start" value="" class="form-control">
            </div>
          </div>
        </div>

        <!-- Collection Time End datetimepicker_end -->
        <div class="row ">
          <label for="time_end" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">Collection Time End</label>

          <div class="col-3">
            <div class="form-group" >
              <input id="datetimepicker_end" type="text" name="time_end" class="form-control">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3 text-left" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>GROSS EXAMINATION</b>
          </div>
        </div>

        <!-- semen volume -->
        <div class="row ">
          <label for="volume" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">Volume</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="volume" type="text" name="volume" class="form-control" value="2">
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              ml
            </div>
          </div>
        </div>

        <!-- consistency -->
        <div class="row ">
          <label for="consistency" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">Colour</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="consistency" name="consistency"  class="form-control" >
                <option value="VISCOUS">VISCOUS</option>
              </select>
            </div>
          </div>
        </div>

        <!-- colour -->
        <div class="row ">
          <label for="colour" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">Colour</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="colour" name="colour"  class="form-control" >
                <option value="MILKY">MILKY</option>
              </select>
            </div>
          </div>
        </div>

        <!-- odour -->
        <div class="row ">
          <label for="odour" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:10px;">Odour</label>
          <div class="col-sm-3" style="padding: 10px;">
            <div class="form-group">
              <select id="odour" name="odour"  class="form-control" >
                <option value="FISHY">FISHY</option>
              </select>
            </div>
          </div>
        </div>

        <!-- duration -->
        <div class="row ">
          <div class="col-3">
            Liquid Faction Time
          </div>
          <div id="duration" class="col-3 text-center">
            00:30
          </div>
          <div class="col-sm-3 text-center">
            minutes
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm-3 text-left" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>MICROSCOPIC EXAMINATION</b>
          </div>
        </div>

        <!-- spermcount -->
        <div class="row">
          <label for="spermcount" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">SPERM COUNT</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="spermcount" type="text" name="spermcount" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              millions / ml
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-3 text-left" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 10px;">
              <b>SPERM MOTILITY EXAMINATION</b>
          </div>
        </div>

        <!-- active cells -->
        <div class="row">
          <label for="active" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">ACTIVE</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="active" type="text" name="active" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              % (Active Motile)
            </div>
          </div>
          <div class="col-3 text-center">

          </div>
        </div>

        <!-- sluggish cells -->
        <div class="row">
          <label for="sluggish" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">SLUGGISH</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="sluggish" type="text" name="sluggish" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              % (Sluggish Motile)
            </div>
          </div>
        </div>

        <!-- dead cells -->
        <div class="row">
          <label for="dead" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">DEAD</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="dead" type="text" name="dead" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              % (Active Motile)
            </div>
          </div>
        </div>

        <!-- morpohology cells -->
        <div class="row">
          <label for="morpohology" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">SPERM MORPOHOLOGY</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="morpohology" type="text" name="morpohology" class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              % Normal
            </div>
          </div>
        </div>

        <!-- puscells cells -->
        <div class="row">
          <label for="puscells" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">Pus Cells</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="puscells" name="puscells" type="text"  class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              /hpf
            </div>
          </div>
        </div>


        <!-- epcells cells -->
        <div class="row">
          <label for="epcells" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">EP Cells</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="epcells" name="epcells" type="text"  class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              /hpf
            </div>
          </div>
        </div>

        <!-- rbc cells -->
        <div class="row">
          <label for="rbc" class="col-sm-3 col-form-label"
          style="position: relative; left:20px; top:1px;">RBC</label>
          <div class="col-3">
            <div class="form-group" >
              <input id="rbc" name="rbc" type="text"  class="form-control" >
            </div>
          </div>
          <div class="col-3 text-center">
            <div class="form-group">
              /hpf
            </div>
          </div>
        </div>
        <br><br>
        <div class="row">
          <div class="col-md-8 text-right display-5">
            <input type="submit" id ="addformbtn" disabled="disabled" class="btn btn-warning btn-send" value="Save">
          </div>
        </div>
    </form>
  </div>
  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>

  <script src="../js/jquery-ui.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>

  <!-- Datepicker JS -->
  <script src="../js/jquery.simple-dtpicker.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <!-- Key Events JS -->
  <script src="../js/addcontact.js"></script>

  <script type="text/javascript">

  $(document).ready(function(){
    //alert('hello');

    $('#datetimepicker_start').appendDtpicker({
      "dateFormat": "DD/MM/YYYY HH:mm TT"
    });
    $('#datetimepicker_end').appendDtpicker({
      "dateFormat": "DD/MM/YYYY HH:mm TT"
    });

    $( "#datetimepicker_end" ).keyup(function() {
      var end_time = $(this).val();
      var start_time = $('#datetimepicker_start').val();
      var diff_ms = Math.abs(new Date(start_time) - new Date(end_time));
      var diff_mins = Math.floor((diff_ms/1000)/60);
      //alert (diff_mins);
      $('#duration').text(diff_mins);
    });

    $( "#pathology-form" ).validate({
      rules: {
        spermcount: "required",
        active : "required",
        sluggish : "required",
        dead : "required",
        morpohology : "required",
        puscells: "required"
      },
      messages: {
        spermcount: {
          required: "Please enter the sperm count",
          minlength: "Your sperm count must consist of at least 2 characters"
        },

        active : {
          required: "Please enter the active count",
          minlength: "must consist of at least 2 characters"
        },
        sluggish : {
          required: "Please enter the sluggish count",
          minlength: "must consist of at least 2 characters"
        },
        dead : {
          required: "Please enter the dead count",
          minlength: "must consist of at least 2 characters"
        },
        morpohology : {
          required: "Please enter the morpohology count",
          minlength: "must consist of at least 2 characters"
        },
        puscells: {
          required: "Please enter the puscells count",
          minlength: "must consist of at least 2 characters"
        }
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
