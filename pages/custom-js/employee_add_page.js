$(document).ready(function(){
//below function is used for password field in add_employee page
 $('#emp_password').blur(function() {
        var value = $('#emp_password').val();
        if(value.length <= 0) {
          alert('please fillup the password field');
        }
      });

     $('#confirmpass').blur(function() {
      var pwd = $('#emp_password').val();
      var value = $('#confirmpass').val();
      if(value.length <= 0) {
        alert('please fillup the confirm password field');
      }
      else if(pwd!=value){
       $('#confirmpass').val("");
       alert('password not match');

      }
    });
 
// below function is used for mobile number field in add_employee page
$('#mobilenumber').blur(function() {
	var value = $('#mobilenumber').val();
	if(value.length < 10) {
		alert('mobile number is wrong');
	}
});
// below function is used for emergency contact no field in add_employee page
$('#ecn').blur(function() {
	var value = $('#ecn').val();
	if(value.length < 10) {
		alert('mobile number is wrong');
	}
});
// below function is used for refernce contact no field in add_employee page
$('#rcn').blur(function() {
	var value = $('#rcn').val();
	if(value.length < 10) {
		alert('mobile number is wrong');
	}
});



$('#same_address').click( function() {
   $('#tempaddress').val($('#parmentaddress').val());
});


$('#yes, #no').change(function(){
    var isChecked = jQuery("input[name=document]:checked").val();
    if(isChecked =='yes'){
      $('#matric_snap_div').removeClass('hidden').addClass('visible');
      $('#intermediate_snap_div').removeClass('hidden').addClass('visible');
      $('#graduation_snap_div').removeClass('hidden').addClass('visible');
      $('#post_graduation_snap_div').removeClass('hidden').addClass('visible');
      $('#address_proof_snap_div').removeClass('hidden').addClass('visible');
      $('#pan_card_snap_div').removeClass('hidden').addClass('visible');
      $('#experience_snap_div').removeClass('hidden').addClass('visible');
      $('#relv_snap_div').removeClass('hidden').addClass('visible');
    }
    if(isChecked =='no'){
      $('#intermediate_snap_div').removeClass('visible').addClass('hidden');
      $('#matric_snap_div').removeClass('visible').addClass('hidden');
      $('#graduation_snap_div').removeClass('visible').addClass('hidden');
      $('#post_graduation_snap_div').removeClass('visible').addClass('hidden');
      $('#address_proof_snap_div').removeClass('visible').addClass('hidden');
      $('#pan_card_snap_div').removeClass('visible').addClass('hidden');
      $('#experience_snap_div').removeClass('visible').addClass('hidden');
      $('#relv_snap_div').removeClass('visible').addClass('hidden');
    }  
});

// below function is used for email field in add_employee page
$('#email').blur(validate);
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function validate() {
  $("#result").text("");
  var email = $("#email").val();
  if (validateEmail(email)) {
    $("#result").text(email + " is valid :)");
    $("#result").css("color", "green");
  } else {
    $("#result").text(email + " is not valid :(");
    $("#result").css("color", "red");
  }
  return false;
}
    });