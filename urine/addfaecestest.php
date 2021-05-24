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

    .form-group{
        margin-bottom: 0.2rem;
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
        <a class="btn" id="btn-show-patient-form"  data-toggle="modal" data-target="#patientModelCenter" href="#">
        <i class="fas fa-user-plus" style="font-size:45px; color: black;"></i> </a>
        <a class="btn" id="btn-list" href="#">
        <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
    </div>

    <!-- Modal login page for add contact -->
    <div class="modal fade" id="patientModelCenter" tabindex="-1" role="dialog" aria-labelledby="patientModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">

          <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title text-uppercase mx-auto" id="patientModalCenterTitle">
              <h5>Add Patient</h5></div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
                <!-- initials firstname lastname -->
              <form id="addpatientform" method="POST">
              <div class="row">
                <div class="col-md-4 offset-md-3" >
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
              </div>
              <br>
              <div class="row">
                <div class="col-md-6 offset-md-3" >
                  <input type="text" id="firstname" class="form-control " name="firstname" placeholder="FIRSTNAME"
                  required="required" data-error="Firstname is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6 offset-md-3" >
                  <input type="text" id="surname" class="form-control" name="surname" placeholder="SURNAME"
                  required="required" data-error="Surname is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4 offset-md-3" >
                  <select id="sex" name="sex" class="form-control">
                    <option value="MALE">MALE</option>
                    <option value="FEMALE">FEMALE</option>
                    <option value="OTHERS">OTHERS</option>
                  </select>
                </div>
                <div class="col-md-0.5" >
                </div>
                <div class="col-md-3" >
                  <input type="text" id="age" class="form-control" name="age" placeholder="AGE">
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-6 offset-md-3" >
                  <input type="phone" id="phone" class="form-control" name="phone" placeholder="PHONE">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6 offset-md-3" >
                  <button type="submit" id="btn-save-patient" class="btn btn-primary"
                  value="Add Patient">SAVE</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>

              </form>
            </div>
          </div>
          <div class="modal-footer">
            <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <!--<button type="button" class="btn btn-primary">Save</button> -->
          </div>
        </div>

      </div>
    </div>
  </div>


    <!-- patient details -->
    <div id="patient-details" class="border border-dark rounded text-uppercase"
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
      <form id="pathology-form" method="post" action="insertfaeces.php" role="form">
        <div class="messages"></div>

        <!-- Physical Examination -->
        <div class="row mt-1">
            <div class="col-sm-12 text-center mx-auto ">
              <h5 class="heading"> <b>FAECES TEST</b></h5>
            </div>
        </div>

        <div class="row">
          <div class="col-sm-5 offset-sm-1">
            <div class="form-group row">
              <label for="drid" class="col-sm-3 col-form-label text-uppercase" >Ref By:</label>
              <div class="col-sm-7">
                <select id="drid" name="drid" class="form-control">
                  <?php
                  foreach($doctor_arr as $doctor){
                     echo "<option value='".$doctor['drid']."' >".$doctor['fullname']."</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <input type="hidden" id="patient-id" type="text" name="pid"  />
          </div>
        </div>


        <div class="row">
          <!-- Column 1 -->
          <div class="col-sm-5 offset-sm-1">

            <div class="form-group row">
              <label for="colour" class="col-sm-5 col-form-label text-uppercase" >Colour</label>
              <div class="col-sm-6">
                <select id="colour" name="colour" style="padding:1px; align:center;" class="form-control text-uppercase align-right" >
                  <option value="yellow">yellow</option>
                  <option value="red">red</option>
                  <option value="block">block</option>
                  <option value="brownish">brownish</option>
                  <option value="white">white</option>
                  <option value="brownish yellow">brownish yellow</option>
                </select>
            </div>
            </div>

            <div class="form-group row">
              <label for="consistency" class="col-sm-5 col-form-label text-uppercase"
              style="">Consistency</label>
              <div class="col-sm-6">
                <select id="consistency" name="consistency"  class="form-control text-uppercase" >
                  <option value="solid">solid</option>
                  <option value="semi solid">semi solid</option>
                  <option value="watery">watery</option>
                  <option value="rise watery">rise watery</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-10 text-left" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 5px;">
                <b>Microscopic</b>
              </div>
            </div>

            <div class="form-group row">
              <label for="amoeba" class="col-sm-5 col-form-label text-uppercase"
              style="">amoeba</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <select id="amoeba" name="amoeba"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="gl" class="col-sm-5 col-form-label text-uppercase"
              style="">giardia lamblia</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <select id="gl" name="gl"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="trichomonas" class="col-sm-5 col-form-label text-uppercase"
              style="">trichomonas</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <select id="trichomonas" name="trichomonas"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="bc" class="col-sm-5 col-form-label text-uppercase"
              style="">balantidium coli</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <select id="bc" name="bc"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="ob" class="col-sm-5 col-form-label text-uppercase"
              style="">occult blood</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <select id="ob" name="ob"  class="form-control text-uppercase" >
                    <option value="not done">not done</option>
                    <option value="positive">positive</option>
                    <option value="negative">negative</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="rs" class="col-sm-5 col-form-label text-uppercase"
              style="">reducing substance</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <select id="rs" name="rs"  class="form-control text-uppercase" >
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="mucous" class="col-sm-5 col-form-label text-uppercase"
              style="">mucous</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <select id="mucous" name="mucous"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="blood" class="col-sm-5 col-form-label text-uppercase"
              style="">blood</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <select id="blood" name="blood"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

          </div>
          <!-- Column 2 -->
          <div class="col-sm-5">

            <div class="form-group row">
              <label for="oc" class="col-sm-4 col-form-label text-uppercase"
              style="">ova/cyst</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="oc" name="oc"  class="form-control text-uppercase" >
                    <option value="cryptosporidium">cryptosporidium</option>
                    <option value="e. histolytica">e. histolytica</option>
                    <option value="giardia">Giardia</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="fat" class="col-sm-4 col-form-label text-uppercase"
              style="">fat</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="fat" name="fat"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="starch" class="col-sm-4 col-form-label text-uppercase"
              style="">starch</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="starch" name="starch"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="yeast" class="col-sm-4 col-form-label text-uppercase"
              style="">yeast</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="yeast" name="yeast"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="aw" class="col-sm-4 col-form-label text-uppercase"
              style="">adult worm</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="aw" name="aw"  class="form-control text-uppercase" >
                    <option value="nil">absent</option>
                    <option value="hook worm">hook worm</option>
                    <option value="ascaris">ascaris</option>
                    <option value="pin worm">pin worm</option>
                    <option value="tinia solium">tinia solium</option>
                  </select>
                </div>
              </div>
            </div>


            <div class="form-group row">
              <label for="larvae" class="col-sm-4 col-form-label text-uppercase"
              style="">larvae</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="larvae" name="larvae"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="rbc" class="col-sm-5 col-form-label text-uppercase"
              style="">red blood cells</label>
              <div class="col-sm-5">
                <div class="form-group">
                  <input id="rbc" type="text" name="rbc" class="form-control" >
                </div>
              </div>
              <div class="col-sm-2">
                /h.p.f.
              </div>
            </div>

            <div class="form-group row">
              <label for="pcess" class="col-sm-5 col-form-label text-uppercase"
              style="">pus cells</label>
              <div class="col-sm-5">
                <div class="form-group">
                  <input id="pcells" type="text" name="pcells" class="form-control" >
                </div>
              </div>
              <div class="col-sm-2">
                /h.p.f.
              </div>
            </div>

            <div class="form-group row">
              <label for="ecells" class="col-sm-5 col-form-label text-uppercase"
              style="">epethelial cells</label>
              <div class="col-sm-5">
                <div class="form-group">
                  <input id="ecells" type="text" name="ecells" class="form-control" >
                </div>
              </div>
              <div class="col-sm-1">
                /h.p.f.
              </div>
            </div>

            <div class="form-group row">
              <label for="macrophages" class="col-sm-4 col-form-label text-uppercase"
              style="">macrophages</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="macrophages" name="macrophages"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="vf" class="col-sm-4 col-form-label text-uppercase"
              style="">vegetable fibres</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="vf" name="vf"  class="form-control text-uppercase" >
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

          </div>
        </div>


        <br>
        <div class="row">
          <div class="col-md-12 text-center display-5">
            <input type="submit" id ="addformbtn" disabled="disabled" class="btn btn-warning btn-send" value="Save">
          </div>
        </div>
    </form>
  </div>
  <br><br>
  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>

  <script src="../js/jquery-ui.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>

  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <!-- Key Events JS -->
  <script src="../js/addcontact.js"></script>

  <script type="text/javascript">

  $(document).ready(function(){
    //alert('hello');
    $( "#pathology-form" ).validate({
      rules: {
        spermcount: "required",
        active : "required"
      },
      messages: {
        spermcount: {
          required: "Please enter the sperm count",
          minlength: "Your sperm count must consist of at least 2 characters"
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

  $(document).keyup(function (e) {
    //alert(e.keyCode);
    switch (e.keyCode) {
      case 65:
        $('#exampleModalCenter').modal('show');
        $('#patient-name').focus();
        break;
      }
    });

  </script>
</body>


</html>
