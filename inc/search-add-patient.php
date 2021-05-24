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
      <a class="btn" id="btn-show-patient-form" data-toggle="modal" data-target="#patientModelCenter" href="#" >
      <i class="fas fa-user-plus" style="font-size:45px; color: black;"></i> </a>
      <a class="btn" id="btn-list" href="../listreport.php?type=<?= $report_link ?>">
      <i class="fas fa-list"  style="font-size:45px; color: black;"></i> </a>
  </div>
  <div class="modal fade" id="patientModelCenter" tabindex="-1" role="dialog" aria-labelledby="patientModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title text-uppercase mx-auto" id="patientModalCenterTitle">
          <i class="fas fa-user-plus" style="font-size:25px; color: dark-grey;"> Add Patient</i>
          </div>
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

<div id="patient-details" class="border border-dark rounded text-uppercase"
style="display: block; padding:20px;">
  <div class="row text-center mx-auto ">
    <div class="col-sm-12 text-center mx-auto ">
      <h5 class="heading"> <b>PATIENT DETAILS</b></h5>

    </div>
  </div>
  <div class="row text-center mx-auto ">

      <div class="col-3" >
          <a style="color:blue;" href="#" id="patient-link">Patient :</a> <b><div id="patient-name"></div></b>
      </div>
      <div  class="col-3 text-center mx-auto ">
          Sex : <b><div id="patient-sex"></div></b>
      </div>
      <div class="col-3 text-center mx-auto">
          Age : <b><div id="patient-age"></div></b>
      </div>
  </div>
</div>
