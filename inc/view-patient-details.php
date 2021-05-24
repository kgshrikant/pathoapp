
    <!-- Header -->
    <div class="row mt-5">
      <div class="col-sm-12 text-center mx-auto ">
        <h4 class="display-5 report_header" style=""><b><?= $testname ?></b></h4>
      </div>
      <br>
    </div>

    <!-- Patient Details -->
    <div class="row text-uppercase" style="padding:10px;">
      <div class="col-md-2 text-left">
        Patient Name
      </div>
      <div class="col-sm-5 text-left text-uppercase">
        <b><?php echo $initials." ".$firstname." ".$surname;  ?></b> 
      </div>
      <div class="col-md-3 text-left text-uppercase offset-md-2">
          Report Date :<b> <?= $report_create_date ?> </b>
      </div>
    </div>
    <div class="row text-uppercase" style="padding:10px;">
      <div class="col-md-2 text-left ">
        Age / Gender
      </div>
      <div class="col-sm-8 text-left text-uppercase">
        <b><?= $age; ?></b> Year(s) / <b><?= $sex; ?></b>
        <i class="fas fa-<?= $sex_code ?>" style="font-size:20px; color:red; padding:3px"></i>
      </div>
    </div>

    <!-- Report Details -->
    <div class="row text-uppercase" style="padding:10px;">
      <div class="col-md-2 text-left " >
        Report id
      </div>
      <div class="col-md-4 text-left">
          <b><?= sprintf("%07d", $rid)?></b>
      </div>
    </div>

    <!-- Report Details -->
    <div class="row text-uppercase" style="padding:10px;">
      <div class="col-md-2 text-left">
        Referred By
      </div>
      <div class="col-md-4 text-left">
          <b><?php  echo $drinitials." ".$drfirstname." ".$drsurname; ?></b>,
          (<?php  echo $drqualification; ?>)</b>
      </div>
    </div>
