function loginid() {
  var loginid = document.getElementById('login_id').value;
    if(loginid == ""){
      document.getElementById('lspan').innerHTML = "is empty";
    }
    else if(loginid.length > 0) {
      document.getElementById('lspan').innerHTML = '';
    }
}

function password_check() {
    var password = document.getElementById('login_password').value;
    if(password==""){
      document.getElementById('pspan').innerHTML='is empty';
    }
    else if(password.length > 0) {
      document.getElementById('pspan').innerHTML = '';
    }
}

  function onlogin(){
    var loginid=document.getElementById('login_id').value;
    var password=document.getElementById('login_password').value;
    if(loginid=='' && password==''){
          document.getElementById('lspan').innerHTML='Is empty';
          document.getElementById('pspan').innerHTML='Is empty';
          return false ;
      }
    else if(loginid=='' && password.length>=1){
          document.getElementById('lspan').innerHTML='Is empty';
            return false;
    }
    else if(password=='' && loginid.length>=1){ 
            document.getElementById('pspan').innerHTML='Is empty';
          return false;
      }
    else  {
          return true;
        }

  }



function submithide()
{
            $("#submitleave").hide();
}
var a;
var b;
function myhide()
  {
      a = document.getElementById("leaveperiod").value;                   
      if(a==0)
      {
          document.getElementById("msg1").innerHTML='plz fill this';
          $("#submitleave").hide();
      } 
      else
      {
          document.getElementById("msg1").innerHTML='';
          document.getElementById('description').value='';
      }
  }
function myfun()
 {
       a = document.getElementById("leaveperiod").value; 
       b = document.getElementById("leaveperiod1").value;    
        if(a==0)
       {
                   document.getElementById("msg1").innerHTML='plz fill this';
                  $("#submitleave").hide();
        } 
        if(b=='')
        {
          document.getElementById("msg2").innerHTML='plz fill this'; 
          $("#submitleave").hide();
         } 
         if(b)
        {
          document.getElementById("description").value=''; 
          $("#submitleave").show();
        }
        else
        {
          document.getElementById("description").value='invalid dates';
          document.getElementById("msg2").innerHTML='';
          $("#submitleave").hide();
        } 
                      
 }


 function remote_checkin() {
  var id = document.getElementById("change_shift_employee").value;
  if(id == "" ) {
    alert("choose employee from filteration ");
    return false;
  }
  var radios = document.getElementsByName("checkin");
  var radios2 = document.getElementsByName("time");
    var formValid = false;
    var i = 0,j = 1;k = 1;
    while (!formValid && i < radios.length) {
        if (radios[i].checked) {
          if(radios2[i].checked || radios2[j].checked) {
            formValid = true;
          }
        }
        i++;
        j--;        
    }

    if (!formValid) alert("Must check Action and Time option!");
    return formValid;
 }
 
function validate_change_shift() {
  var id = document.getElementById("filter_list_by_id").value;
  var name = document.getElementById("filter_list_by_name").value;
  if(id == "" && name == "") {
    alert("choose employee from filteration ");
    return false;
  }
  var shift = document.getElementById("shift").value;
  if( shift == "") {
    alert("choose shift please !");
    return false;
  }
  var date = document.getElementById("onedate").value;
  if(date == "") {
    alert("choose date please !");
    return false;
  }

}

function add_my_new_shift() {
  var shift_name = document.getElementById("add_new_shift_name").value;
  if(shift_name == "" ) {
    alert("please enter the name of new shift ");
    return false;
  }
  var radios = document.getElementsByName("in_time");
  var radios2 = document.getElementsByName("out_time");
    var formValid = false;
    var i = 0,j = 1;k = 1;
    while (!formValid && i < radios.length) {
        if (radios[i].checked) {
          if(radios2[i].checked || radios2[j].checked) {
            formValid = true;
          }
        }
        i++;
        j--;        
    }

    if (!formValid) alert("Must check Action and Time option!");
    return formValid;
 }

 function add_employee() {
 return true;
 }