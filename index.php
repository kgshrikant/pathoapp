<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PATHOLAB</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/dashboard_style.css">
    <link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico' />
    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="css/all.css" >
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3>PATHOLAB</h3>
        <a href="index.php">
          <img class="circle-design" src="images/android-chrome-192x192.png" alt="">
        </a>
      </div>

      <ul class="list-unstyled components">
        <p>Menu</p>
        <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle">BLOOD <i class="fas fa-burn" style="color: red;" aria-hidden="true"> </i></a>

            <ul class="collapse list-unstyled" id="homeSubmenu">
              <li>
                  <a href="blood/addbloodchemistry.php">Blood Chemistry</a>
              </li>
              <li>
                  <a href="blood/addbloodgroup.php">Blood Grouping</a>
              </li>
              <li>
                  <a href="blood/addbloodsugarbiochemistry.php">Blood Sugar Biochemistry</a>
              </li>
              <li>
                  <a href="blood/addcompletehaemogram.php">Complete Haemogram</a>
              </li>
              <li>
                  <a href="blood/addhaemogram.php">Haemogram</a>
              </li>
              <li>
                  <a href="blood/addelectrolyte.php">Electrolyte</a>
              </li>
              <li>
                  <a href="blood/addliverfunction.php">Liver Function</a>
              </li>
              <li>
                  <a href="blood/addwidalagglutination.php">Widal AGGLUTINATION</a>
              </li>
              <li>
                  <a href="blood/addlipidprofile.php">Lipid Profile</a>
              </li>
              <li>
                  <a href="blood/addserology.php">Serology</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#urineSubmenu" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle">URINE <i class="fa fa-tint" style="color: yellow;" aria-hidden="true"> </i></a>
            <ul class="collapse list-unstyled" id="urineSubmenu">
              <li>
                <a href="urine/addurine.php">Urine Test</a>
              </li>
            </ul>
          </li>


          <li>
            <a href="urine/addsemen.php">SEMEN <i class="fas fa-tint" style="color: white;"></i></a>
          </li>
          <li>
            <a href="urine/addfaeces.php">FAECES <i class="fas fa-poop" style="color: brown; size: 24px;"></i></a>
          </li>
          <li>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">SETTINGS</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="forms/adddoctor.php">Doctor</a>
                </li>
            </ul>
          </li>
          <li>
            <a href="listreport.php">LIST REPORTS</a>
          </li>
          <li>
            <a href="advancedsearch.php">ADVANCED SEARCH</a>
          </li>
          <li>
            <a href="settings.php">Settings</a>
          </li>
      </ul>
  </nav>
  <div class="container-fluid" style="position: relative; " >
    <div class="offset-md-8 col-md-4">
      <table class="table ">
        <thead class="thead-dark text-left">
          <tr class="font-weight-bold col">
            <th>Shortcut</th>
            <th >Report</th>
          </tr>

        </thead>
        <tbody class="text-left">
          <tr>
            <td>1</td>
            <td><a href="blood/addbloodchemistry.php">Blood Chemistry</a></td>
          </tr>
          <tr>
            <td>2</td>
            <td>
              <a href="blood/addbloodgroup.php">Blood Grouping</a>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>
              <a href="blood/addbloodsugarbiochemistry.php">Blood Sugar Biochemistry</a>
            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>
              <a href="blood/addcompletehaemogram.php">Complete Haemogram</a>
            </td>
          </tr>
          <tr>
            <td>5</td>
            <td>
              <a href="blood/addhaemogram.php">Haemogram</a>
            </td>
          </tr>

          <tr>
            <td>6</td>
            <td>
              <a href="blood/addelectrolyte.php">Electrolyte</a>
            </td>
          </tr>

          <tr>
            <td>7</td>
            <td>
              <a href="blood/addliverfunction.php">Liver Function</a>
            </td>
          </tr>

          <tr>
            <td>8</td>
            <td>
              <a href="blood/addwidalagglutination.php">Widal Agglunation</a>
            </td>
          </tr>

          <tr>
            <td>9</td>
            <td>
              <a href="blood/addlipidprofile.php">Lipid Profile</a>
            </td>
          </tr>
          <tr>
            <td>A</td>
            <td>
              <a href="urine/addurine.php">A Urine Test</a>
            </td>
          </tr>
          <tr>
            <td>B</td>
            <td>
              <a href="urine/addsemen.php">B Semen Test</a>
            </td>
          </tr>
          <tr>
            <td>C</td>
            <td>
              <a href="urine/addfaeces.php">C Faeces Test</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
  </div>

  <!-- jQuery CDN - -->
  <script src="js/jquery-3.5.1.min.js"></script>
  <!-- Popper.JS -->
  <script src="js/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="js/bootstrap.min.js"></script>

  <script type="text/javascript">


      $(document).keyup(function (e) {
        //alert(e.keyCode);
        switch (e.keyCode) {
          case 49:
            window.location.href = '/pathoapp/blood/addbloodchemistry.php';
            break;
          case 97:
            window.location.href = 'pathoapp/blood/addbloodchemistry.php';
            break;
          case 50:
            window.location.href = '/pathoapp/blood/addbloodgroup.php';
            break;
          case 98:
            window.location.href = '/pathoapp/blood/addbloodgroup.php';
            break;
          case 51:
            window.location.href = '/pathoapp/blood/addbloodsugarbiochemistry.php';
            break;
          case 99:
            window.location.href = '/pathoapp/blood/addbloodsugarbiochemistry.php';
            break;
          case 52:
            window.location.href = '/pathoapp/blood/addcompletehaemogram.php';
            break;
          case 100:
            window.location.href = '/pathoapp/blood/addcompletehaemogram.php';
            break;
          case 53:
            window.location.href = '/pathoapp/blood/addhaemogram.php';
            break;
          case 101:
            window.location.href = '/pathoapp/blood/addhaemogram.php';
            break;
          case 54:
            window.location.href = '/pathoapp/blood/addelectrolyte.php';
            break;
          case 102:
            window.location.href = '/pathoapp/blood/addelectrolyte.php';
            break;
          case 55:
            window.location.href = '/pathoapp/blood/addliverfunction.php';
            break;
          case 103:
            window.location.href = '/pathoapp/blood/addliverfunction.php';
            break;
          case 56:
            window.location.href = '/pathoapp/blood/addwidalagglutination.php';
            break;
          case 104:
            window.location.href = '/pathoapp/blood/addwidalagglutination.php';
            break;
          case 57:
            window.location.href = '/pathoapp/blood/addlipidprofile.php ';
            break;
          case 105:
            window.location.href = '/pathoapp/blood/addlipidprofile.php ';
            break;
          case 27:
            window.location.href = '/pathoapp/';
            break;
          case 76:
            window.location.href = '/pathoapp/listreport.php';
            break;
          case 76:
            window.location.href = '/pathoapp/listreport.php';
            break;
          case 65:
            window.location.href = '/pathoapp/urine/addurine.php';
            break;
          case 66:
            window.location.href = '/pathoapp/urine/addsemen.php';
            break;
          case 67:
            window.location.href = '/pathoapp/urine/addfaeces.php';
            break;
          }
        });
    </script>
  </script>
</body>
</html>
