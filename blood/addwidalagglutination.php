<?php
require '../inc/db.init.php';
$report_link = "widalagglutination";

$data_doctor = $database->select("doctor",
["drid","initials","firstname","surname"],
["drid[>]" => 0]
);
$report_link = 'widalagglutination';
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

  <!-- patient search page links and add Patient modal page -->
  <!-- patient details -->
  <?php include("../inc/search-add-patient.php"); ?>
  <br>

  <!-- Pathology Form -->
  <div id="main-form" style="display: block;">
    <form id="pathology-form" method="post" action="insertwidalagglutination.php" role="form">
      <div class="messages"></div>
      <br><br>
      <!-- Physical Examination -->
      <div class="row mt-1">
          <div class="col-sm-12 text-center mx-auto ">
            <h5 class="heading"> <b>WIDAL AGGLUTINATION TEST</b></h5>
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

      <!-- Collection QUALITATIVE -->
      <div class="row ">
        <label for="qualitywt" class="col-sm-3 col-form-label"
        style="position: relative; left:20px; top:1px;">QUALITATIVE WIDAL TEST</label>

        <div class="col-3">
          <div class="form-group" >
            <select id="qualitywt" name="qualitywt" class="form-control">

              <option value="NEGATIVE">NEGATIVE</option>
              <option value="POSITIVE">POSITIVE</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Collection QUANTITATIVE -->
      <div class="row ">
        <label for="quantitywt" class="col-sm-3 col-form-label"
        style="position: relative; left:20px; top:1px;">QUALITATIVE WIDAL TEST</label>

        <div class="col-3">
          <div class="form-group">
            <input type="text" id="qualitywt" name="qualitywt" disabled class="form-control">
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-1">
        </div>

        <div class="col-10">
          <table class="table table-grey">
            <thead style="text-align: center;" class="thead-dark">
              <tr>
                <th>Dilution of Serum : </th>
                <th>1/20</th>
                <th>1/40</th>
                <th>1/80</th>
                <th>1/160</th>
                <th>1/320</th>
                <th>1/640</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>S TYPHI 'O'</td>
                <td>
                  <select id="o1" name="o1" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="o2" name="o2" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="o3"name="o3" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="o4" name="o4" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="o5" name="o5" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="o6" name="o6" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>S TYPHI 'H'</td>
                <td>
                  <select id="h1" name="h1" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="h2" name="h2" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="h3"name="h3" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="h4" name="h4" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="h5" name="h5" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="h6" name="h6" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td>S TYPHI 'AH'</td>
                <td>
                  <select id="ah1" name="ah1" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="ah2" name="ah2" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="ah3"name="ah3" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="ah4" name="ah4" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="ah5" name="ah5" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="ah6" name="ah6" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>S TYPHI 'BH'</td>
                <td>
                  <select id="bh1" name="bh1" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="bh2" name="bh2" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="bh3"name="bh3" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="bh4" name="bh4" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="bh5" name="bh5" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td>
                  <select id="bh6" name="bh6" class="form-control">
                    <option value="0">-ve</option>
                    <option value="1">+ve</option>
                  </select>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-1">
        </div>
      </div>

      <br><br>
      <div class="row">
        <div class="col-md-8 text-right display-5">
          <input type="submit" disabled="disabled" id ="addformbtn" class="btn btn-warning btn-send" value="Save">
        </div>
      </div>
  </form>
  </div>

  <!-- jQuery CDN - min version -->
  <script src="../js/jquery-3.5.1.min.js"></script>
<!-- jQuery UI version -->
  <script src="../js/jquery-ui.js"></script>
  <!-- Popper.JS -->
  <script src="../js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- Key add contact JS -->
  <script src="../js/addcontact.js"></script>
  <!-- jQuery Validation -->
  <script src="../js/jquery.validate.js"></script>

  <script type="text/javascript">
  //jQuery('#datetimepicker_start').datetimepicker();
  //alert('hello');

  </script>
</body>


</html>
