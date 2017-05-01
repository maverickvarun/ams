<?php session_start();
  include('checksession.php');
  $user = $_SESSION['user'];
  $role = $_SESSION['role'];
   if($role != "admin") {
      header('location:dashboard.php');
  }
  include('popupform.php');


  $biomatric_id = $_SESSION['biomatric_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $flag = $_SESSION['flag'];
  $check_in_out = $_SESSION['check_in_out'];
  $last_swipe = $_SESSION['last_swipe'];
  date_default_timezone_set('Asia/Kolkata');           
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AMS DASHBOARD</title>

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
   
   <link href="custom-css/select2.min.css" rel="stylesheet" />

    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div id="wrapper">
  <!-- Navigation -->
   <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;margin-top:5px;">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="dashboard.php"><img src="dls_logo.png"></a>
      </div>
      <!-- /.navbar-header -->
      <ul class="nav navbar-top-links navbar-left">
         <li style="margin-top:10px;"><?php echo'&nbsp;Welcome '.$firstname.' '.$lastname.' ('.$role.')';?></li>
      </ul>
      <ul class="nav navbar-top-links navbar-right">
         <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <?php echo $last_swipe.':';?> <?php include('connection.php');
               $q4 = mysqli_query($con,"select date from emp_checks where checks='p' and emp_id = '".$biomatric_id."' order by date desc limit 1");
               while ($row=mysqli_fetch_array($q4)) {
                  echo $row[0];
               }
            ?>
            </a>
         </li>
                <!-- /.dropdown -->
         <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <?php include('connection.php'); 
               if($flag == 'remote') {
                  $date = date("Y-m-d"); 
                  $status = '';
                  // below query is used to hide the checking button if user checkout then button is disabled.....
                  $query5 = mysqli_query($con,"SELECT status from emp_checks where emp_id = '".$biomatric_id."' and date = '".$date."'");
                  while($result = mysqli_fetch_array($query5)){
                     $status = $result[0];
                  }
                  if($status == '0') {
                  }
                  else {
                     echo '<span class="fa fa-sign-in check-in" name="checking" id="checking" value="'.$check_in_out.'" > '.$check_in_out.'</span>';
                  }
               }
            ?>
            </a>
         <!-- /.dropdown-tasks -->
         </li>
      
         <!-- /.dropdown -->
         <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
               <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
               <?php
                if($role!="employee"){
                  echo'<li><a href="javascript:;" id="remote_checkin_popup" onclick="div_show_remote_checkin()"><i class="fa fa-desktop fa-fw" ></i>Remote Checkin</a>
                  </li>';
                }
              ?>
               <li><a href="javascript:;" id="change_password_popup" onclick="div_show()"><i class="fa fa-gear fa-fw" ></i>Change Password</a>
               </li>
               <li class="divider"></li>
               <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
               </li>
            </ul>
           <!-- /.dropdown-user -->
         </li>          <!-- /.dropdown -->
                
      </ul>
            <!-- /.navbar-top-links -->
      <div class="navbar-default sidebar " role="navigation" >
         <div class="sidebar-nav navbar-collapse" >
            <ul class="nav" id="side-menu">
               <li><a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>  
               <li class="active"><a href="#"><i class="fa fa-male fa-fw"></i>Employee<span class="fa arrow"></span></a>
                 <ul class="nav nav-second-level">
                         <?php if ($role=='admin'){
                                       echo '<li><a href="addemployee.php">Add Employee</a></li>';
                                       echo '<li><a href="modifyemployee.php">Modify Employee</a></li>';
                                   }
                         ?>
                     <li><a href="viewsigninout.php" >View Attendance</a></li>
                     
                     <?php if($role!="employee"){ 
                         echo '<li><a href="viewemployeedetails.php">View Employee Details</a></li>';
                        }
                     ?>
                  </ul>
               </li>

               <li>
                  <a href="#"><i class="fa fa-briefcase fa-fw"></i>Leave<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                   <?php if($role != "admin"){
                     echo '<li><a href="javascript:;" onclick="div_leave_request_show();">Leave Request</a></li>';
                      } 
                        if($role != "employee") {
                         echo'<li><a href="leavedetails.php">Leave Details</a></li>';
                        } 
                     ?>
                      <li><a href="availableleaves.php">Available Leaves</a></li>
                  </ul>
               </li>

                 <!-- /.nav-third-level........................................................................ -->          
               <li>
                   <a href="#"><i class="fa fa-tasks fa-fw"></i>Shift<span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                     <?php if ($role=='admin'){
                            echo '<li><a href="javascript:;" onclick="div_show_add_new_shift();">Add Shift</a></li>';
                         }

                       if($role != "employee"){
                           echo'<li><a href="javascript:;" onclick="div_show_change_shift();">Change Shift</a></li>';
                       }
                     ?>
                     <li>
                       <?php include('connection.php');
                         $d=date('d');
                         // below if is used for date 1 to 9 and else is used for date is greater than 9 else query is executed 
                         if($d < 10){
                           $d2 = 2*$d-$d;
                           $query = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".date($d2.'-M-y')."' ");
                         }
                         else{
                           $query = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".date('d-M-y')."' ");
                         }
                         $count =mysqli_fetch_row($query);
                         if($count) {
                           echo'<a href="monthlyshift.php">Monthly Shift</a>';
                         }
                         else {
                           echo'<a href="javascript:void(0)" onclick="showdialogshift()">Monthly Shift</a>';
                         }
                       ?>
                     </li>
                   </ul>
               </li>

           <!-- /.nav-fourth-level.................................................................... -->

               <li>
                   <a href="#"><i class="fa fa-clock-o fa-spin fa-fw"></i>Calendar<span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                     <?php if ($role=='admin'){
                           echo '<li><a href="addroster.php">Add Monthly Roster</a></li>';
                       }?>
                     
                     <li>
                         <a href="holiday.php">Holiday</a>
                     </li>
                   </ul>
               </li>

              <!-- /.nav-fifth-level......................................................................... -->

              <?php if($role!='employee'){
                echo'<li><a href="report.php"><i class="fa fa-bar-chart-o fa-fw"></i>Report</a></li>';
              }
              ?>

           <!-- /.nav-sixth-level....................................................................... -->        
           <li>
               <a href="manual.php"><i class="fa fa-bar-chart-o fa-fw"></i>Manual & FAQ</a>
           </li>
                    <!-- /.nav-seven-level....................................................................... -->
           <?php if($role == 'admin') {
             echo '<li>
                   <a href="machine-connection.php"><i class="fa fa-bar-chart-o fa-fw"></i>Connection</a>
                 </li>';}?>
         </ul>
         </div>
         <!-- /.sidebar-collapse -->
         </div> 
          <!-- /.navbar-static-side -->
         </nav> 
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
        <h2 >Add Employee</h2>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <div class="row">
   <form class="form-horizontal"  role="form" onsubmit="return(add_employee())" method="post" action="preview.php" enctype="multipart/form-data" >
    <div class="col-lg-6">
      <div class="panel panel-default">
      <div class="panel-body">
      <fieldset><legend>Personal Details:</legend>
          <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Employee ID</label>
                  <input class="form-control"  id="empid"  name="empid" required="required">
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Biomatric Id</label>
                  <input class="form-control" type="number"  id="bmi" name="bmi">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group required">
              <label class="control-label">First Name</label>
                  <input class="form-control" type="text"  id="firstname"  name="firstname">
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Last Name</label>
                  <input class="form-control" type="text" id="last_name"  name="last_name">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Password</label>
                  <input class="form-control" type="password" id="emp_password" name="emppassword">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Confirm Password</label>
                  <input class="form-control" type="password" id="confirm_password" name="confirmpassword" ><span id="password_msg"></span>
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group required">
              <label class="control-label">Email ID</label>
                <input class="form-control"  type="email" id="email" name="emailid" >
                <span id="result"></span>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Mobile Number</label>
                <input class="form-control" type="text" id="mobilenumber" name="mobilenumber">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Emergency Contact No.</label>
                  <input class="form-control" type="text"  id="ecn" name="ecn">
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Reference Cont No.</label>
                  <input class="form-control" type="text" id="rcn"  name="rcn" >
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Gender</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="gender" value="Male" checked>Male
                  </label>
                  <label style="margin-left:5px;">
                    <input type="radio" name="gender" value="Female">Female
                  </label>
                </div>
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Check IN</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="flag" value="remote" checked>Remote
                  </label style="margin-left:5px;">
                  <label>
                    <input type="radio" name="flag" value="manual" checked>Manual
                  </label>
                </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Date of Birth</label>
              <input class="example1 form-control" type="text" id="date_of_birth" name="date_birth">
                
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Blood Group</label>
              <select class="form-control" name="bloodgroup" id="bloodgroup"
                  onChange="idx = this.selectedIndex;val = this.options[idx].value;if (val=='Other') { 
                var opt = prompt('Specify option, please','');
                  if (opt) {
                    this.options[this.selectedIndex]=new Option(opt,opt);
                    this.options[this.options.length]=new Option('Other','Other');
                    this.selectedIndex=idx;
                  }
                }">
                <option value="A+">A+</option> <option value="A-">A-</option><option value="B+">B+</option><option value="B-">B-</option><option value="O+">O+</option>
                <option value="O-">O-</option><option value="AB+">AB+</option><option value="AB-">AB-</option><option value="HH">HH</option>
                <option value="Other">Other</option></select>
            </div>
          </div> 
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Date of Joining</label>
                <input class="example1 form-control" type="text" id="date_of_joining" name="date_joining" >
                
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Parents/Guardians</label>
                  <input class="form-control" type="text" id="parents" name="parents" >
            </div>
          </div> 
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Parment Address</label>
              <textarea class="form-control" rows="3" id="parmentaddress"  name="parmentaddress"></textarea>
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Temporary Address</label>
                <input type="checkbox" value=""  id='same_address'>Do as Permanent
                  <textarea class="form-control" rows="3" id="tempaddress" name="tempaddress"></textarea>
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group required">
              <label class="control-label">Employee Role</label>
              <select class="form-control" name="employeerole">
                <option value="employee">Employee</option> <option value="manager">Manager</option><option value="admin">Admin</option>
              </select>
            </div>
          </div>
          <div class="col-lg-6"> 
             <div class="form-group">
              <label class="control-label">Working Team</label>
              <select class="form-control" name="workingteam">
                <?php 
                  $query = mysqli_query($con,"select team_name from team_table");
                  while($result = mysqli_fetch_array($query)) {
                    $team_name = $result['team_name'];
                    echo '<option value='.$team_name.'>'.$team_name.'</option>';
                  }
                 ?>
              </select>
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Shift</label>
              <select class="form-control" name="shift" >
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
          <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Reportee</label>
              <select class="form-control" id="reported_manager_id" name="reportee_manager_id" required>
                <?php 
                  include('connection.php');
                  $qur = mysqli_query($con,"SELECT empid, firstname,lastname from emp_table where employeerole <>'employee' ");
                  while($rows = mysqli_fetch_array($qur)) {   
                    $id = $rows['empid'];
                    echo'<option value="'.$id.'">'.$id.' '.$rows['firstname'].' '.$rows['lastname'].'</option>';
                  }
                ?>
              </select>
            </div>
          </div> 
      </fieldset>         
    </div>
    </div>
  </div> 
<!-- /col-lg-6
   below code is for the bank details panel of employeee...........
  -->
  <div class="col-lg-6">
    <div class="panel panel-default">
    <div class="panel-body">
    <fieldset><legend>Bank Details:</legend>
      <div class="col-lg-6">
       <div class="form-group">
          <label class="control-label">Name in Bank</label>
              <input type="text" class="form-control" id="nib" name="nib">
        </div>
      </div> 
      <div class="col-lg-6"> 
        <div class="form-group">
          <label class="control-label">Bank A/C Details</label>
          <select class="form-control" name="bankacdetails" id="bankacdetails"
      onChange="idx = this.selectedIndex;val = this.options[idx].value;if (val=='Other') { 
                var opt = prompt('Specify option, please','');
                  if (opt) {
                    this.options[this.selectedIndex]=new Option(opt,opt);
                    this.options[this.options.length]=new Option('Other','Other');
                    this.selectedIndex=idx;
                  }
                }">
            <option value="state bank of india">State Bank Of India</option>
            <option value="punjab nataional bank">Punjab National Bank</option>
            <option value="hdfc">HDFC</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>
      <div class="col-lg-6">  
       <div class="form-group">
        <label class="control-label">Account Type</label>
        <select class="form-control" name="accounttype"
          onChange="idx = this.selectedIndex;val = this.options[idx].value;if (val=='Other') { 
          var opt = prompt('Specify option, please','');
            if (opt) {
              this.options[this.selectedIndex]=new Option(opt,opt);
              this.options[this.options.length]=new Option('Other','Other');
              this.selectedIndex=idx;
            }
          }">
          <option value="saving account">Saving Account</option>
          <option value="current account">Current Account</option>
          <option value="Other">Other</option>
        </select>
       </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group">
          <label class="control-label">Bank A/C Number</label>
              <input class="form-control" type="text" id="ban" name="ban">
        </div>
      </div> 
      <div class="col-lg-6"> 
         <div class="form-group">
          <label class="control-label">IFSC Code</label>
              <input class="form-control" type="text" id="ifsc"  name="ifsc">
        </div>
      </div> 
    </fieldset>
    </div>
    </div> 
  </div>     
