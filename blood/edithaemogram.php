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

$report_link = "haemogram";
$testname = "HAEMOGRAM";
$pid = "";
$drid = "";
$tec = "";
$haemoglobin = "";
$neutrophils = "";
$eosinophil = "";
$monocytes = "";
$platletscount = "";
$esr = "";
$parasites = "";
$bleedingtime = "";
$clottingtime = "";
$create_date = "";


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
  ["class_type" => "{$report_link}", "rid" => "{$rid}" ]);

  $id = $data_report["class_id"];
  //echo $id;
  //search semen table with id
  $data_bc = $database->get("haemogram",
  ["drid", "pid", "tec", "haemoglobin", "neutrophils", "eosinophil", "monocytes",
  "basophils", "platletscount", "esr", "parasites",
  "bleedingtime", "clottingtime","create_date", "immaturecells", "lymphocytes",
  "sickling", "ppd"],
  ["id" => $id ]);

  //$error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $tec = $data_bc['tec'];
  $haemoglobin = $data_bc['haemoglobin'];
  $neutrophils = $data_bc['neutrophils'];
  $lymphocytes = $data_bc['lymphocytes'];
  $eosinophil = $data_bc['eosinophil'];
  $monocytes = $data_bc['monocytes'];
  $platletscount = $data_bc['platletscount'];
  $esr = $data_bc['esr'];
  $parasites = $data_bc['parasites'];
  $bleedingtime = $data_bc['bleedingtime'];
  $clottingtime = $data_bc['clottingtime'];
  $create_date = $data_bc['create_date'];
  $basophils = $data_bc['basophils'];
  $immaturecells = $data_bc['immaturecells'];
  $sickling = $data_bc['sickling'];
  $ppd = $data_bc['ppd'];

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

  $data_doctor = $database->get("doctor",
  ["initials","firstname","surname","qualification"],
  ["drid" => $drid ]);

  $drinitials = $data_doctor['initials'];
  $drfirstname = $data_doctor['firstname'];
  $drsurname = $data_doctor['surname'];
  $drqualification = $data_doctor['qualification'];
  $doctor_details = $drinitials. "." . $drfirstname. " " . $drsurname. " ". $drqualification;

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
  <!-- Google APIs -->
  <link rel="stylesheet" href="../css/all.css">
  <style type="text/css">
    .report_header{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .column_header {
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
      margin: 5px;
    }
    .field{
      margin-left: 50px;
    }
  </style>

</head>

<body>

  <div class="container">

    <!-- <div class="row">
      <div class="col-1 offset-1">
        <a href="http://localhost/pathoapp/" class="btn">
          <i class="fas fa-home" style="font-size: 45px;" ></i></a>
      </div>
      <div class="col-6">
        <div class="input-group margin-bottom-sm" style="margin-top:5px; padding: 5px; float:left; ">
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
        <a class="btn" id="btn-list" href="http://localhost/pathoapp/listreport.php?type=<?= $report_link ?>">
        <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
      </div>
    </div> -->
    <div class="d-print-none">
      <a href="/pathoapp" role="button">
          <i class="fas fa-home": style="font-size:30px; color:blue;"></i></a>
      <a href="#" class="" role="button" onclick=" window.history.back();">
        <i class='fas fa-arrow-alt-circle-left' style='font-size:30px;color:red'></i></a>
      <a href="/pathoapp/listreport.php?type=<?= $report_link?>" role="button">
          <i class="fas fa-list": style="font-size:30px;"></i></a>

    </div>
    <!-- Patient Details -->
    <div class="row mt-5">
      <div class="col-sm-12 text-center mx-auto ">
        <h4 class="display-5 report_header" style=""><b><?= $testname ?></b></h4>
      </div>
    </div>
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
    <br>
    <!-- display patient details on saving patients details -->

    <!-- Pathology form -->
    <div id="main-form" style="display: block;">
      <form id="pathology-form" method="post" action="updatehaemogram.php" role="form">
        <!-- Patient Doctor Fields -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  Ref By :
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
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="hidden" id="patient-id" type="text" name="id" value="<?= $id ?>"  />
                </div>
            </div>
            <div class="col-sm-4">
            </div>
            <hr style="width:100%">
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="tec"><b>Total Erythrocyte Count:</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="tec" type="text" name="tec" value="<?= $tec ?>"
                    class="form-control" placeholder="Total *">
                </div>
            </div>
            <div class="col-sm-6 text-center mx-auto">
                <div class="form-group">
                    <p><b>DIFFERENTIAL LEUCOCYTE COUNT</b></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="haemoglobin"><b>Haemoglobin (gm %):</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="haemoglobin" type="text" name="haemoglobin"
                    class="form-control" placeholder="haemoglobin *" value="<?= $haemoglobin ?>">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="neutrophils"><b>Neutrophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="neutrophils" type="text" name="neutrophils"
                    class="form-control" placeholder="Neutrophils *" value="<?= $neutrophils ?>">
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">

            </div>
            <div class="col-sm-2">
                <div class="form-group">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="lymphocytes"><b>Lymphocytes</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="lymphocytes" type="text" name="lymphocytes" class="form-control"
                    placeholder="Lymphocytes *" value="<?= $lymphocytes ?>" >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">

            </div>
            <div class="col-sm-2">
                <div class="form-group">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="eosinophil"><b>Eosinophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="eosinophil" type="text" name="eosinophil"
                    class="form-control" placeholder="Eisnophils *"  value="<?= $eosinophil ?>" >
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="monocytes"><b>Monocytes</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="monocytes" type="text" name="monocytes" class="form-control"
                    placeholder="Monocytes *" value="<?= $monocytes ?>">
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="basophils"><b>Basophils</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="basophils" type="text" name="basophils" class="form-control"
                    placeholder="Basophils *" value="<?= $basophils ?>">
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
                <p>%</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
              <div class="form-group">
                <label for="tlc"><b>Total Leucocyte count</b> </label>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <input id="tlc" type="text" name="tlc" class="form-control"
                placeholder="Total Leucocyte count *" value="">
              </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">

            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group"></div>
            </div>
            <div class="col-sm-1 text-center mx-auto">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
            </div>
            <div class="col-sm-2">
                <div class="form-group">

                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">

                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">

                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">

            </div>
            <div class="col-sm-2">
                <div class="form-group">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="platletscount"><b>Platlets Count</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="platletscount" type="text" name="platletscount"
                    class="form-control" placeholder="Platlets Count *" value="<?= $platletscount ?>">
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="esr"><b>E.S.R. (westergren) :</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="esr" type="text" name="esr" class="form-control"
                    placeholder="E.S.R. *" value="<?= $esr ?>">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="parasites"><b>Parasites (MP)</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="parasites" type="text" name="parasites" class="form-control"
                    placeholder="Parasites *" value="<?= $parasites ?>">
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="sickling"><b>Sickling :</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="sicking" type="text" name="sickling" class="form-control"
                    placeholder="E.S.R. *" value="<?= $sickling ?>" >
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="bleedingtime"><b>Bleeding Time</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="bleedingtime" type="text" name="bleedingtime"
                    class="form-control" placeholder="Bleeding Time *" value="<?= $bleedingtime ?>">
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 text-right">
                <label for="ppd"><b>P.P.D. Test :</b> </label>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="ppd" type="text" name="ppd" class="form-control"
                    placeholder="P.P.D. *" value="<?= $ppd ?>">
                </div>
            </div>
            <div class="col-sm-3 text-center mx-auto">
                <div class="form-group">
                    <label for="clottingtime"><b>Clotting Time</b> </label>
                </div>
            </div>
            <div class="col-sm-2 text-center mx-auto">
                <div class="form-group">
                    <input id="clottingtime" type="text" name="clottingtime"
                    class="form-control" placeholder="Clotting Time *" value="<?= $clottingtime ?>">
                </div>
            </div>
            <div class="col-sm-1 text-center mx-auto">
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-6 text-center">
              <p class="text-muted"><strong>*</strong> These fields are required.</p>
            </div>
            <div class="col-md-6 text-left">
                <input type="submit" class="btn btn-warning btn-send" value="Save">
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          </div>
        </div>
      </form>
    </div>

  </div>


  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- add contact -->
  <script src="../js/addcontact.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">

  //alert('hello');
  $(function(){
      $( "#pathology-form" ).validate({
        rules: {
          tec: "required",
          haemoglobin : "required",
          neutrophils : "required",
          lymphocytes : "required",

        },
        messages: {
          tec: {
            required: "Total Erythrocyte Count: ",
            minlength: "Total Erythrocyte Count count must consist of at least 2 characters"
          },

          heamoglobin : {
            required: "Please enter the heamoglobin count",
            minlength: "must consist of at least 1 characters"
          },
          neutrophils : {
            required: "Please enter the neutrophils : ",
            minlength: "must consist of at least 1 characters"
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
