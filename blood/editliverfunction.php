<?php
require '../inc/db.init.php';
$report_link = "liverfunction";

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

if($_SERVER["REQUEST_METHOD"] == "GET") {
  // get id details from report table
  $rid = $_GET['rid'];
  $data_report = $database->get("report",
  ["class_id","class"],
  ["class_type" => "{$report_link}", "rid" => "{$rid}" ]);

  $id = $data_report["class_id"];
  $class = $data_report["class"];
  //echo $id;

  //search semen table with id
  $data_bc = $database->get("{$report_link}",
  ["pid","drid","sbt","conjugated","unconjugated","spt","albumin","globulin",
  "sgot", "sgpt","sap","hbsag", "create_date"],
  ["id" => $id ]);

  $error_db = $database->error() ;
  //var_dump($error_db);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $sbt = $data_bc['sbt'];
  $conjugated = $data_bc['conjugated'];
  $unconjugated = $data_bc['unconjugated'];
  $spt = $data_bc['spt'];
  $albumin = $data_bc['albumin'];
  $globulin = $data_bc['globulin'];
  $sgot = $data_bc['sgot'];
  $sgpt = $data_bc['sgpt'];
  $sap = $data_bc['sap'];
  $hbsag = $data_bc['hbsag'];
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
  <!--<link rel="stylesheet" href="../css/dashboard_style.css">-->
  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />
  <!-- fontawesome APIs -->
  <link rel="stylesheet" href="../css/all.css">
  <style media="screen">
    .heading{
      background-color: #a7a9ab;
      border-radius: 5px;
      padding: 5px;
    }
    .upper{
      text-transform: uppercase;

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

        <a class="btn" id="btn-list" href="http://localhost/pathoapp/listreport.php?type=<?= $report_link ?>">
        <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
      </div>
    </div>

    <div class="line"></div>
    <div class="row mt-3">
      <div class="col-sm-12 text-center mx-auto ">
        <h4 class="display-5 report_header heading" style=""><b>LIVER FUNCTION TEST</b></h4>
      </div>
    </div>
    <div class="line"></div>

    <!-- display patient details on saving patients details -->
    <!-- Header -->

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

    <!-- Pathology form -->
    <div id="pathology" style="d-block; padding: 20px;">
      <form id="pathology-form" method="post" action="updateliverfunction.php" role="form">
        <!-- Partient Doctor Fields -->
        <div class="row">
          <div class="col-sm-2.5">
            <div class="form-group">
              <label for="drid">Referred By : </label>
              <select id="drid" name="drid"  class="form-control" >
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
          </div>
          <div class="col-sm-2">
            <div class="form-group">
                <!--<input type="hidden" id="doctor-id" type="text" name="drid" value="1"  /> -->
              <input type="hidden" id="reportid" type="text" name="id" value="<?= $id ?>" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <b>SERUM BILIRUBIN:</b>
            </div>
            <div class="col-sm-4">
              <div class="form-group">

              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                  <p>NORMAL</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="sbt">Total </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                  <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <input id="total" type="text" name="sbt" class="form-control" placeholder="Total *"
                  value="<?= $sbt ?>"     >
                  <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group">
                <p>Upto 1.0 mg/dl</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="conjugated">Conjugated </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <input id="total" type="text" name="conjugated" class="form-control"
                value="<?= $conjugated ?>" placeholder="Conjugated *" >
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
                <div class="form-group">
                    <p>Upto 0.6 mg/dl</p>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
                <label for="unconjugated">Unconjugated </label>
            </div>
            <div class="col-sm-2 text-center">
                <div class="form-group">
                    <b>:</b>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="unconjugated" type="text" name="unconjugated" class="form-control"
                    placeholder="Unconjugated *" value="<?= $unconjugated ?>">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-4 text-left">
                <div class="form-group">
                    <p>Upto 0.4 mg/dl</p>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <b>SERUM PROTEINS:</b>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <br>
              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                <p></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="spt">Total </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <input id="spt" type="text" name="spt" class="form-control" placeholder="Total *"
                value="<?= $spt?>" >
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group">
                <p>6.0 to 8.0 mg/dl</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="albumin">Albumin </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                  <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <input id="albumin" type="text" name="albumin" class="form-control" placeholder="Albumin *"
                  value="<?= $albumin ?>" >
                  <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group">
                  <p>3.5 to 5.5 mg/dl</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="globulin">Globulin </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <input id="globulin" type="text" name="globulin" class="form-control"
                value="<?= $globulin ?>" placeholder="Globulin *" >
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left">
                <div class="form-group">
                  <p>1.5 to 3.0 mg/dl</p>
                </div>
            </div>
          </div>

          <div class="row">
              <div class="col-sm-2 text-center">
              </div>
              <div class="col-sm-2 text-left">
                <label for="sgot"><b>SGOT</b> </label>
              </div>
              <div class="col-sm-2 text-center">
                <div class="form-group">
                    <b>:</b>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group ">
                  <input id="sgot" type="text" value="<?= $sgot ?>" name="sgot" class="form-control" placeholder="SGOT *">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-sm-4 text-left mx-auto">
                <div class="form-group">
                <p> 5 to 40 units/ml</p>
                </div>
              </div>
          </div>

          <div class="row">
            <div class="col-sm-2 text-center">
            </div>
            <div class="col-sm-2 text-left">
              <label for="sgpt"><b>SGPT</b> </label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                  <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <input id="sgpt" type="text" name="sgpt" class="form-control" value="<?= $sgpt ?>" placeholder="SGPT *" >
                  <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                  <p> 5 to 35 units/ml</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
              <label for="sap"><b>SERUM ALKALINE PHOSPHATE</b></label>
            </div>
            <div class="col-sm-2 text-center">
              <div class="form-group">
                  <b>:</b>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <input id="sap" type="text" name="sap" class="form-control"
                  value="<?= $sap ?>" placeholder="SERUM ALKALINE PHOSPHATE *" >
                  <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
              <div class="form-group">
                  <p> 4 to 11 KA units</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4 text-right">
                <label for="hbsag"><b>Hbs Ag Australia Antigen</b></label>
            </div>
            <div class="col-sm-2 text-center">
                <div class="form-group">
                    <b>:</b>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input id="hbsag" type="text" name="hbsag" class="form-control"
                    value="<?= $hbsag ?>" placeholder="Hbs Ag *" >
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-4 text-left mx-auto">
                <div class="form-group">
                    <p> </p>
                </div>
            </div>
          </div>
          <br><br>

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


  <script src="../js/jquery-3.5.1.min.js"></script>

  <script src="../js/jquery-ui.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- Key Events JS -->
  <script src="../js/addcontact.js"></script>
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">
  //jQuery('#datetimepicker_start').datetimepicker();
  //alert('hello');
  $(function(){

    $( "#pathology-form" ).validate({
      rules: {
        sbt: "required",
        conjugated : "required",
        unconjugated : "required",
        spt : "required",
        globulin : "required",
        albumin: "required"
      },
      messages: {
        spermcount: {
          required: "Please enter the Serum BILIRUBIN total",
          minlength: "Your sperm count must consist of at least 2 characters"
        },
        conjugated : {
          required: "Please enter the conjugated value",
          minlength: "must consist of at least 2 characters"
        },
        unconjugated : {
          required: "Please enter the unconjugated count",
          minlength: "must consist of at least 2 characters"
        },
        spt : {
          required: "Please enter the Serum Proteins",
          minlength: "must consist of at least 2 characters"
        },
        albumin : {
          required: "Please enter the albumin value",
          minlength: "must consist of at least 2 characters"
        },
        puscells: {
          globulin: "Please enter the globulin value",
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