<!-- /col-lg-6
            below code is for the document details panel of employeee...........
  -->

    <div class="col-lg-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <fieldset><legend>Document Details:</legend>
            <div class="col-lg-7">
              <div class="form-group">
                <label class="control-label">Photo</label>
                <input  type="file" id="emp_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-5"> 
              <div class="form-group">
                <label class="control-label">Document Submission</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="document" value="yes" id="yes" checked>Yes
                  </label>
                  <label>
                    <input type="radio" name="document" value="no" id="no" >No
                  </label>
                </div>
              </div>
            </div> 
            <div class="col-lg-7">
              <div class="form-group  visible" id="matric_snap_div">
                  <label class="control-label">Matric Snap</label>
                      <input class="" type="file" id="matric_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
                </div>
            </div>
            <div class="col-lg-5">
              <div class="form-group visible" id="intermediate_snap_div">
                  <label>Intermediate Snap</label>
                    <input type="file" id="intermediate_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>  
            <div class="col-lg-7"> 
              <div class="form-group  visible" id="graduation_snap_div">
                <label class="control-label">Graduation Snap</label>
                    <input class="" type="file" id="graduation_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-5">  
               <div class="form-group  visible" id="post_graduation_snap_div">
                <label class="control-label">Post Graduation Snap</label>
                    <input class="" type="file" id="post_graduation_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>  
            </div>

            <div class="col-lg-7">
              <div class="form-group  visible" id="address_proof_snap_div">
                <label class="control-label">Address proof  Snap</label>
                    <input class=" " type="file" id="address_proof_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-5"> 
              <div class="form-group  visible" id="pan_card_snap_div">
                <label class="control-label">Pan Card Snap</label>
                    <input class=" " type="file" id="pan_card_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
            <div class="col-lg-7">  
               <div class="form-group  visible" id="experience_snap_div">
                <label class="control-label">Experience(if any) Snap</label>
                    <input class=" " type="file" id="experience_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
            <div class="col-lg-5">  
               <div class="form-group visible " id="relv_snap_div">
                <label class="control-label">Relv. Letter(if any) Snap</label>
                    <input class=" " type="file" id="relv_letter_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
             <div class="col-lg-12">  
              <div class="form-group " id="preview_snap_div">
                <label><b>Preview after selection of photo</b></label>
                    <img id="output"/ class="image_preview">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Submit">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <button type="reset" class="btn btn-block btn-primary btn-lg ">Reset</button>
              </div>
          </div>  
        </fieldset>
        </div>
      </div> 
    </div>
    <!-- /col-lg-6 -->
  </form>
 </div>
 <!-- /row -->
