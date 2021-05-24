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

$pid = "";
$drid = "";
$report_id = "";
$report_create_date = "" ;
$rid = "";
$message_result = "";
$testname = "FAECES";
$report_link = 'faeces';

$pid = "";
$drid = "";


$class_id = "";
$message_result = "";

// patient details
$initials =  "";
$firstname =  "";
$surname =  "";
$sex =  "";
$age =  "";
$patient_details =  "";

//dr details
$drinitials = '';
$drfirstname = '';
$drsurname = '';
$drqualification = '';
$doctor_details = '';

$report_create_date = date("Y/m/d");

if($_SERVER["REQUEST_METHOD"] == "GET") {

  // get id details from report table
   $rid = $_GET['rid'];
   $data_report = $database->get("report",
   ["class_id"],
   ["class_type" => "faeces", "rid" => "{$rid}" ]);

   $id = $data_report["class_id"];
   //echo $id;
  //search semen table with id
  $data_bc = $database->get("faeces","*",
  ["id" => $id ]);

  $error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $colour = $data_bc['colour'];
  $consistency = $data_bc['consistency'];
  $amoeba = $data_bc['amoeba'];
  $gl = $data_bc['gl'];
  $trichomonas = $data_bc['trichomonas'];
  $bc = $data_bc['bc'];
  $ob = $data_bc['ob'];
  $rs = $data_bc['rs'];
  $mucous = $data_bc['mucous'];
  $blood = $data_bc['blood'];
  $oc= $data_bc['oc'];
  $fat= $data_bc['fat'];
  $starch= $data_bc['starch'];
  $yeast= $data_bc['yeast'];
  $aw= $data_bc['aw'];
  $larvae= $data_bc['larvae'];
  $rbc= $data_bc['rbc'];
  $pcells= $data_bc['pcells'];
  $ecells= $data_bc['ecells'];
  $macrophages= $data_bc['macrophages'];
  $vf= $data_bc['vf'];
  $report_create_date = date("d/m/Y",strtotime($data_bc['create_date']));

  $data_patient = $database->get("patient",
  ["pid","firstname","surname","sex","age","initials"],
  ["pid" => $pid ]);

  $initials = $data_patient['initials'];
  $firstname = $data_patient['firstname'];
  $surname = $data_patient['surname'];
  $sex = $data_patient['sex'];
  $age = $data_patient['age'];
  $patient_details = "initials: " . $initials. ", Name: " . $firstname. " " . $surname. ", sex: ". $sex. ", age: ".$age;

  if($sex == "MALE"){
    $sex_code = "mars";
  }else {
    $sex_code = "venus";
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


    .form-group{
      margin-bottom: 0.2rem;
      //line-height: 0;
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



    <!-- Patient Details -->
    <div class="row mx-auto" style="padding:10px;">
      <div class="col-sm-1.5  text-left" style="margin-left:20px;">
          Patient Name
      </div>
      <div class="col-sm-8 text-left">
        :&nbsp&nbsp<b><?php echo $initials." ".$firstname." ".$surname;  ?></b>
      </div>
    </div>
    <div class="row mx-auto" style="padding:10px;">
      <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
        Age / Gender
      </div>
      <div class="col-sm-8 text-left ">
        :&nbsp&nbsp<b><?= $age; ?></b> Year(s) / <b><?= $sex; ?></b>
        <i class="fas fa-<?= $sex_code ?>" style="font-size:20px; color:red; padding:3px"></i>
      </div>
    </div>

    <!-- Report Details -->
    <div class="row mx-auto" style="padding:10px;">
      <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
        Report id &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      </div>
      <div class="col-sm-4 text-left">
          :&nbsp <b><?= sprintf("%07d", $rid)?></b>
      </div>
      <div class="col-sm-4 text-left">
      </div>
      <div class="col-sm-8.5 text-right">
          Report Date :<b> <?= $report_create_date ?> </b>
      </div>
    </div>


    <div id="main-form" style="display: block;">
      <form id="pathology-form" method="post" action="updatefaeces.php" role="form">
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
                     if($doctor['drid'] == $drid){
                       echo "<option value='".$doctor['drid']."' selected>".$doctor['fullname']."</option>";
                     }
                     else {
                       echo "<option value='".$doctor['drid']."'>".$doctor['fullname']."</option>";
                     }
                    }
                  ?>
                </select>
              </div>
            </div>
            <input type="hidden" id="report-id" type="text" name="id" value="<?= $id ?>"  />
          </div>
        </div>


        <div class="row">
          <!-- Column 1 -->
          <div class="col-sm-5 offset-sm-1">

            <div class="form-group row">
              <label for="colour" class="col-sm-3 col-form-label text-uppercase" >Colour</label>
              <div class="col-sm-7">

                <select id="colour" name="colour" style="padding:1px; align:center;" class="form-control text-uppercase align-right" >
                  <?php
                    $colour_arr = array("yellow"=>"yellow",
                                        "red"=>"red",
                                        "black"=>"black",
                                        "brownish"=>"brownish",
                                        "white"=>"white",
                                        "brownish yellow"=>"brownish yellow");
                    foreach($colour_arr as $c => $c_value ){
                     if($c_value == $colour){
                       echo "<option value='{$c_value}' selected>".$c."</option>";
                     }
                     else {
                       echo "<option value='{$c_value}'>".$c."</option>";
                     }
                    }
                   ?>
                </select>
            </div>
            </div>

            <div class="form-group row">
              <label for="consistency" class="col-sm-3 col-form-label text-uppercase"
              style="">Consistency</label>
              <div class="col-sm-7">
                <select id="consistency" name="consistency"  class="form-control text-uppercase" >
                  <?php
                    $solid_arr = array("solid"=>"solid",
                                        "semi solid"=>"semi solid",
                                        "watery"=>"watery",
                                        "rise watery"=>"rise watery");
                    foreach($solid_arr as $s => $s_value ){
                     if($s_value == $consistency){
                       echo "<option value='{$s_value}' selected>".$s."</option>";
                     }
                     else {
                       echo "<option value='{$s_value}'>".$s."</option>";
                     }
                    }
                   ?>

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
                    <option value="0"<?= ($amoeba == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($amoeba == 1? 'selected' : '') ?>>present</option>
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
                    <option value="0"<?= ($gl == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($gl == 1? 'selected' : '') ?>>present</option>
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
                    <option value="0" <?= ($trichomonas == 0? 'selected' : '') ?>>absent</option>
                    <option value="1" <?= ($trichomonas == 1? 'selected' : '') ?>>present</option>
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
                    <option value="0"<?= ($bc == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($bc == 1? 'selected' : '') ?>>present</option>
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
                    <?php
                      $ob_arr = array("not done"=>"not done",
                                          "positive"=>"positive",
                                          "negative"=>"negative");
                      foreach($ob_arr as $o => $o_value ){
                       if($o_value == $ob){
                         echo "<option value='{$o_value}' selected>".$o."</option>";
                       }
                       else {
                         echo "<option value='{$o_value}'>".$o."</option>";
                       }
                      }
                     ?>
                    <!-- <option value="not done">not done</option>
                    <option value="positive">positive</option>
                    <option value="negative">negative</option> -->
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
                    <option value="0"<?= ($mucous == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($mucous == 1? 'selected' : '') ?>>present</option>
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
                    <option value="0"<?= ($blood == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($blood == 1? 'selected' : '') ?>>present</option>
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
                    <?php
                      $oc_arr = array("cryptosporidium"=>"cryptosporidium",
                                          "e. histolytica"=>"e. histolytica",
                                          "giardia"=>"giardia");
                      foreach($oc_arr as $occ => $occ_value ){
                       if($occ_value == $oc){
                         echo "<option value='{$occ_value}' selected>".$occ."</option>";
                       }
                       else {
                         echo "<option value='{$occ_value}'>".$occ."</option>";
                       }
                      }
                     ?>
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
                    <option value="0"<?= ($fat == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($fat == 1? 'selected' : '') ?>>present</option>
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
                    <option value="0"<?= ($starch == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($starch == 1? 'selected' : '') ?>>present</option>
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
                    <option value="0"<?= ($yeast == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($yeast == 1? 'selected' : '') ?>>present</option>
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
                    <?php
                      $aw_arr = array("absent"=>"absent",
                                      "hook worm"=>"hook worm",
                                      "ascaris"=>"ascaris",
                                      "pin worm"=>"pin worm",
                                      "tinia solium"=>"tinia solium");
                      foreach($aw_arr as $a => $a_value ){
                       if($a_value == $aw){
                         echo "<option value='{$a_value}' selected>".$a."</option>";
                       }
                       else {
                         echo "<option value='{$a_value}'>".$a."</option>";
                       }
                      }
                    ?>

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
                    <option value="0"<?= ($larvae == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($larvae == 1? 'selected' : '') ?>>present</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="rbc" class="col-sm-5 col-form-label text-uppercase"
              style="">red blood cells</label>
              <div class="col-sm-5">
                <div class="form-group">
                  <input id="rbc" type="text" name="rbc" value="<?= $rbc ?>" class="form-control" >
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
                  <input id="pcells" type="text" name="pcells" value="<?= $pcells ?>" class="form-control" >
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
                  <input id="ecells" type="text" name="ecells" value="<?= $ecells ?>" class="form-control" >
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
                    <option value="0"<?= ($macrophages == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($macrophages == 1? 'selected' : '') ?>>present</option>
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
                    <option value="0"<?= ($vf == 0? 'selected' : '') ?>>absent</option>
                    <option value="1"<?= ($vf == 1? 'selected' : '') ?>>present</option>
                  </select>
                </div>
              </div>
            </div>

          </div>
        </div>


        <br>
        <div class="row">
          <div class="col-md-12 text-center display-5">
            <input type="submit" id ="addformbtn" class="btn btn-warning btn-send" value="Save">
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
  <!-- Key Events JS -->
  <script src="../js/addcontact.js"></script>
  <!-- Datepicker JS -->
  <script src="../js/jquery.simple-dtpicker.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">
  //jQuery('#datetimepicker_start').datetimepicker();
  //alert('hello');
  $(function(){
			$('#datetimepicker_start').appendDtpicker({
        //"dateFormat": "DD/MM/YYYY HH:mm TT"
      });
      $('#datetimepicker_end').appendDtpicker({
        //"dateFormat": "DD/MM/YYYY HH:mm TT"
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
