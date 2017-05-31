    /**
* filtration for selecting previous month in filtration block above calendar view.
*/

function filteration_calendar_month() {
  var role = $('.validate_check_roles').html();
  if(role != 'employee')  {
    var id = document.getElementById('filter_by_choice_team').value;
    var val = document.getElementById('filtered_date_month').value;
    var py = document.getElementById('filtered_date_year').value;
    var pm;
    switch(val){
      case "January":pm = "01";break;
       case  "February":pm = "02";break;
       case "March":pm = "03";break;
       case "April":pm = "04";break;
       case "May":pm = "05";break;
       case  "June":pm = "06";break;
       case "July":pm = "07";break;
       case "August":pm = "08";break;
      case "September":pm="09";break;
      case "October":pm = "10";break;
       case "November":pm = "11";break;
      case "December":pm="12";break;
      default:var d = new Date(); 
        pm=d.getMonth()+1;
        if(pm<10){
          pm = '0'+pm;
        }
      break;
    }
  }
  else {
    var val = document.getElementById('filtered_date_month').value;
    var py = document.getElementById('filtered_date_year').value;
    var pm;
    switch(val){
      case "January":pm = "01";break;
       case  "February":pm = "02";break;
       case "March":pm = "03";break;
       case "April":pm = "04";break;
       case "May":pm = "05";break;
       case  "June":pm = "06";break;
       case "July":pm = "07";break;
       case "August":pm = "08";break;
      case "September":pm="09";break;
      case "October":pm = "10";break;
       case "November":pm = "11";break;
      case "December":pm="12";break;
      default:var d = new Date(); 
        pm=d.getMonth()+1;
        if(pm<10){
          pm = '0'+pm;
        }
      break;
    }
  }
  var xmlhttp;
  if(window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  }

  else {
    xmlhttp = new ActiveXObjct("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState===4 && xmlhttp.status==200) {
      document.getElementById("calendar-view").innerHTML=xmlhttp.responseText;
      if(role != 'employee') {
        $('.working_checks').css("display","none");
        $('.working_hrs').css("display","block");
      } else {
        $('.working_hrs').css("display","none");
        $('.working_checks').css("display","block");
      }
    }
  }
  if(role!='employee'){
    xmlhttp.open("POST","calendar_view_page.php?p-month="+pm+"&p-year="+py+"&emp_id="+id,true);
  }else {
    xmlhttp.open("POST","calendar_view_page.php?p-month="+pm+"&p-year="+py,true);
  }
  xmlhttp.send();
}
  function autoId(){
              
              var team = document.getElementById('team').value;
        
              var xmlhttp;
              if(window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
              }
              else {
                xmlhttp = new ActiveXObjct("Microsoft.XMLHTTP");
              }
        
            xmlhttp.onreadystatechange = function() {
             if(xmlhttp.readyState===4 && xmlhttp.status==200) {
                 document.getElementById("empid").value = xmlhttp.responseText;
               }
             }
           xmlhttp.open("POST","autoid_Ajax.php?team="+team,true);
           xmlhttp.send();
           
      }
function get_data_biomatric_csv(){
  var month = document.getElementById('choose_month_csv').value;
  alert(month);
   $.ajax({
      url: 'get_data_csv.php',
      method: "post",
      data: {'month':month},
      dataType:'text',
      success: function(result){
        document.getElementById("get_attendance_data").innerHTML=result;
      }
    });
}
/**
 * started here filteration block click event for reseting the current applied filteration..............................
*/

$('#fi_onedate').click(function() {
   document.getElementById('onedate').value='';
  $('#fi_onedate').removeClass('fa fa-times').addClass('hidden');
  $('#li_one_date_filter').removeClass('hidden').addClass('visible');
  filtration_checkin();
 });

$('#fi_fromdate').click(function() {
  document.getElementById('fromdate').value='';
   $('#li_from_date_filter').removeClass('hidden').addClass('visible');
  $('#fi_fromdate').removeClass('fa fa-times').addClass('hidden');
  filtration_checkin();
});

