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
    <div class="row">
        <div class="col-sm-12 text-center mx-auto ">
          <br><br>
            <h4 class="display-5 report_header" style=""><b>BLOOD GROUPING</b></h4>
        </div>

    </div>
    <div class="line"></div>
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
    <div id="patient-details" style="display: none;">
      <div class="row text-center mx-auto ">
          <hr style="width:100%">

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

    <div id="blood-group" style="display: none;">
      <form id="blood-group-form" method="post" action="viewbloodgroup.php" role="form">
          <div class="messages"></div>
          <br><br>
          <div class="row">
            <div class="col-2">
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

  <!-- Key Events JS -->
  <script src="../js/bloodgroup.js"></script>

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

    // ajax function saves patient's record returns patient id
    $("#btn-save-patient").on("click", function (e) {
      e.preventDefault();
      //$("#btn-save-patient").attr("disabled", "disabled");
      var initials = $("#initials").val().toUpperCase();
      var firstname = $("#firstname").val().toUpperCase();
  		var surname = $("#surname").val().toUpperCase();
  		var sex = $("#sex").val().toUpperCase();
  		var age = $("#age").val();
      // form validation
      if(firstname!="" && surname!="" && age!="" ){
        //alert(initials+firstname+surname+sex+age);
        $.ajax({
            url:  "../ajax/insert-patient-record.php",
            type: "POST",
            data:
            {
              initials: initials,
              firstname: firstname,
              surname: surname,
              sex: sex,
              age: age
            },
            cache: false,
            success: function(dataResult){
            console.log(dataResult);
    					if(dataResult!=0){
    					  //alert ("Data added successfully !"+dataResult);
                $("#patient-form").trigger("reset");
                $("#patient-form").hide(100);
                $("#patient-details").show();
                $("#blood-group").show();
                $("#patient-name").html(initials+". "+firstname+" "+surname);
                $("#patient-sex").html(sex);
                $("#patient-age").html(age);
                $("#patient-id").val(dataResult);
    					}
    					else if(dataResult==0){
                alert("Error occured!");
    					}
  				  }
        });
      } else {
        alert('Please fill all the field !');
      }
    });
    // change sex details after choosing
    $('#initials').on('change', function () {
      var initials = $('#initials').val();
      if(initials == 'MRS' || initials == 'MS' || initials == 'SMT' || initials == 'DR MRS'){
        //alert ('female');
        $("#sex").val("FEMALE").change();
      }else{
        $("#sex").val("MALE").change();
      }
    });
  });
  </script>
</body>
</html>
