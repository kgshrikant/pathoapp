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
$testname = "ELECTROLYTE";
$report_link = "electrolyte";

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
  ["pid","drid","sodium","potassium","calcium", "create_date"],
  ["id" => $id ]);

  $pid = $data_bc['pid'];
  $drid = $data_bc['drid'];
  $sodium = $data_bc['sodium'];
  $potassium = $data_bc['potassium'];
  $calcium = $data_bc['calcium'];
  $error_db = $database->error() ;
  //var_dump($error_db);
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
  <!-- Google APIs -->
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
          <input class="form-control" disabled="disabled" typeid="patient-search" type="text" placeholder="Search Patients .." >
          <div class="input-group-btn" >
            <button class="btn btn-warning" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="col-3">
          <a class="btn" id="btn-show-patient-form" disabled >
          <i class="fas fa-user-plus" style="font-size:45px; color: black;"></i> </a>
          <a class="btn" id="btn-list" href="#">
          <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
      </div>
    </div>
    <div class="row text-center mx-auto">
      <div class="col-md-12 report_header">
        <h4>ELECTROLYTE TEST</h4>
      </div>
    </div>

    <!-- display patient details on saving patients details -->
    <div class="row mx-auto text-uppercase" style="padding:10px;">
      <div class="col-sm-1.5  text-left" style="margin-left:20px;">
          Patient Name
      </div>
      <div class="col-sm-8 text-left">
        :&nbsp&nbsp<b><?php echo $initials." ".$firstname." ".$surname;  ?></b>
      </div>
    </div>

    <div class="row mx-auto text-uppercase" style="padding:10px;">
      <div class="col-sm-1.5 text-left " style="margin-left:20px;" >
        Age / Gender
      </div>
      <div class="col-sm-8 text-left ">
        :&nbsp&nbsp<b><?= $age; ?></b> Year(s) / <b><?= $sex; ?></b>
        <i class="fas fa-<?= $sex_code ?>" style="font-size:20px; color:red; padding:3px"></i>
      </div>
    </div>

    <!-- Report Details -->
    <div class="row mx-auto text-uppercase" style="padding:10px;">
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
    <div id="main-form" style="display: block;">
      <form id="pathology-form" method="post" action="update<?= $report_link ?>.php" role="form">
          <!-- Partient Doctor Fields -->
          <div class="row">
            <div class="col-sm-3 offset-sm-2">
              <div class="form-group">
                <br>
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
                  <input type="hidden" id="patient-id" type="text" name="id" value="<?= $id ?>" />
                </div>
              </div>


          </div>

          <div class="row">
              <div class="col-sm-2 text-center offset-sm-2">
                  <label for="tec"><b>TEST:</b> </label>
                  <hr style="width:100%">
              </div>
              <div class="col-sm-2 text-center">
                  <div class="form-group">
                      <p><b>RESULT</b></p>
                      <hr style="width:100%">
                  </div>
              </div>
              <div class="col-sm-2 offset-sm-1">
                  <div class="form-group">
                      <p><b>NORMAL VALUE</b></p>
                      <hr style="width:100%">
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-2 text-left offset-sm-2">
                  <label for="sodium"><b>Na (Sodium)</b> </label>
              </div>
              <div class="col-sm-2 text-left">
                  <div class="form-group">
                      <input id="sodium" type="sodium" name="sodium" class="form-control"
                      placeholder="Sodium *" value="<?= $sodium ?>"  >
                      <hr style="width:100%">
                  </div>
              </div>
              <div class="col-sm-4 text-left mx-auto">
                  <div class="form-group">
                      <p><b>[135 to 155]</b></p>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-2 text-left offset-sm-2">
                  <label for="potassium"><b>K (Potassium)</b> </label>
              </div>
              <div class="col-sm-2 text-left">
                  <div class="form-group">
                      <input id="potassium" type="text" name="potassium" class="form-control"
                      placeholder="Potassium *" value="<?= $potassium ?>"  >
                      <hr style="width:100%">
                  </div>
              </div>
              <div class="col-sm-4 text-left mx-auto">
                  <div class="form-group">
                      <p><b>[3.5 to 5.5]</b></p>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-2 text-left offset-sm-2">
                  <label for="calcium"><b>Ca (Calcium) </b> </label>
              </div>
              <div class="col-sm-2 text-left">
                  <div class="form-group">
                      <input id="calcium" type="text" name="calcium" class="form-control"
                      placeholder="Calcium *" value="<?= $calcium ?>"   >
                      <hr style="width:100%">
                  </div>
              </div>
              <div class="col-sm-4 text-left mx-auto">
                  <div class="form-group">
                      <p><b>[1.10 to 1.35]</b></p>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-4 text-center">
              </div>
              <div class="col-md-2 text-left">

              </div>
              <div class="col-md-5 text-left mx-auto">
                  <input type="submit" class="btn btn-warning btn-send" value="Save">
                  <p class="text-muted"><strong>*</strong> These fields are required.</p>
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
                  console.log("Data added successfully !"+dataResult);
                  $("#patient-form").trigger("reset");
                  $("#patient-form").hide(100);
                  $("#patient-details").show();
                  $("#pathology-form").show();
                  //$("#blood-group").show();
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