$('#fi_todate').click(function() {
  document.getElementById('todate').value='';
  $('#li_to_date_filter').removeClass('hidden').addClass('visible');
  $('#fi_todate').removeClass('fa fa-times').addClass('hidden');
  filtration_checkin();
 
});

// $('#fi_filter_by_choice_button').click(function() {
//   document.getElementById('filter_by_choice_team').value='';
//   $('#li_filter_by_choice_team').removeClass('hidden').addClass('visible');
//   $('#fi_filter_by_choice_button').removeClass('fa fa-times').addClass('hidden');
//   var d =location.href.split("/").slice(-1);
//   if(d =='viewsigninout.php'|| d=='viewsigninout.php#') {
//     filtration_checkin();
//   }
//   if(d == 'dashboard.php' || d =='dashboard.php#') {
//     filteration_calendar_month();
//   }
//   if(d =='modifyemployee.php' || d =='modifyemployee.php#') {
//     filteration_modify_employee();
//   }
//   if(d =='viewemployeedetails.php' || d=='viewemployeedetails.php#') {
//     filtration_view_employee_details();
//   }
//   if(d =='availableleaves.php' || d=='availableleaves.php#') {
//     filtration_leavehistory();
//   }
//    if(d =='monthlyshift.php' || d=='monthlyshift.php#') {
//     filtration_monthlyshift();
//   }
// });

/**
 * ./closed here filteration block click event for reseting the current applied filteration..............................
*/

function filtration_checkin() {
  var role = $('.validate_check_roles').html();
  if(role != 'employee')  {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    var onedate = document.getElementById('onedate').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  else {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    var onedate = document.getElementById('onedate').value;
  }
  var xmlhttp;
  if(window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  }
  else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      document.getElementById("tablecheckinout").innerHTML = xmlhttp.responseText;
    }
  }
  if(role != 'employee') {
      xmlhttp.open("POST","vciopage.php?one_date="+onedate+"&to_date="+str+"&from_date="+str1+"&choice_id="+choice_id,true);
    }
  else {
    xmlhttp.open("POST","vciopage.php?one_date="+onedate+"&to_date="+str+"&from_date="+str1,true);
  }
  xmlhttp.send();
}
/**
* filtration for the monthly shift on the basis of from date to To date...................... 
*/
function filtration_monthlyshift()
{
  var role = $('.validate_check_roles').html();
  if(role != 'employee')  {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    var onedate = document.getElementById('onedate').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  else {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    var onedate = document.getElementById('onedate').value;
  }
  var xmlhttp;
  if(window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  }
  else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      document.getElementById("tablemonthlyshift").innerHTML = xmlhttp.responseText;
    }
  }
  if(role != 'employee') {
      xmlhttp.open("POST","m_s_page.php?one_date="+onedate+"&to_date="+str+"&from_date="+str1+"&choice_id="+choice_id,true);
    }
  else {
    xmlhttp.open("POST","m_s_page.php?one_date="+onedate+"&to_date="+str+"&from_date="+str1,true);
  }
  xmlhttp.send();
}


// filtration for the available leaves on the basis of from date and to date filteration.............................
function filtration_leavehistory() {
  var role = $('.validate_check_roles').html();
  if(role != 'employee')  {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    var onedate = document.getElementById('onedate').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  else {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    var onedate = document.getElementById('onedate').value;
  }
  $.ajax({
      url: 'balance_leave_ajax.php',
      method: "post",
      data: {'choice_id':choice_id},
      dataType:'text',
      success: function(result){
        document.getElementById("balance_leave").innerHTML=result;
      }
  });
  var xmlhttp;
  if(window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  }
  else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if(xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("tableleavehistory").innerHTML = xmlhttp.responseText;
    }
  }
  if(role != 'employee') {
      xmlhttp.open("POST","a_l_page.php?one_date="+onedate+"&to_date="+str+"&from_date="+str1+"&choice_id="+choice_id,true);
    }
  else {
    xmlhttp.open("POST","a_l_page.php?one_date="+onedate+"&to_date="+str+"&from_date="+str1,true);
  }
  xmlhttp.send();
}




