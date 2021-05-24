<?php
require '../inc/db.init.php';
$report_type="urine";
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
  <!--<link rel="stylesheet" href="../css/dashboard_style.css">-->
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />

  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/all.css" >
  <!-- Font Awesome JS -->

</head>

<body>
  <div class="wrapper">
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
            <a class="btn" id="btn-list" href="../listreport.php?type=<?= $report_type ?>">
            <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
        </div>
      </div>

      <div class="line"></div>
      <div id="patient-form" style="display: block;">
        <form id="addpatientform" method="POST">
            <div class="form-group" style="padding:10px;">
                <div class="row" >
                    <div class="col-sm-1.5 text-center">
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
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-sm-2">
                        <label for="initials">SURNAME</label>
                        <input type="text" id="surname" class="form-control" name="surname" placeholder="SURNAME"
                        required="required" data-error="Surname is required.">
                        <div class="help-block with-errors"></div>
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
                        <button type="submit" id="btn-save-patient" class="btn btn-primary" style="padding: 10px;"
                        value="Add Patient"><i class="fas fa-user-plus"></i> SAVE</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <!-- display patient details on saving patients details -->
      <div id="patient-details" class="border border-dark rounded" style="display: block; padding:20px;">
        <!-- heading -->
        <div class="row text-center mx-auto ">
          <div class="col-sm-12 text-center mx-auto ">
            <h4 class="display-5" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px;">
              <b>PATIENT DETAILS</b></h4>
          </div>
        </div>
        <!-- Populated from addcontact.js -->
        <div class="row text-center mx-auto" style="">

          <div class="col-sm-6 text-left"  >
              <p id="patient-name">PATIENT : </p>
          </div>
          <div class="col-sm-3 text-left mx-auto">
              <p id="patient-age" >Age : </p>
          </div>
          <div  class="col-sm-3 text-left mx-auto ">
              <p id="patient-sex" >SEX : </p>
          </div>
        </div>
      </div>
      <!-- Pathology form -->
      <div id="pathology" style="display: block; padding: 20px;">
        <form id="pathology-form" method="post" action="inserturine.php" role="form">
          <!-- Partient Doctor Fields -->
          <div class="row">
            <div class="col-sm-2.5">
              <div class="form-group">
                <input type="hidden" id="patient-id" type="text" name="pid"  />
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
          </div>

          <div class="row text-center mx-auto ">
            <div class="col-sm-12 text-center mx-auto ">
              <h4 class="display-5" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px;">
                <b>EXAMINATION OF URINE</b></h4>
            </div>
          </div>

          <!-- Physical Examination -->
          <div class="row">
            <div class="col-sm-12 text-center" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px;">
              <b>PHYSICAL EXAMINATION</b>
            </div>
          </div>

          <!-- Columns -->
          <div class="row text-center">
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
                <b>BIOLOGICAL REFERENCE RANGES</b>
            </div>
          </div>

          <!-- Reaction -->
          <div class="row" >
            <label for="reaction" class="col-sm-3 col-form-label" style="position: relative; left:20px; top:12px">Reaction</label>
            <div class="col-sm-3 " style="padding: 10px;">
              <div class="form-group" >
                <select id="reaction" name="reaction"  class="form-control" >
                  <option value=" "></option>
                  <option value="ACIDIC">ACIDIC</option>
                  <option value="ALKALINE">ALKALINE</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Appearance -->
          <div class="row ">

            <label for="appearance" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Appearance</label>

            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="appearance" name="appearance"  class="form-control" >
                  <option value=" "></option>
                  <option value="STRAW">STRAW</option>
                  <option value="CLEAR">CLEAR</option>
                  <option value="TURBID">TURBID</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Color -->
          <div class="row ">
            <label for="colour" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Colour</label>

            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="colour" name="colour"  class="form-control" >
                  <option value=" "></option>
                  <option value="LIGHT YELLOW">LIGHT YELLOW</option>
                  <option value="PALE YELLOW">PALE YELLOW</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Quantity -->
          <div class="row ">
            <label for="quantity" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:5px;">Quantity </label>
            <div class="col-sm-3">
                <div class="form-group" style="width: 100px;">
                    <input id="quantity" type="text" name="quantity" class="form-control"
                    value="5" >
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <div class="form-group">
                    ml
                </div>
            </div>
            <div class="col-sm-3">

            </div>
          </div>

          <!-- Deposit -->
          <div class="row ">
            <label for="deposit" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Deposit </label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="deposit" name="deposit"  class="form-control" >
                  <option value=" "></option>
                  <option value="PRESENT">PRESENT</option>
                  <option value="ABSENT">ABSENT</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Chemical examination header -->
          <div class="row">
            <div class="col-sm-12 text-center" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px;">
              <b>CHEMICAL EXAMINATION</b>

            </div>
          </div>

          <!-- columns -->
          <div class="row text-center ">
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
                <b>BIOLOGICAL REFERENCE RANGES</b>
            </div>
          </div>

          <!-- Albumin -->
          <div class="row ">
            <label for="albumin" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Albumin </label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="albumin" name="albumin"  class="form-control" >
                  <option value=" "></option>
                  <option value="TRACE">TRACE</option>
                  <option value="NIL">NIL</option>
                  <option value="+">+</option>
                  <option value="++">++</option>
                  <option value="+++">+++</option>
                  <option value="++++">++++</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Sugar -->
          <div class="row ">
            <label for="sugar" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Sugar </label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="sugar" name="sugar"  class="form-control" >
                  <option value=" "></option>
                  <option value="TRACE">TRACE</option>
                  <option value="NIL">NIL</option>
                  <option value="0.5 +">0.5 +</option>
                  <option value="1.0 ++">1.0 ++</option>
                  <option value="1.5 +++">1.5 +++</option>
                  <option value="2.0 ++++">2.0 ++++</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Bile Salt -->
          <div class="row ">
            <label for="bilesalt" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Bile Salt </label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="bilesalt" name="bilesalt"  class="form-control" >
                  <option value=" "></option>
                  <option value="NEGATIVE">-VE</option>
                  <option value="POSITIVE">+VE</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Bile pigment -->
          <div class="row ">
            <label for="bilepigment" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Bile Pigment </label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="bilepigment" name="bilepigment"  class="form-control" >
                  <option value=" "></option>
                  <option value="NEGATIVE">-VE</option>
                  <option value="POSITIVE">+VE</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Urobilinogen -->
          <div class="row ">
            <label for="urobilinogen" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Urobilinogen </label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="urobilinogen" name="urobilinogen"  class="form-control" >
                  <option value=" "></option>
                  <option value="NEGATIVE">-VE</option>
                  <option value="POSITIVE">+VE</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Acetone -->
          <div class="row ">
            <label for="acetone" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Acetone</label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="acetone" name="acetone"  class="form-control" >
                  <option value=" "></option>
                  <option value="NEGATIVE">-VE</option>
                  <option value="POSITIVE">+VE</option>
                </select>
              </div>
            </div>
          </div>

          <!-- header microscopic examintation -->
          <div class="row">
            <div class="col-sm-12 text-center" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; ">
              <b>MICROSCOPIC EXAMINATION</b>

            </div>
          </div>

          <!-- columns -->
          <div class="row text-center ">
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
                <b>BIOLOGICAL REFERENCE RANGES</b>
            </div>
          </div>

          <!-- Crystals -->
          <div class="row ">
            <label for="crystals" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Crystals </label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="crystals" name="crystals"  class="form-control" >
                  <option value=" "></option>
                  <option value="NIL">NIL</option>
                  <option value="Ca.OXALATE">Ca.OXALATE</option>
                  <option value="PHOS.PRE.">PHOS.PRE.</option>
                  <option value="CYSTINE">CYSTINE</option>
                  <option value="Ca.OXALATE & PHOS PRE.">Ca.OXALATE & PHOS PRE.</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Pus Cells -->
          <div class="row ">
            <label for="puscells" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:1px;">Pus Cells</label>
            <div class="col-sm-3">
                <div class="form-group" style="width: 100px;">
                    <input id="puscells" type="text" name="puscells" class="form-control">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <div class="form-group">
                    / h.p.f.
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                </div>
            </div>
          </div>

          <!-- Red Cells -->
          <div class="row ">
            <label for="redcells" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:5px;">Red Cells</label>
            <div class="col-sm-3">
                <div class="form-group" style="width: 100px;">
                    <input id="redcells" type="text" name="redcells" class="form-control">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <div class="form-group">
                    / h.p.f.
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                </div>
            </div>
          </div>

          <!-- Epithelials Cells -->
          <div class="row ">
            <label for="ecells" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:4px;">Epithelials Cells</label>
            <div class="col-sm-3">
                <div class="form-group" style="width: 100px;">
                    <input id="ecells" type="text" name="ecells" class="form-control">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <div class="form-group">
                    / h.p.f.
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                </div>
            </div>
          </div>

          <!-- Parasite -->
          <div class="row ">
            <label for="parasite" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Parasite</label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="parasite" name="parasite"  class="form-control" >
                  <option value=" "></option>
                  <option value="ABSENT">ABSENT</option>
                  <option value="TRICOMONIASIS PRESENT">TRICOMONIASIS PRESENT</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Mucous Threads -->
          <div class="row ">
            <label for="mucous" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Mucous Threads</label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="mucous" name="mucous"  class="form-control" >
                  <option value=" "></option>
                  <option value="ABSENT">ABSENT</option>
                  <option value="TRICOMONIASIS PRESENT">TRICOMONIASIS PRESENT</option>

                </select>
              </div>
            </div>
          </div>

          <!-- Cast -->
          <div class="row ">
            <label for="cast" class="col-sm-3 col-form-label"
            style="position: relative; left:20px; top:10px;">Cast</label>
            <div class="col-sm-3" style="padding: 10px;">
              <div class="form-group">
                <select id="cast" name="cast"  class="form-control" >
                  <option value=" "></option>
                  <option value="HYALINE">HYALINE</option>
                  <option value="GRANULAR">GRANULAR</option>
                  <option value="NIL">NIL</option>
                  <option value="WAXY">WAXY</option>
                  <option value="WBC">WBC</option>
                  <option value="RBC">RBC</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 text-center">
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
  <!-- Key Events JS -->
  <script src="../js/bloodgroup.js"></script>
  <!-- Jquery UI -->
  <script src="../js/jquery-ui.min.js"></script>
  <!-- Bootstrap Tokenfield  -->
  <script src="../js/bootstrap-tokenfield.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>
  <script type="text/javascript">
  $(document).ready(function () {
    // show patient form
    $("#btn-show-patient-form").on("click", function () {
      $('#contact-form').toggle();
      //$('#contact-form').show(200);
      //$('#bloodgroup-list-today').hide(200);
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
      //$("#sex").prop('disabled', true);)
    });

    //patient search option
    $('#patient-search').tokenfield({
        autocomplete :{
            source: function(request, response)
            {
                jQuery.get('../ajax/patient-search.php', {
                    query : request.term
                }, function(data){
                  var ParsedObject = $.parseJSON(data);
                  response($.map(ParsedObject, function (item) {
                      return {
                          label: item.fullname,
                          value: item.complete
                      };

                  }))
                });
            },
            delay: 50
        }
    });

    //search value and populating patient details
    $('#show-data-btn').click(function(){
      //$('#patient-name').text($('#patient-search').val());
      var patient_detail = $('#patient-search').val();
      var split = patient_detail.split(" ");

      // assign patient id to hidden field
      $("#patient-id").val(split[0]);

      // populating fields to patient details
      $('#patient-name').html(split[1] + ' ' + split[2]);
      $('#patient-sex').html(split[3]);
      $('#patient-age').html(split[4]);

      // hide patient search form
      $('#patient-form').toggle();
    });
  });
  </script>

</body>
</html>
