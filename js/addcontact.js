$(document).ready(function () {
  // show patient form
  // ajax function for searching patient record
  $('#patient-search').keyup(function(){
    var query = $(this).val();
    //alert(query);

    if(query != ''){
      $.ajax({
        url:  "../ajax/patient-search.php",
        type: "POST",
        data:{query:query},
        success:function(data){
          //console.log(data);
          $("#search-result").fadeIn();
          $("#search-result").html(data);
        }
      });
    }
  });

  $(document).on('click','li', function(){
    $("#patient-search").val($(this).text());
    var ptndetail = $(this).text();
    $("#search-result").fadeOut();
    console.log(ptndetail);
    var split = ptndetail.split(",");
    // assign patient id to hidden field
    $("#patient-id").val(split[0]);
    $("#patient-link").attr("href", "../patient-report.php?id="+split[0]);
    // populating fields to patient details
    $('#patient-name').html(split[1] + ' ' + split[2]);
    $('#patient-sex').html(split[3]);
    $('#patient-age').html(split[4]);
    $("#patient-form").fadeOut();
    $('#addformbtn').prop('disabled', false);

  });

  $(document).on('keyup','li', function(){
    var ptndetail = $("#patient-search").val($(this).text());
    $("#search-result").fadeOut();
    //echo (ptndetail);
  });


  $("#btn-save-patient").on("click", function (e) {
    e.preventDefault();
    //alert('btn-save-patient function addcontact.js');
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
            //console.log(dataResult);
            if(dataResult!=0){
              //alert ("Data added successfully !"+dataResult);
              console.log(dataResult);
              $("#patient-form").trigger("reset");
              $("#patient-form").hide();
              $("#patient-details").show();
              $("#main-form").show();
              //alert('hello');
              console.log("pathology div displayed");
              //$("#patient-name").html("Patient : "+initials+". "+firstname+" "+surname);
              $("#patient-name").append("<b>"+initials+". "+firstname+" "+surname+"</b>");
              $("#patient-sex").append("<b>"+sex+"</b>");
              $("#patient-age").append("<b>"+age+"</b> Year(s)");
              $("#patient-id").val(dataResult);
              $("#patient-link").attr("href", "../patient-report.php?id="+dataResult);
              $('#addformbtn').prop('disabled', false);
              $('#patientModelCenter').modal('toggle');
              console.log("console log for modal hidden");
              //$("#patient-form").addClass("d-none");
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
