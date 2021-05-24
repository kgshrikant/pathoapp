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
    <!-- patient search page links and add Patient modal page -->
    <!-- patient details -->
    <?php include("../inc/search-add-patient.php"); ?>

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
              <label for="colour" class="col-sm-3 col-form-label text-uppercase" >Colour</label>
              <div class="col-sm-7">
                <select id="colour" name="colour" style="padding:1px; align:center;" class="form-control text-uppercase align-right" >
                  <option value=""></option>
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
              <label for="consistency" class="col-sm-3 col-form-label text-uppercase"
              style="">Consistency</label>
              <div class="col-sm-7">
                <select id="consistency" name="consistency"  class="form-control text-uppercase" >
                  <option value=""></option>
                  <option value="solid">solid</option>
                  <option value="semi solid">semi solid</option>
                  <option value="watery">watery</option>
                  <option value="rise watery">rise watery</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-3 text-left" style="background-color: #a7a9ab; border-radius: 5px; padding: 5px; margin: 5px;">
                <b>Microscopic</b>
              </div>
            </div>

            <div class="form-group row">
              <label for="amoeba" class="col-sm-3 col-form-label text-uppercase"
              style="">amoeba</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="amoeba" name="amoeba"  class="form-control text-uppercase" >
                    <option value=""></option>
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="gl" class="col-sm-3 col-form-label text-uppercase"
              style="">giardia lamblia</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="gl" name="gl"  class="form-control text-uppercase" >
                    <option value=""></option>
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="trichomonas" class="col-sm-3 col-form-label text-uppercase"
              style="">trichomonas</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="trichomonas" name="trichomonas"  class="form-control text-uppercase" >
                    <option value=""></option>
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="bc" class="col-sm-3 col-form-label text-uppercase"
              style="">balantidium coli</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="bc" name="bc"  class="form-control text-uppercase" >
                    <option value=""></option>
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="ob" class="col-sm-3 col-form-label text-uppercase"
              style="">occult blood</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="ob" name="ob"  class="form-control text-uppercase" >
                    <option value=""></option>
                    <option value="not done">not done</option>
                    <option value="positive">positive</option>
                    <option value="negative">negative</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="rs" class="col-sm-3 col-form-label text-uppercase"
              style="">reducing substance</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="rs" name="rs"  class="form-control text-uppercase" >
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="mucous" class="col-sm-3 col-form-label text-uppercase"
              style="">mucous</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="mucous" name="mucous"  class="form-control text-uppercase" >
                    <option value=""></option>
                    <option value="0">absent</option>
                    <option value="1">present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="blood" class="col-sm-3 col-form-label text-uppercase"
              style="">blood</label>
              <div class="col-sm-7">
                <div class="form-group">
                  <select id="blood" name="blood"  class="form-control text-uppercase" >
                    <option value=""></option>
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
                    <option value=""></option>
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
                    <option value=""></option>
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
                    <option value=""></option>
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
                    <option value=""></option>
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
                    <option value=""></option>
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
                    <option value=""></option>
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
                    <option value=""></option>
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
                    <option value=""></option>
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


  </script>
</body>


</html>