</div>
 <!-- /# page  wrapper -->
</div>
   <!-- /#wrapper -->
   <!-- jQuery -->
<!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>

    <script src="../vendor/morrisjs/morris.min.js"></script>

    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <!-- jQuery datepicker-->

    <script src="custom-js/bootstrap-datepicker.js"></script>
    
    <script src="custom-js/filteration-button.js"></script>

    <script type="text/javascript" src="custom-js/filtration_method.js"></script>

    <script type="text/javascript" src="custom-js/check_in_button.js"></script>

    <script src="custom-js/popup.js"></script>

    <script src="Timepicki/js/timepicki.js"></script>

    <script src="custom-js/employee_add_page.js"></script>
    <script src="custom-js/select2.min.js"></script>
    <script type="text/javascript">

      $(".myselect").select2();

</script>
    <script type="text/javascript">
      // When the document is ready
      $(document).ready(function () {
        $('.example1').datepicker({
          format: "yyyy-mm-dd"
        });  
      });
    </script>
    
    <script>
      var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
      };
    </script>
     
    <script>
      $('#timepicker1').timepicki();
      $('#custom-time').click(function() {
        $('#timepicker1').show();
      });
      $('#current-time').click(function() {
        $('#timepicker1').hide();
      });
    </script>
    <script type="text/javascript">
    /**
      * below two function is used to show the dialog box on the menu bar and monthly shift panel if monthly shift is not updated for the month or no data is avaiable in the monthly shift
    */
   
    function showdialogshift() {
        mscAlert({title: 'Sorry',subtitle: 'Shift not yet updated.',  // default: ''
        okText: 'Close',    // default: OK
        });

      }
    </script>

</body>

</html>