<?php

  include('checksession.php');
  include('connection.php');
  $role = $_SESSION['role'];
  $user = $_SESSION['user'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $biomatric_id = $_SESSION['biomatric_id'];
  date_default_timezone_set('Asia/Kolkata');  

?>  
<!DOCTYPE html>
<html>
<head>
	<!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- own css is imported here-->
    <link href="custom-css/sheet.css" rel="stylesheet">

    <link href="custom-css/datepicker.css" rel="stylesheet">

    <link href="custom-css/timeline.css" rel="stylesheet">

    <link href="Timepicki/css/timepicki.css" rel="stylesheet">

   <link rel="stylesheet" href="custom-css/popup.css">

 


    

</head>
<!-- Body Starts Here -->
<body>
<!-- add team popup form block is started here -->
<div id="add_team_popup">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <button class="close" onclick="div_add_team_hide();">x</button>
            <h3>Add Team</h3>
          </div>
          <div class="panel-body">
            <form role="form"  method='post' name="add_team_form" enctype="multipart/form-data">
              <div class="form-group ">
                <label class="control-label">
                 Team Name 
                </label> <small class="pull-right">Enter only name of team e.g. abc</small>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-rocket"></span> 
                  </div>
                  <input class="form-control" id="add_team_name"  name="add_team_name" required="required">
                </div>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="add_team_submit"  value="Add" id="add_team_submit"  
                  class="btn btn-lg btn-success btn-block"/>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- add team div is closed here -->
<!-- leave request popup form block is started here -->
<div id="leave_request">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <button class="close" onclick="div_leave_request_hide();">x</button>
            <h3>Leave Request</h3>
          </div>
          <div class="panel-body">
            <form role="form"  method='post' name="leave_request_form" enctype="multipart/form-data">
              <div class="form-group ">
                <label class="control-label " for="email">
                 Employee Id
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-user"></span> 
                  </div>
                  <input class="form-control" id="leave_request_empid" value=<?php echo" '$user'"; ?> name="leave_request_empid" required="required">
                  
                </div>
              </div>
              <div class="form-group ">
                <label class="control-label " for="email">
                 Employee Name
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-user"></span> 
                  </div>
                  <input class="form-control" id="leave_request_employeename" value=<?php echo" '$firstname $lastname'"; ?> name="leave_request_employeename" required="required">
                  
                </div>
              </div>
              <div class="form-group ">
                <label class="control-label " for="email">
                 Leave type
                </label>
                <div class="input-group">
                   <div class="input-group-addon">
                    <span class="fa fa-user"></span> 
                  </div>
                  <select class="form-control myselect" name="leave_request_leavetype" id="leave_request_leavetype" required="required" style="width:100%;">
                      <option value="sickleave">Sick Leave</option><option value="causalleave">Causal Leave</option>
                      <option value="earnedleave">Earned Leave</option>
                      <option value="cofl">Cofl Leave</option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label " for="email">
                 Leave Period
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-user"></span> 
                  </div>
                  <input class="form-control example1" placeholder="enter start date of leave"  name="fromperiod" id="leaveperiod" onchange="myhide();" required="required"><span id="msg1"></span>
                  <input type="text" placeholder="enter end date of leave" class="form-control example1" name="toperiod" id="leaveperiod1"
                      onchange="myfun();" required="required"><span id="msg2"></span>
                    <!-- date picker is used for from period with leaveperiod1 id -->       
                </div>
                <span id="msg3" ></span>
              </div>
              <div class="form-group">
                <label class="control-label " for="email">
                 Description
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-lock"></span> 
                  </div>
                  <input class="form-control"  id="description" name="description" required="required"><span id="msg3"></span><!-- date picker is used for from period with leaveperiod1 id -->       
                </div>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="submitleave"  value="Request" id="submitleave"  
                  class="btn btn-lg btn-success btn-block" onclick="check()"/>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /change password popup block is closed here -->
<!-- change password block is started here -->
<div id="change_password">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <button class="close" onclick="div_hide();">x</button>
            <h3>Change Password</h3>
          </div>
          <div class="panel-body">
            <form role="form"  method='post' name="loginform" onsubmit="return(validate())"  enctype="multipart/form-data">
              <div class="form-group ">
                <label class="control-label " for="email">
                 Employee Id
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-user"></span> 
                  </div>
                  <input class="form-control" id="change_empid" value=<?php echo" '$user'"; ?> name="change_empid" readonly/>
                  
                </div>
              </div>
              <div class="form-group ">
                <label class="control-label " for="email">
                 Current Password
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-lock"></span> 
                  </div>
                  <input class="form-control"  type="password" id="currentpassword" name="currentpassword" onblur="cp1();"/>
                  
                </div>
                <span id="msg1"></span>
              </div>
              <div class="form-group ">
                <label class="control-label " for="email">
                 New Password
                </label>
                <div class="input-group">
                   <div class="input-group-addon">
                    <span class="glyphicon glyphicon-lock"></span> 
                  </div>
                  <input class="form-control"  type="password" id="newpassword" name="newpassword"/>
                 
                </div>
                <span id="msg2"></span>
              </div>
              <div class="form-group ">
                <label class="control-label " for="email">
                 Confirm Password
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-lock"></span> 
                  </div>
                  <input class="form-control"  type="password" id="confirmpassword" name="confirmpassword" onchange="cp3();"/>
                  
                </div>
                <span id="msg3" ></span>
              </div>
              
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="submitpassword"  value="Change" id="submitpassword"  
                  class="btn btn-lg btn-success btn-block" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /change password popup block is closed here -->
<!-- remote checkin popup block is started here -->
<div id="remote_checkin">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <button class="close" onclick="div_hide_remote_checkin();">x</button>
            <h3>Remote Checkin</h3>
          </div>
          <div class="panel-body">
            <form role="form"  method='post' name="remote_form" enctype="multipart/form-data">
              <div class="form-group ">
                <label class="control-label " for="email">
                 Select the Employee Id
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-user"></span>
                </div>
                 <select class="form-control myselect" name="remote_checkin_select" style="width:100%;">
                  <option value="<?php echo $user;?>"><?php echo $user;?></option>
                  <?php 
                    $query = mysqli_query($con,"select empid from emp_table where reportedmanagerid='".$user."'");
                    while($result = mysqli_fetch_array($query)) {
                      $employee_id = $result['empid'];
                      echo '<option value='.$employee_id.'>'.$employee_id.'</option>';
                    }
                  ?>
                </select>
                
                </div>
                </div>
                <div class="form-group">
                <label class="control-label " for="email">
                 Select Date
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-calendar" aria-hidden="true"></span> 
                  </div>
                  <input class="form-control example1"  name="remote_date" id="remote_date"  required="required">
                    <!-- date picker is used for from period with leaveperiod1 id -->       
                </div>
                <span id="msg3" ></span>
              </div>
              <div class="form-group">
                    <label>Select Action</label>
                      <div class="radio">
                        <label>
                          <input type="radio" name="checkin" id="check-in" value="check_in" checked>Check In
                        </label>
                        <label>
                          <input type="radio" name="checkin" value="check_out">Check Out
                        </label>
                        <label>
                          <input type="radio" name="checkin" value="NA">NA
                        </label>
                        <label>
                          <input type="radio" name="checkin" value="WO">Weekly Off 
                        </label>
                       
                        <label>
                          <input type="radio" name="checkin" value="Holiday">Holiday
                        </label>
                        <label>
                          <input type="radio" name="checkin" value="Leave">Leave
                        </label>
                        <label>
                          <input type="radio" name="checkin" value="Half Day">Half Day
                        </label>
                      </div>
                  </div>
                  <div class="form-group">
                    <label>Select Time</label>
                      <div class="radio">
                        <label>
                          <input type="radio" id="current-time" name="time" value="">Current Time
                        </label>
                      
                        <label>
                          <input type="radio" name="time" value="" id="custom-time">Custom Time
                        </label>
                        <div class="inner cover indexpicker"> <input id="timepicker1" type="text" name="timepicker1" value="" /> </div>
                      </div>
                  </div>
                            
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="submit_remote_checkin" id="submit_remote_checkin" value="Check In"  
                  class="btn btn-lg btn-success btn-block" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /remote checkin Popup block is closed here -->
<!-- add shift  popup block is started here -->
<div id="add_shift_popup">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <button class="close" onclick="div_hide_add_new_shift();">x</button>
            <h3>Add New Shift</h3>
          </div>
          <div class="panel-body">
            <form role="form"  method='post' name="add_shift_form" enctype="multipart/form-data">
              <div class="form-group ">
                <label class="control-label " for="email">
                 Shift Name:
                </label>
                <div class="input-group">
                  <input class="form-control" type ="text" name="new_shift_name" id="add_new_shift_name" placeholder="enter the name of new shift">
                  <div class="input-group-addon">
                    <span class="fa fa-user"></span> 
                  </div>
                </div>
              </div>
              <div class="form-group">
                    <label>Shift In Time</label>
                      <div class="radio">
                        <label>
                          <input type="radio" id="in-current-time" name="in_time" value="" checked>Current Time
                        </label>
                     
                        <label>
                          <input type="radio" name="in_time" value="" id="in-custom-time">Custom Time
                        </label>
                        <div class="inner cover indexpicker"> <input id="timepicker2" type="text" name="timepicker2" value="" /> </div>
                      </div>
                  </div>
              <div class="form-group">
                    <label>Shift Out Time</label>
                      <div class="radio">
                        <label>
                          <input type="radio" id="out-current-time" name="out_time" value="" checked>Current Time
                        </label>
                      
                        <label>
                          <input type="radio"  name="out_time" value="" id="out-custom-time">Custom Time
                        </label>
                        <div class="inner cover indexpicker"> <input id="timepicker3" type="text" name="timepicker3" value="" style="display:none;"/> </div>
                      </div>
                  </div>
                            
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="add_new_shift" id="new_shift" value="Add shift"  
                  class="btn btn-lg btn-success btn-block" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /add shift Popup block is closed here -->

<!-- change shift  popup block is started here -->
<div id="change_shift_popup">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <button class="close" onclick="div_hide_change_shift();">x</button>
            <h3>Modify Shift</h3>
          </div>
          <div class="panel-body">
            <form role="form"  method='post' name="change_shift_form" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="control-label">Select Shift</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="fa fa-user"></span>
                    </div>
                    <select class="form-control myselect" name="change_shift" style="width:100%;">
                      <?php 
                        $query = mysqli_query($con,"select shift_name from shift_table");
                        while($result = mysqli_fetch_array($query)) {
                          $shift_name = $result['shift_name'];
                          echo '<option value='.$shift_name.'>'.$shift_name.'</option>';
                        }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                    <label>Shift In Time</label>
                      <div class="radio">
                        <label>
                          <input type="radio" id="change-shift-in-current-time" name="change_in_time" value="" checked>Current Time
                        </label>
                     
                        <label>
                          <input type="radio" name="change_in_time" value="" id="change-in-custom-time">Custom Time
                        </label>
                        <div class="inner cover indexpicker"> <input id="timepicker5" type="text" name="timepicker5" value="" /> </div>
                      </div>
                  </div>
              <div class="form-group">
                    <label>Shift Out Time</label>
                      <div class="radio">
                        <label>
                          <input type="radio" id="change-out-current-time" name="change_out_time" value="" checked>Current Time
                        </label>
                      
                        <label>
                          <input type="radio"  name="change_out_time" value="" id="change-out-custom-time">Custom Time
                        </label>
                        <div class="inner cover indexpicker"> <input id="timepicker6" type="text" name="timepicker6" value="" style="display:none;"/> </div>
                      </div>
                  </div>
                            
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="submit_modify_shift" id="submit_modify_shift" value="submit"  
                  class="btn btn-lg btn-success btn-block" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /change shift Popup block is closed here -->
<!-- change shift  popup block is started here -->
  
<div id="edit_attendance_popup">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <button class="close" onclick="div_edit_attendance_hide();">x</button>
            <h3>Edit Attendance </h3>
            <div id="edit_view_id"></div>
          </div>
          <div class="panel-body">
            <form  id="edit_attendance_form" name="edit_attendance_form">
              <div class="form-group ">
                <input class="form-control" type ="hidden" name="edit_attendance_id" id="edit_attendance_id">
              </div>
              <div class="form-group ">
                <label class="control-label " for="email">
                 Employee Biomatric Id
                </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-user"></span> 
                  </div>
                  <input class="form-control" id="edit_empid" name="edit_empid" readonly/>
                  
                </div>
              </div>

              <div class="form-group">
                    <label>Select Action</label>
                      <div class="radio">
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" id="edit_check_in" value="check_in" checked>Check In
                        </label>
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="check_out">Check Out
                        </label>
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="NA">NA
                        </label>
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="WO">Weekly Off 
                        </label>
                        </div>
                      <div class="radio">
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="MO">Monthly Off 
                        </label>
                      
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="Holiday">Holiday
                        </label>
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="Leave">Leave
                        </label>
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="Half Day">Half Day
                        </label>
                        </div>
                      <div class="radio">
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="Present">Present
                        </label>
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="Remarks">Only Remarks
                        </label>
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="Absent">Absent
                        </label>
                        <label class="edit_action">
                          <input type="radio" name="edit_checkin" value="Comp Off">Comp Off
                        </label>

                      </div>
                  </div>
                  <div class="form-group">
                    <label>Select Time</label>
                      <div class="radio">
                        <label>
                          <input type="radio" id="edit_current-time" name="edit_time" value="" >Current Time
                        </label>
                      
                        <label>
                          <input type="radio" name="edit_time" value="" id="edit_custom-time">Custom Time
                        </label>
                        <div class="inner cover indexpicker"> <input id="timepicker4" type="text" name="edit_timepicker4" value="" style="display:none;"/> </div>
                      </div>
                  </div>
                  <div class="form-group ">
                    <label class="control-label" for="email">
                      Remarks:
                    </label>
                    <input class="form-control" name="edit_remarks" id="edit_remarks" style="width:100%;">
                    
                  </div> 
            </form>
            <button name="edit_submit_remote_checkin" id="edit_submit_remote_checkin"   
                  class="btn btn-lg btn-success btn-block" onclick="div_edit_attendance_hide();"/>Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- /change shift Popup block is closed here -->
<script src="../vendor/jquery/jquery.min.js"></script>
  <script src="custom-js/popup.js"></script>
  
<script type="text/javascript" src="custom-js/filtration_method.js"></script>

<script src="custom-js/filteration-button.js"></script>

<script src="custom-js/bootstrap-datepicker.js"></script>
 

  <script src="Timepicki/js/timepicki.js"></script>
   <script type="text/javascript">
    // When the document is ready
    $(document).ready(function (){$(".example1").datepicker({format: "yyyy-mm-dd"});                          
    });</script>
  <script>
    // add new shift popup setting
    $('#timepicker2').timepicki();
    $('#in-current-time').click(function(){
      $('#timepicker2').hide();
    });
    $('#in-custom-time').click(function(){
      $('#timepicker2').show();
    });
    $('#timepicker3').timepicki();
    $('#out-current-time').click(function(){
      $('#timepicker3').hide();
    });
    $('#out-custom-time').click(function(){
      $('#timepicker3').show();
    });
    // change shift popup setting
    $('#timepicker5').timepicki();
    $('#change-shift-in-current-time').click(function(){
      $('#timepicker5').hide();
    });
    $('#change-in-custom-time').click(function(){
      $('#timepicker5').show();
    });
    $('#timepicker6').timepicki();
    $('#change-out-current-time').click(function(){
      $('#timepicker6').hide();
    });
    $('#change-out-custom-time').click(function(){
      $('#timepicker6').show();
    });
    
    // remote checkin popup setting
    $('#timepicker1').timepicki();
    $('#custom-time').click(function() {
      $('#timepicker1').show();
    });
    $('#current-time').click(function() {
      $('#timepicker1').hide();
    });
    // edit remote checkin popup setting
    $('#timepicker4').timepicki();
    $('#edit_custom-time').click(function() {
      $('#timepicker4').show();
    });
    $('#edit_current-time').click(function() {
      $('#timepicker4').hide();
    });
    // change shift popup setting 
  </script>

  <script type="text/javascript">
  //Function To Display Popup
  function div_show() {
    document.getElementById('change_password').style.display = "block";
  }
  //Function to Hide Popup
  function div_hide(){
  document.getElementById('change_password').style.display = "none";
  }
  function div_show_remote_checkin() {
  document.getElementById('remote_checkin').style.display = "block";
  }
  //Function to Hide Popup
  function div_hide_remote_checkin(){
  document.getElementById('remote_checkin').style.display = "none";
  }
  function div_show_add_new_shift(){
    document.getElementById('add_shift_popup').style.display="block";
  }
  function div_hide_add_new_shift(){
    document.getElementById('add_shift_popup').style.display="none";
  }
  function div_show_change_shift(){
    document.getElementById('change_shift_popup').style.display="block";
  }
  function div_hide_change_shift(){
    document.getElementById('change_shift_popup').style.display="none";
  }
  function div_leave_request_hide() {
    document.getElementById('leave_request').style.display='none';
  }
  function div_leave_request_show(){
    document.getElementById('leave_request').style.display='block';
  }
  function div_add_team_show(){
    document.getElementById('add_team_popup').style.display='block';
  }
  function div_add_team_hide(){
    document.getElementById('add_team_popup').style.display='none';
  }
  function div_edit_attendance_show(id,b_id){
    document.getElementById('edit_attendance_popup').style.display='block';
    document.getElementById('edit_attendance_id').value=id;
    document.getElementById('edit_empid').value=b_id;
  }
   function div_edit_attendance_hide(){
    document.getElementById('edit_attendance_popup').style.display='none';
  }

   $(document).ready(function(){
      $('#edit_submit_remote_checkin').click(function() {
        var id = document.getElementById('edit_attendance_id').value;
        var emp_id = document.getElementById('edit_empid').value;
        var actions = document.getElementsByName('edit_checkin');
        var action_value;
        for(var i = 0; i < actions.length; i++){
          if(actions[i].checked){
            action_value = actions[i].value;
          }
        }
        var time = document.getElementById('timepicker4').value;
        var remarks = document.getElementById('edit_remarks').value;
        $.ajax({
               type:"post",
               url:"edit_attendance_submit_ajax.php",
               data: {'emp_id':emp_id,'edit_attendance_id':id,'edit_checkin':action_value,'edit_time':time,'edit_remarks':remarks},
                dataType:'text',
               success: function(response){
                   $("."+id).html(response);
               }
         });
      });
   });
</script>

</body>
<!-- Body Ends Here -->
</html>

<?php
if(isset($_POST['add_team_submit'])){
 // connection file is included for database connection......
  include('connection.php');
  $team_name = strtolower($_POST['add_team_name']);
   $query3 = mysqli_query($con,"INSERT INTO `team_table` (`team_name`) values ('".$team_name."')");
      if($query3) {
        echo"<script type='text/javascript'>
        mscAlert({title: 'Done',subtitle: 'Your ".$team_name." team is successfully added.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
      }
      else {
        echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Failed to add the new team.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
      }
}

/* add team submit is closed here.....................................*/
if(isset($_POST['submitleave'])){
 // connection file is included for database connection......
  include('connection.php');
// selected date are stored in variable d1 and d2. d1 for from period and d2 for to period.....        
  $d1 = $_POST['fromperiod'];
  $d2 = $_POST['toperiod'];
  $d10 = $_POST['description'];
  // function is used to subtract  values of date picker.....
  if($d1==0){
    echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Please fill up the start date of leave.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
  }
else
{
    $date1 = new DateTime($d1);
    $date2 = new DateTime($d2);
    $d3=$date2->diff($date1)->format("%a");
    $d3++;
    //echo $d3;
    // query is used to fetch the employee leave from emp_table..... 
  $query1=mysqli_query($con,"select ".$_POST['leave_request_leavetype'].",reportedmanagerid from emp_table where empid='".$_POST['leave_request_empid']."'");
    while($row=mysqli_fetch_array($query1)){
    $l=$row[0];
    $reportmanagerid = $row[1];
  }
// here we subtract the requested leave from available leaves of user.....  
if($l>0) {
  $d = $l-$d3;  
  // if the requested leaves are greater than the balance leaves....  
    if($d<0) {
      echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'You request more leaves as compare to balanced ".$_POST['leave_request_leavetype'].".',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";   
    } 
// if requested leaves are less than balance leaves then submission is succesfull.....      
  else {       
   
// this query3 is used to submit the leave request into the leave_request_table.......

      $query3 = mysqli_query($con,"INSERT INTO `leave_request_table` (`req_id`, `empid`, `empname`, `leavetype`, `date`, `fromdate`, `todate`, `description`, `submit_to`) values ('' ,'".$_POST['leave_request_empid']."','".$_POST['leave_request_employeename']."','".$_POST['leave_request_leavetype']."','".date('y-m-d')."','".$_POST['fromperiod']."','".$_POST['toperiod']."','".$_POST['description']."','".$reportmanagerid."')");
      if($query3) {
        echo"<script type='text/javascript'>
        mscAlert({title: 'Done',subtitle: 'Your leave successfully requested.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
      }
      else {
        echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Failed to request the leave.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
      }
    }
  }
  else
  {
    echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'You not have ".$_POST['leave_request_leavetype']." balanced leaves',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
  }
}
}
  if(isset($_POST['submitpassword'])) {
  include('connection.php');
  $v1 = $_POST['change_empid'];
  $v2 = $_POST['currentpassword'];
  $v3 = $_POST['newpassword'];
  $v4 = $_POST['confirmpassword'];
  $new_password =base64_encode($v4);
  if($v2 =='') {
     echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Please fill up the Current Password.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
  }
  else if($v3=='') {
   echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Please fill up the New Password.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
  }
  else if($v4=='') {
  echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Please fill up the Confirm Password.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
  } 
  else { 
    $query2 = mysqli_query($con," UPDATE emp_table SET password='".$new_password."' where empid='".$v1."'");
    if($query2) { 
      echo"<script type='text/javascript'>
        mscConfirm({ title: 'Password is Changed',
        subtitle: 'Please Logout for verify the password.',  // default: ''
        okText: 'I Agree',    // default: OK
        cancelText: 'I Dont', // default: Cancel,
        dismissOverlay: true, // default: false, closes dialog box when clicked on overlay.
        onOk: function() {
          mscAlert('Awesome.');
          location.href = 'logout.php';
        },
        onCancel: function() {
          mscAlert('Sad face :( .');
        }
      });
      </script>";
        $pass1 = $v4;
    }
    else {
      echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Fialed to Change the Password.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
    }
  }
}
// php block for modify the shift 
if(isset($_POST['submit_modify_shift'])) {
    $shift = $_POST['change_shift'];
    $in_time = $_POST['timepicker5'];
    $in_time = date("H:i", strtotime($in_time));
    if($in_time == "") {
        $in_time = date('H:i A ');
      }
     $out_time = $_POST['timepicker6'];
     $out_time = date("H:i", strtotime($out_time));
      if($out_time == "") {
        $out_time = date('H:i A ');
      } 
      $query = mysqli_query($con,"UPDATE shift_table set `start_time` = ".$in_time." , `end_time` =".$out_time." where ".$shift." =".$shift."");
    if($query) {
      echo"<script type='text/javascript'>
          mscAlert({title: 'Done',subtitle: '".$shift." is successfully modified.',  // default: ''
          okText: 'Close',    // default: OK
          });</script>";
    }
    else {
      echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'failed ".$shift." to modified .',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
    }
  }

  // php block for add new shift popup
  if(isset($_POST['add_new_shift'])) {
    include('connection.php');
    $shift_name = $_POST['new_shift_name'];
    $in_time = $_POST['timepicker2'];
    $in_time = date("H:i", strtotime($in_time));
    if($in_time == "") {
        $in_time = date('H:i A ');
      }
     $out_time = $_POST['timepicker3'];
     $out_time = date("H:i", strtotime($out_time));
      if($out_time == "") {
        $out_time = date('H:i A ');
      } 
    $query = mysqli_query($con,"INSERT INTO shift_table (shift_name,start_time,end_time) VALUES ('".$shift_name."','".$in_time."','".$out_time."')");
    if($query) {
      echo"<script type='text/javascript'>
          mscAlert({title: 'Done',subtitle: 'A new shift is successfully added.',  // default: ''
          okText: 'Close',    // default: OK
          });</script>";
    }  
  }

// php block for remote checkin popup
if(isset($_POST['submit_remote_checkin'])) {
    include('connection.php');
    $user_one = $_POST['remote_checkin_select'];
    $remote_date = $_POST['remote_date'];
    $action = $_POST['checkin'];
    $time = $_POST['timepicker1'];
    if($time == "") {
      $time = date('g:i A ');
    }
    $date = date("d")."-".date("m")."-".date("Y");

    if($action == "check_in") {
      $query_fetch=mysqli_query($con,"SELECT * from emp_checks where emp_id='".$user_one."' and date='".$remote_date."'");
      $count = mysqli_num_rows($query_fetch);
      if($count){
           $query = mysqli_query($con,"UPDATE emp_checks SET check_in = '".$time."' , status = '1',checks='P',particulars='' WHERE emp_id = '".$user_one."' AND date = '".$remote_date."'");
      }
      else{
        $query = mysqli_query($con,"INSERT into emp_checks(emp_id,date,check_in,check_out,working_hrs,checks,particulars,remarks) VALUES('".$user_one."','".$remote_date."','".$time."','','','P','','')");
      }
      if($query) {
            echo"<script type='text/javascript'>
          mscAlert({title: 'Done',subtitle: 'CHECK IN is updated.',  // default: ''
          okText: 'Close',    // default: OK
          });</script>";
          }
          else {
            echo"<script type='text/javascript'>
          mscAlert({title: 'Sorry',subtitle: 'Failed to check in.',  // default: ''
          okText: 'Close',    // default: OK
          });</script>";
          }
      
        }
        elseif($action == "check_out") {
           $query2 = mysqli_query($con,"UPDATE emp_checks SET check_out = '".$time."' , status = '0' WHERE emp_id = '".$user_one."' and date='".$remote_date."'");
           $query1 = mysqli_query($con,"SELECT check_in,check_out,remarks from emp_checks WHERE emp_id = '".$user_one."' and date='".$remote_date."'");
            while($row = mysqli_fetch_array($query1)) {
              $checkTime = strtotime($row[0]);
              $checkout = strtotime($row[1]);
              $diff = $checkTime - $checkout;
              $init = abs($diff);
              $hours = floor($init / 3600);
              $minutes = floor(($init / 60) % 60);
              $seconds = $init % 60;
              $d = $hours.':'.$minutes.':'.$seconds;
              $remarks = $row[2];
              $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."' WHERE emp_id = '".$user_one."' and date='".$remote_date."'");
            }
            if($query) {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Done',subtitle: 'CHECK OUT is updated.',  // default: ''
                okText: 'Close',    // default: OK
                });</script>";
              }
              else {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Sorry',subtitle: 'Failed to modify check out.',  // default: ''
                  okText: 'Close',    // default: OK
                });</script>";
              }
        }
        elseif($action=='NA'){
          $query3 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0' WHERE emp_id = '".$user_one."' and date='".$remote_date."'");
          if(mysqli_affected_rows($con)>0) {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Done',subtitle: '',  // default: ''
                okText: 'Close',    // default: OK
                });</script>";
              }
          else{
              echo"<script type='text/javascript'>
                  mscAlert({title: 'Sorry',subtitle: 'Failed to excute action because no entry available on selected date . or same data is copied',  // default: ''
                  okText: 'Close',    // default: OK
                });</script>";
              }
        }
        elseif($action=='WO'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0' WHERE emp_id = '".$user_one."' and date='".$remote_date."' ");
              if(mysqli_affected_rows($con)>0) {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Done',subtitle: '',  // default: ''
                okText: 'Close',    // default: OK
                });</script>";
              }
              else {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Sorry',subtitle: 'Failed to excute action because no entry available on selected date  or same data is copied',  // default: ''
                  okText: 'Close',    // default: OK
                });</script>";
              }
        }
        elseif($action=='Holiday'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0' WHERE emp_id = '".$user_one."' and date='".$remote_date."'");
          if(mysqli_affected_rows($con)>0) {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Done',subtitle: '',  // default: ''
                okText: 'Close',    // default: OK
                });</script>";
              }
              else {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Sorry',subtitle: 'Failed to excute action because no entry available on selected date  or same data is copied',  // default: ''
                  okText: 'Close',    // default: OK
                });</script>";
              }
        }
        elseif($action=='Leave'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0' WHERE emp_id = '".$user_one."' and date='".$remote_date."' ");
          if(mysqli_affected_rows($con)>0) {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Done',subtitle: '',  // default: ''
                okText: 'Close',    // default: OK
                });</script>";
              }
              else {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Sorry',subtitle: 'Failed to excute action because no entry available on selected date  or same data is copied',  // default: ''
                  okText: 'Close',    // default: OK
                });</script>";
              }
        }
        elseif($action=='Half Day'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0' WHERE emp_id = '".$user_one."' and date='".$remote_date."' ");
          if(mysqli_affected_rows($con)>0) {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Done',subtitle: '',  // default: ''
                okText: 'Close',    // default: OK
                });</script>";
              }
              else {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Sorry',subtitle: 'Failed to excute action because no entry available on selected date or same data is copied',  // default: ''
                  okText: 'Close',    // default: OK
                });</script>";
              }
        }

      // $query1 = mysqli_query($con,"SELECT ".$user_one." from monthly_shift_table where date = '".$date."'");
      // while($row = mysqli_fetch_array($query1)) {
      //   $text = $row[0];
      //   if($text == 'Holiday' || $text == 'holiday') {
      //     // below query is used to fetch the previous number of cofl in emp_table......
      //     $query2 = mysqli_query($con,"SELECT cofl from emp_table where empid = '".$user_one."'");
      //     while($row = mysqli_fetch_array($query2)) {
      //       $i = $row[0];
      //       $i++;
      //     }
      //     // below query are used to update the cofl, shift and insert the check_in time of employee in emp_checks table..
      //     $query3 = mysqli_query($con,"UPDATE emp_table set cofl = ".$i." WHERE empid = '".$user_one."'");
          //$query4 = mysqli_query($con,"UPDATE monthly_shift_table set ".$user_one." = 'holiday-working' where date = '".date('d-m-Y')."' "); 
       
      //   else {
      //     // below query is used to fetch the start time of shift for checking the range of check in time of employe.......      
      //     // $query8 = mysqli_query($con,"SELECT start_time from shift_table where shift_name = '".$text."' ");
      //     // while($res = mysqli_fetch_array($query8)) {
      //     //   $start_time = $res[0];
      //     // }
      //     // $expire_time = date('g:i A', strtotime($start_time."+15 min"));
      //     // $current_time = $time;//9
      //     // if($current_time > $expire_time) {
      //     //   $query = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,checks,remarks,status) VALUES ('".$user_one."', '".$remote_date."', '".$time."','P','Late Coming','1')");
      //     //   if($query) {
      //     //     echo"<script type='text/javascript'>
      //     //         mscAlert({title: 'Done',subtitle: '".$user_one." check in is done.',  // default: ''
      //     //       okText: 'Close',    // default: OK
      //     //       });</script>";
      //     //   }
      //     //   else {
      //     //       echo"<script type='text/javascript'>
      //     //         mscAlert({title: 'Sorry',subtitle: 'Failed to check in.',  // default: ''
      //     //         okText: 'Close',    // default: OK
      //     //       });</script>";
      //     //   }
      //     // }
      //     // else {
      //     //   $query = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,checks,remarks,status) VALUES ('".$user_one."', '".$remote_date."', '".$time."','P','Good','1')");
      //     //   if($query) {
      //     //     echo"<script type='text/javascript'>
      //     //         mscAlert({title: 'Done',subtitle: '".$user_one." check in is done.',  // default: ''
      //     //       okText: 'Close',    // default: OK
      //     //       });</script>";
      //     //   }
      //     //   else {
      //     //     echo"<script type='text/javascript'>
      //     //         mscAlert({title: 'Sorry',subtitle: 'Failed to check in.',  // default: ''
      //     //         okText: 'Close',    // default: OK
      //     //       });</script>";
      //     //   }
      //     // }
      //     // this query is used to insert the current check_in time of the employee in emp_checks table and also tick present.
      //   }
      // }
    //   elseif($action == "check_out") {
    //   // below query is used to update the check out time of that current date when employee check in on that time....
    //   $query = mysqli_query($con,"UPDATE emp_checks SET check_out = '".$time."' , status = '0' WHERE emp_id = '".$user_one."' AND date = '".$remote_date."'");
    //   // below query is used to fetch the check in and out for calculating the working hours of employe .....
    //   $query1 = mysqli_query($con,"SELECT check_in , check_out,remarks from emp_checks WHERE emp_id = '".$user_one."' AND date = '".$remote_date."' ");
    //   while($row = mysqli_fetch_array($query1)) {
    //     $checkTime = strtotime($row[0]);
    //     $checkout = strtotime($row[1]);
    //     $diff = $checkTime - $checkout;
    //     $init = abs($diff);
    //     $hours = floor($init / 3600);
    //     $minutes = floor(($init / 60) % 60);
    //     $seconds = $init % 60;
    //     $d = $hours.':'.$minutes.':'.$seconds;
    //     $remarks = $row[2];
    //     $query1 = mysqli_query($con,"SELECT ".$user_one." from monthly_shift_table where date = '".$date."'");
    //     while($row = mysqli_fetch_array($query1)) {
    //       $text = $row[0];
    //       if($text == 'Holiday' || $text == 'holiday') {
    //         // below query update the working_hrs in emp_checks table on current date of employee......
    //         $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."' WHERE emp_id = '".$user_one."' AND date = '".$remote_date."'");
    //       }
    //       else {
    //         $query8 = mysqli_query($con,"SELECT end_time from shift_table where shift_name = '".$text."' ");
    //         while($res = mysqli_fetch_array($query8)) {
    //           $end_time = $res[0];
    //         }
    //         $expire_end_time = date('H:i:s', strtotime($end_time."-15 min"));
    //         $current_time = $time;
    //         // if( $current_time < $expire_end_time ) {
    //         //   $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."', remarks = '".$remarks.",Early Going' WHERE emp_id = '".$user_one."' AND date = '".$remote_date."'");
    //         //   // if($query) {
    //         //   //   echo"<script type='text/javascript'>
    //         //   //     mscAlert({title: 'Done',subtitle: '".$user_one." check out is done.',  // default: ''
    //         //   //   okText: 'Close',    // default: OK
    //         //   //   });</script>";
    //         //   // }
    //         //   // else {
    //         //   //   echo"<script type='text/javascript'>
    //         //   //     mscAlert({title: 'Sorry',subtitle: 'Failed to check out.',  // default: ''
    //         //   //     okText: 'Close',    // default: OK
    //         //   //   });</script>";
    //         //   // }
    //         // }
    //         // else {
    //         //   $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."',remarks = '".$remarks.",Late Going' WHERE emp_id = '".$user_one."' AND date = '".$remote_date."'");
    //         //   if($query) {
    //         //     echo"<script type='text/javascript'>
    //         //       mscAlert({title: 'Done',subtitle: '".$user_one." check out is done.',  // default: ''
    //         //     okText: 'Close',    // default: OK
    //         //     });</script>";
    //         //   }
    //         //   else {
    //         //     echo"<script type='text/javascript'>
    //         //       mscAlert({title: 'Sorry',subtitle: 'Failed to check out.',  // default: ''
    //         //       okText: 'Close',    // default: OK
    //         //     });</script>";
    //         //   }
    //         // }
    //       }
    //     } 
    //   }
    // }
  } 
 
?>