function filtration_notifications() {
  var role = $('.validate_check_roles').html();
  if(role == 'admin')  {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    document.getElementById('onedate').value = "";
    var id = document.getElementById('filter_list_by_id').value;
    var ids = document.getElementById('filter_list_by_manager_name').value;
    if(ids.length > 0) { 
      id = ids;
    }
    var name = document.getElementById('filter_list_by_name').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  else if(role == 'employee'){
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    document.getElementById('onedate').value = "";
  }
  else {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    document.getElementById('onedate').value = "";
    var id = document.getElementById('filter_list_by_id').value;
    var name = document.getElementById('filter_list_by_name').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  var xmlhttp;
  if(window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  }
  else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      document.getElementById("table_notifications").innerHTML = xmlhttp.responseText;
    }
  }
  if(role == 'admin') {
      xmlhttp.open("POST","notifications_ajax_call.php?to_date="+str+"&from_date="+str1+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);
    }
  else if(role == 'manager'){ 
      xmlhttp.open("POST","notifications_ajax_call.php?to_date="+str+"&from_date="+str1+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);  
    }
  else {
    xmlhttp.open("POST","notifications_ajax_call.php?to_date="+str+"&from_date="+str1,true);
  }
  xmlhttp.send();
}

function filtration_one_notifications()
{
 var role = $('.validate_check_roles').html();
  if(role == 'admin')  {
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
    var id = document.getElementById('filter_list_by_id').value;
    var name = document.getElementById('filter_list_by_name').value;
    var ids = document.getElementById('filter_list_by_manager_name').value;
    if(ids.length > 0) { 
      id = ids;
    }
    var choice_id = document.getElementById('filter_by_choice_team').value;
  
  }
  else if(role =='employee'){
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
  }
  else {
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
    var id = document.getElementById('filter_list_by_id').value;
    var name = document.getElementById('filter_list_by_name').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  
  var xmlhttp;
    if(window.XMLHttpRequest)
  {
    xmlhttp=new XMLHttpRequest();
  }
  else
  {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
    if(xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("table_notifications").innerHTML=xmlhttp.responseText;
    }
  }
  if(role == 'admin') {
     xmlhttp.open("POST","notifications_ajax_call.php?one_date="+odate+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);
    }
  else if(role == 'manager'){ 
      xmlhttp.open("POST","notifications_ajax_call.php?one_date="+odate+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);;  
    }
  else {
    xmlhttp.open("POST","notifications_ajax_call.php?one_date="+odate,true);
  }
  xmlhttp.send();
}



// filtration for the leave deatails .......................................................................
function filtration_leave_details() {
  $('#approved_leaves').click(function() {
    var onedate = document.getElementById('onedate').value;
    var fromdate = document.getElementById('fromdate').value;
    var todate = document.getElementById('todate').value;
    var emp_id = document.getElementById('filter_by_choice_team').value;
    $.ajax({
      url: 'leave_details_ajax_page.php',
      method: "post",
      data: {'approved-status':'approved','emp_id':emp_id,'onedate':onedate,'fromdate':fromdate,'todate':todate},
      dataType:'text',
      success: function(result){
        document.getElementById("table_leave_details").innerHTML=result;
      }
    });
  });
   $('#rejected_leaves').click(function() {
    var onedate = document.getElementById('onedate').value;
    var fromdate = document.getElementById('fromdate').value;
    var todate = document.getElementById('todate').value;
    var emp_id = document.getElementById('filter_by_choice_team').value;
    $.ajax({
      url: 'leave_details_ajax_page.php',
      method: "post",
      data: {'rejected-status':'rejected','emp_id':emp_id,'onedate':onedate,'fromdate':fromdate,'todate':todate},
      dataType:'text',
      success: function(result){
        document.getElementById("table_leave_details").innerHTML=result;
      }
    });
  });
}



/**
* filtration for the monthly shift on the basis of one date...................... 
*/
function filtration_one_monthlyshift() {
  var role = $('.validate_check_roles').html();
  if(role == 'admin')  {
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
    var id = document.getElementById('filter_list_by_id').value;
    var name = document.getElementById('filter_list_by_name').value;
    var ids = document.getElementById('filter_list_by_manager_name').value;
    if(ids.length > 0) { 
      id = ids;
    }
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  else if(role =='employee'){
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
  }
  else {
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
    var id = document.getElementById('filter_list_by_id').value;
    var name = document.getElementById('filter_list_by_name').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  var xmlhttp;
  if(window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  }
  else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if(xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("tablemonthlyshift").innerHTML=xmlhttp.responseText;
    }
  }
   if(role == 'admin') {
     xmlhttp.open("POST","m_s_page.php?one_date="+odate+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);
    }
  else if(role == 'manager'){ 
      xmlhttp.open("POST","m_s_page.php?one_date="+odate+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);;  
    }
  else {
    xmlhttp.open("POST","m_s_page.php?one_date="+odate,true);
  }
  xmlhttp.send();
}


function filtration_view_employee_details() {
  var id = document.getElementById('filter_by_choice_team').value;
  var xmlhttp;
    if(window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    }
    else {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
    if(xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("view_details").innerHTML = xmlhttp.responseText;
    }
  }
  xmlhttp.open("POST","view_employee_details_ajax_page.php?emp-id="+id,true);
  xmlhttp.send();
}

/**
* function is used for updating the monthly shift csv in the database 
*/

function load_monthly_csv() {
  $.ajax({
    url: 'monthly-csv.php',
    method: "post",
    data: {},
    dataType:'text',
    success: function(result){
      document.getElementById("update_csv").innerHTML=result;
    }
  });
}

/**
* below filtration  function for modify employee page
*/
function filteration_modify_employee() {
  var emp_id = document.getElementById('filter_by_choice_team').value;
  $.ajax({
    url: 'modify_employee_ajax.php',
    method: "post",
    data: {'emp_id':emp_id},
    dataType:'text',
    success: function(result){
      document.getElementById("modify_employee_div").innerHTML=result;
    }
  });
}


/**
 * filtration method for the report page calling onchagne by id and name select box...................//
*/
function filtration_report() {
  var role = $('.validate_check_roles').html();
  if(role == 'admin')  {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    document.getElementById('onedate').value = "";
    var id = document.getElementById('filter_list_by_id').value;
    var ids = document.getElementById('filter_list_by_manager_name').value;

    if(ids.length > 0) { 
      id = ids;
    }
    var name = document.getElementById('filter_list_by_name').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;

  }
  else if(role == 'employee'){
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    document.getElementById('onedate').value = "";
  }
  else {
    var str = document.getElementById('todate').value;
    var str1 = document.getElementById('fromdate').value;
    document.getElementById('onedate').value = "";
    var id = document.getElementById('filter_list_by_id').value;
    var name = document.getElementById('filter_list_by_name').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  var xmlhttp;
  if(window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  }
  else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      document.getElementById("tablecheckinout").innerHTML = xmlhttp.responseText;
    }
  }
  if(role == 'admin') {
      xmlhttp.open("POST","report_ajax_call_page.php?to_date="+str+"&from_date="+str1+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);
  }
  else if(role == 'manager'){ 
      xmlhttp.open("POST","report_ajax_call_page.php?to_date="+str+"&from_date="+str1+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);  
  }
  else {
    xmlhttp.open("POST","report_ajax_call_page.php?to_date="+str+"&from_date="+str1,true);
  }
  xmlhttp.send();
}

/**
 * filtration method for the report page calling onchagne by id and name select box...................//
*/
function filtration_one_report()
{
 var role = $('.validate_check_roles').html();
  if(role == 'admin')  {
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
    var id = document.getElementById('filter_list_by_id').value;
    var name = document.getElementById('filter_list_by_name').value;
    var ids = document.getElementById('filter_list_by_manager_name').value;
    if(ids.length > 0) { 
      id = ids;
    }
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  else if(role =='employee'){
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
  }
  else {
    var odate=document.getElementById('onedate').value;
    document.getElementById('todate').value="";
    document.getElementById('fromdate').value="";
    var id = document.getElementById('filter_list_by_id').value;
    var name = document.getElementById('filter_list_by_name').value;
    var choice_id = document.getElementById('filter_by_choice_team').value;
  }
  var xmlhttp;
    if(window.XMLHttpRequest)
  {
    xmlhttp=new XMLHttpRequest();
  }
  else
  {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
    if(xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("tablecheckinout").innerHTML=xmlhttp.responseText;
    }
  }
   if(role == 'admin') {
     xmlhttp.open("POST","report_ajax_call_page.php?one_date="+odate+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);
    }
  else if(role == 'manager'){ 
      xmlhttp.open("POST","report_ajax_call_page.php?one_date="+odate+"&emp-id="+id+"&emp-name="+name+"&choice-id="+choice_id,true);;  
    }
  else {
    xmlhttp.open("POST","report_ajax_call_page.php?one_date="+odate,true);
  }
  xmlhttp.send();
}

/* filteration by search by id and search by name at navigation bar*/
$('#id_filter').click(function () {
  $.ajax({
    url:'id_filter_ajax_call.php',
    method:'post',
    data:{},
    dataType:'text',
    success:function(output) {
      document.getElementById('filter_by_choice_team').innerHTML =output;
    }
  });
});
$('#name_filter').click(function () {
   $.ajax({
    url:'name_filter_ajax_call.php',
    method:'post',
    data:{},
    dataType:'text',
    success:function(output) {
      document.getElementById('filter_by_choice_team').innerHTML =output;
    }
  });
});
/**
  * below code is used for the filteration on the basis of filter by team button on the filteration block
*/

// $("#filter_by_team").change(function() {
//  var value = document.getElementById('filter_by_team').value;
//  $('#li_filter_by_choice_team').removeClass('hidden').addClass('visible');
//  var xmlhttp;
//   if(window.XMLHttpRequest) {
//     xmlhttp = new XMLHttpRequest();
//   }
//   else {
//     xmlhttp = new ActiveXObjct("Microsoft.XMLHTTP");
//   }

//   xmlhttp.onreadystatechange = function() {
//     if(xmlhttp.readyState===4 && xmlhttp.status==200) {
//       document.getElementById("filter_by_choice_team").innerHTML=xmlhttp.responseText;
//     }
//   }
//   xmlhttp.open("POST","fiteration_choice_team_ajax_call.php?choice="+value,true);

//   xmlhttp.send();
//  });


// *
//   * below code is used for the filteration on the basis of filter by shift button on the filteration block

// $("#filter_by_shift").change(function () {
//     var role = $('.validate_check_roles').html();
//     var value = document.getElementById('filter_by_shift').value;
//     $('#li_filter_by_choice_team').removeClass('hidden').addClass('visible');
//     $.ajax({
//         url: 'fiteration_choice_team_ajax_call.php',
//         method:'post',
//         data: {'choice-shift':value},
//         dataType:'text',
//         success:function(output) {
//           document.getElementById("filter_by_choice_team").innerHTML = output;
//         }
//     });
// });
  // if(role == 'admin') {
  //   var value2 = document.getElementById('filter_by_team').value;
  //   my_choice_team(value,value2);  
  // }
  // else {
  //  my_choice_shift(value);   
  // }
  

// function my_choice_team(shift,team) {
//   $.ajax({
//       url: 'fiteration_choice_team_ajax_call.php',
//       method:'post',
//       data: {'choice-shift':shift,'choice':team},
//       dataType:'text',
//       success:function(output) {
//         document.getElementById("filter_by_choice_team").innerHTML = output;
//       }
//   });
// }
// function my_choice_shift(shift) {
//   $.ajax({
//       url: 'fiteration_choice_team_ajax_call.php',
//       method:'post',
//       data: {'choice-shift':shift},
//       dataType:'text',
//       success:function(output) {
//         document.getElementById("filter_by_choice_team").innerHTML = output;
//       }
//   });
// }



// $("#filter_list_by_id").change(function () {
//     var value = document.getElementById("filter_list_by_id").value;
//     $.ajax({
//       url: 'filteration_choice_by_manager_name.php',
//       method:'post',
//       data:{'value':value},
//       dataType:'text',
//       success:function(output) {
//         document.getElementById("filter_list_by_manager_name").innerHTML = output;
//       }
//     });
//     $.ajax({
//       url:'change_shift_ajax_call.php',
//       method:'post',
//       data:{'value':value},
//       dataType:'text',
//       success:function(result){
//         document.getElementById("change_shift_employee").value = result;
//       }
//     });
// });

// $('#filter_list_by_name').change(function(){
//   var value = document.getElementById('filter_list_by_name').value;
//   $.ajax({
//       url: 'filteration_choice_by_manager_name.php',
//       method:'post',
//       data:{'value':value},
//       dataType:'text',
//       success:function(output) {
//         document.getElementById("filter_list_by_manager_name").innerHTML = output;
//       }
//     });
//   $.ajax({
//       url:'change_shift_ajax_call.php',
//       method:'post',
//       data:{'value':value},
//       dataType:'text',
//       success:function(result){
//         document.getElementById("change_shift_employee").value = result;
//       }
//     });
// });

// $('#filter_by_choice_team').change(function (){
//   var value = document.getElementById('filter_by_choice_team').value;
//   $.ajax({
//       url:'change_shift_ajax_call.php',
//       method:'post',
//       data:{'value':value},
//       dataType:'text',
//       success:function(result){
//         document.getElementById("change_shift_employee").value = result;
//       }
//     });
// });

// $('#filter_list_by_manager_name').change(function (){
//   var value = document.getElementById('filter_list_by_manager_name').value;
//   $.ajax({
//       url:'change_shift_ajax_call.php',
//       method:'post',
//       data:{'value':value},
//       dataType:'text',
//       success:function(result){
//         document.getElementById("change_shift_employee").value = result;
//       }
//     });
// });

// function filter_manager(){
//   var role = document.getElementById('filter_button_manager').value;
//   $('#li_filter_by_choice_team').removeClass('hidden').addClass('visible');
//   $('#li_filter_by_team').removeClass('visible').addClass('hidden');
//   $('#li_filter_by_shift').removeClass('visible').addClass('hidden');
//   $.ajax({
//     url: 'emp_manager_ajax_call.php',
//     method: "post",
//     data: {'user_role':role},
//     dataType:'text',
//     success: function(result){
//       document.getElementById("filter_by_choice_team").innerHTML=result;
//     }
//   });
//   $.ajax({
//       url: 'emp_name_ajax_call.php',
//       method:"post",
//       data:{'user_role':role},
//       dataType:'text',
//       success: function(result) {
//       document.getElementById("filter_list_by_name").innerHTML=result;
//       }
//   });
// }

// function filter_employee(){
//   var role = document.getElementById('filter_button_employee').value;
//   $('#li_filter_by_choice_team').removeClass('hidden').addClass('visible');
//   $('#li_filter_by_team').removeClass('visible').addClass('hidden');
//   $('#li_filter_by_shift').removeClass('visible').addClass('hidden');
//   $.ajax({
//     url: 'emp_manager_ajax_call.php',
//     method: "post",
//     data: {'user_role':role},
//     dataType:'text',
//     success: function(result){
//       document.getElementById("filter_by_choice_team").innerHTML=result;
//     }
//   });
//   $.ajax({
//       url: 'emp_name_ajax_call.php',
//       method:"post",
//       data:{'user_role':role},
//       dataType:'text',
//       success: function(result) {
//       document.getElementById("filter_list_by_name").innerHTML=result;
//       }
//   });
// }

