<?php session_start();
  include('checksession.php');
  $user = $_SESSION['user'];
  $role = $_SESSION['role'];
   if($role != "admin") {
      header('location:dashboard.php');
  }
  include('popupform.php');
  include('connection.php');
  $query = mysqli_query($con," select * from emp_table where empid='".$user."'");
  while($row = mysqli_fetch_array($query)) {
    $empid = $row['empid'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $gender = $row['gender'];
    $dateofbirth = $row['dateofbirth'];
    $mobilenumber = $row['mobilenumber'];
    $emercontactno = $row['emercontactno'];
    $biomatric_id = $row['biomatric_id'];
    $emailid = $row['emailid'];
    $dateofjoining = $row['dateofjoining'];
    $bloodgroup = $row['bloodgroup'];
    $parents = $row['parents'];
    $permanentaddress = $row['permanentaddress'];
    $tempaddress = $row['tempaddress'];
    $shift = $row['shift'];
    $flag = $row['flag'];
    $employeerole = $row['employeerole'];
    $workunderteam = $row['workunderteam'];
    $reportedmanagerid = $row['reportedmanagerid'];
    $refecontactno = $row['refecontactno'];
    $bankacdetails = $row['bankacdetails'];
    $bankacnumber = $row['bankacnumber'];
    $nameinbank = $row['nameinbank'];
    $accounttype = $row['accounttype'];
    $ifsccode = $row['ifsccode'];
   
  }
  $query1 = mysqli_query($con," select * from template_roster where emp_id='".$user."'");
  while($row1 = mysqli_fetch_array($query1)) {
    $firstweekoff=$row1['firstweekoff'];
    $secondweekoff=$row1['secondweekoff'];
  }
  $user = $_SESSION['user'];
  $role = $_SESSION['role'];
  $biomatric_id = $_SESSION['biomatric_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $flag = $_SESSION['flag'];
  $check_in_out = $_SESSION['check_in_out'];
  $last_swipe = $_SESSION['last_swipe'];
  date_default_timezone_set('Asia/Kolkata'); 

   if($role!='employee'){
      define("SDFE_CSVSeparator", ",");           // Separator
      define("SDFE_CSVLineTerminator", "\n");     // Line termination
      define("SDFE_CSVFolder", "csv");            // The folder for csv files. Must exist!
      define("SDFE_CSVFolderBackup", "csvbackup"); // The folder for backup files. Must exist!
      define("SDFE_CSVFileExtension", "csv");     // The csv file extension

      // opening csv files ........................................

      // Get array of CSV files
      $csvpath = SDFE_CSVFolder . "/";
      $files = scandir($csvpath); // this is all files in dir 
       // clean up file list (to exclude)should only include csv files
        $csvfiles = array();
        foreach ($files as $basename) {
          if(substr($basename, -3)==SDFE_CSVFileExtension) {
              array_push($csvfiles, $basename);
          }
        }
        if($role=='manager'){
        $csvname=$csvpath.$workunderteam.".".SDFE_CSVFileExtension;
        } 
  }         
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
                            echo '<li><a href="modifyemployee.php">Modify Employee<span class="fa arrow"></span></a>
                                  <ul class="nav">
                                    <li><a href="#">Modify Others<span class="fa arrow"></span></a>
                                      <ul class="nav-second-level-level">
                                       <div class="radio">
                                          <label>
                                            <input type="radio" name="choice_filter" id="id_filter" value="employee">Employee Id
                                          </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="choice_filter" id="name_filter" value="name">Employee Name
                                            </label>
                                          </div>
                                        </ul>
                                    </li>
                                    <li> 
                                      <div class="col-sm-12 filter_bottom hidden" id="li_filter_by_choice_team">
                                          <select class = "form-control input-sm myselect" id="filter_by_choice_team" onchange="filteration_modify_employee();" style="width:100%;">
                                          </select>
                                      </div>
                                    </li>
                                  </ul> 
                              </li>';
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

                 <!-- team menu .......................................... -->
               <?php if($role =='admin'){
                  echo'<li>
                    <a href="#"><i class="fa fa-rocket fa-fw"></i>Team<span class="fa arrow"></span></a>
                      <ul class="nav nav-second-level">
                        <li><a href="javascript:;" onclick="div_add_team_show();">Add New Team</a></li>
                        <li><a href="javascript:;" onclick="div_show_modify_team();">Modify Team</a></li>
                      </ul>
                  </li>';
                }
               ?>
                 <!-- /.nav-third-level........................................................................ -->          
               <li>
                   <a href="#"><i class="fa fa-tasks fa-fw"></i>Shift<span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                     <?php if ($role=='admin'){
                            echo '<li><a href="javascript:;" onclick="div_show_add_new_shift();">Add Shift</a></li>';
                         }

                       if($role != "employee"){
                           echo'<li><a href="javascript:;" onclick="div_show_change_shift();">Modify Shift</a></li>';
                       }
                     ?>
                     <li>
                       <?php include('connection.php');
                        <?php include('connection.php');
                       if($role !='employee'){
                           if($role=='manager'){
                             if(file_exists($csvname)){
                              echo'<a href="monthlyshift.php">Monthly Shift</a>';
                              }
                            else {
                              echo'<a href="javascript:void(0)" onclick="showdialogshift()">Monthly Shift</a>';
                             }
                          }else{
                             if(!empty($csvfiles)){
                                echo'<a href="monthlyshift.php">Monthly Shift</a>';
                                }
                             else {
                               echo'<a href="javascript:void(0)" onclick="showdialogshift()">Monthly Shift</a>';
                         }
                        }
                        }
                       //  else{
                       //    $d=date('d');
                       //   // below if is used for date 1 to 9 and else is used for date is greater than 9 else query is executed 
                       //   if($d < 10){
                       //     $d2 = 2*$d-$d;
                       //     $query = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".date($d2.'-M-y')."' ");
                       //    }
                       //   else{
                       //     $query = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".date('d-M-y')."' ");
                       //    }
                       //   $count=mysqli_fetch_row($query);
                       //   if($count) {
                       //     echo'<a href="monthlyshift.php">Monthly Shift</a>';
                       //   }
                       //   else {
                       //     echo'<a href="javascript:void(0)" onclick="showdialogshift()">Monthly Shift</a>';
                       //   }
                       // }
                         
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
        <h2 >Modify Employee</h2>
      </div>
      <!-- /.col-lg-12 -->
  </div>
   <!--
        below code is used for the filteration of manager and employee button in the modify employee page and filteration-button.js is used for this also filtration_method.js is used ,emp_manager_ajax_call.php is called on click of button...
  -->
<!-- filteration block on the page  -->
<div class="row">
  <div class="col-lg-12">
    <div class="panel ">
      <div class="row">
          <div class="col-sm-3 hidden" id="fi_filter_by_choice_button"></div>
        </div>
      </div>
    </div>
</div>   
<!-- 
    / filtration block is close here
 -->
  <!-- /.row -->
    <div class="row">
   <form class="form-horizontal"  role="form" method="post" enctype="multipart/form-data" id="modify_employee_div">
    <div class="col-lg-6">
      <div class="panel panel-default">
      <div class="panel-body">
      <fieldset><legend>Personal Details:</legend>
          <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Employee ID</label>
                 <input class="form-control" placeholder="Enter employee id" id="empid" name="empid"  >
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Biomatric Id</label>
                <input class="form-control" type="number"  id="bmi"  name="bmi" >
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group required">
              <label class="control-label">First Name</label>
                <input class="form-control" type="text"  id="firstname"  name="firstname" >
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Last Name</label>
                <input class="form-control" type="text" id="last_name" name="last_name"  >
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group required">
              <label class="control-label">Email ID</label>
                <input class="form-control" type="text"  name="emailid" id="email">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Mobile Number</label>
                <input class="form-control" type="text" id="mobilenumber"  name="mobilenumber">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Emergency Contact No.</label>
                <input class="form-control" type="text" id="ecn"  name="ecn">
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Reference Cont No.</label>
                <input class="form-control" type="text"id="rcn" name="rcn"  >
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Gender</label>
                <input class="form-control" type="text" name="gender" >
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Check IN</label>
                <select class="form-control" name="flag">
                  <option value="manual">manual</option>
                  <option value="remote">remote</option>
                </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Date of Birth</label>
                <input class="example1 form-control" type="text" id="dateofbirth" name="dateofbirth"  >
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
                }" >
              
                <option value="A+">A+</option> <option value="A-">A-</option><option value="B+">B+</option><option value="B-">B-</option><option value="O+">O+</option>
                <option value="O-">O-</option><option value="AB+">AB+</option><option value="AB-">AB-</option><option value="HH">HH</option>
                <option value="Other">Other</option></select>
              </div>
          </div> 
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Date of Joining</label>
                <input class="example1 form-control" type="text" id="dateofjoining" name="dateofjoining" >
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Parents/Guardians</label>
                <input class="form-control" type="text" id="parents" name="parents" value="<?php echo $parents; ?>">
            </div>
          </div> 
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Parment Address</label>
                <input class="form-control" type="text"  id="parmentaddress" name="parmentaddress" value="<?php echo $permanentaddress; ?>">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Temporary Address</label>
                <input class="form-control" type="text" id="tempaddress" name="tempaddress"  value="<?php echo $tempaddress; ?>">
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group required">
              <label class="control-label">Employee Role</label>
              <select class="form-control" id="employeerole" name="employeerole">
               
                <option value="employee">Employee</option> <option value="manager">Manager</option><option value="admin">Admin</option>
              </select>
              
            </div>
          </div>
          
          <div class="col-lg-6"> 
             <div class="form-group">
              <label class="control-label">Working Team</label>
              <select class="form-control" id="workingteam" name="workingteam">
             
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
              <select class="form-control" name="shift" id="shift" >
                
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
              <input class="form-control" type="text"  id="rmi" name="rmi" value="<?php echo $reportedmanagerid; ?>">
            </div>
          </div> 
             <div class="col-lg-6"> 
           <div class="form-group">
              <label class="control-label">Status</label>
              <select class="form-control myselect " id="team" name="status" >
                   echo '<option value="1">Active</option>';
                   echo '<option value="0">Inactive</option>';
               </select>
            </div>
          </div> 
         <!--  <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">First Week Off</label>
              <select class="form-control" name="firstweekoff" >
                <option value="<?php echo $firstweekoff;?>"><?php echo $firstweekoff;?></option>
                <option value="sunday">Sunday</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                 
              </select>
            </div>
          </div>

           <div class="col-lg-6 hidden" id="secondwo">
            <div class="form-group required ">
              <label class="control-label">Second Week Off</label>
              <select class="form-control" name="secondweekoff">
                <option value="<?php echo $secondweekoff;?>"><?php echo $secondweekoff;?></option>
                <option value="sunday">Sunday</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                 
              </select>
            </div>
            </div> -->

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
            <input class="form-control" type="text" id="nib" name="nib" value="<?php echo $nameinbank; ?>">
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
        <select class="form-control" name="accounttype"id="accounttype"
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
            <input class="form-control" type="text" id="ban"  name="ban" value="<?php echo $bankacnumber; ?>" >
        </div>
      </div> 
      <div class="col-lg-6"> 
         <div class="form-group">
          <label class="control-label">IFSC Code</label>
            <input class="form-control" type="text" id="ifsc"  name="ifsc" value="<?php echo $ifsccode; ?>">
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
                  <input type="file" id="emp_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
            <div class="col-lg-5"> 
              <div class="form-group">
                <label class="control-label">Documentation Modification</label>
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
              <div class="form-group visible" id="matric_snap_div">
                  <label class="control-label">Matric Snap</label>
                      <input type="file" id="matric_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
                </div>
            </div>
            <div class="col-lg-5">
              <div class="form-group visible" id="intermediate_snap_div" >
                <label>Intermediate Snap</label>
                <input type="file" id="intermediate_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-7"> 
              <div class="form-group  visible" id="graduation_snap_div">
                <label class="control-label">Graduation Snap</label>
                    <input type="file" id="graduation_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-5">  
               <div class="form-group  visible" id="post_graduation_snap_div">
                <label class="control-label">Post Graduation Snap</label>
                    <input type="file" id="post_graduation_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>  
            </div>

            <div class="col-lg-7">
              <div class="form-group  visible" id="address_proof_snap_div">
                <label class="control-label">Address proof  Snap</label>
                  <input type="file" id="address_proof_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-5"> 
              <div class="form-group  visible" id="pan_card_snap_div">
                <label class="control-label">Pan Card Snap</label>
                    <input type="file" id="pan_card_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
            <div class="col-lg-7">  
               <div class="form-group  visible" id="experience_snap_div">
                <label class="control-label">Experience(if any) Snap</label>
                    <input type="file" id="experience_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
            <div class="col-lg-5">  
               <div class="form-group visible " id="relv_snap_div">
                <label class="control-label">Relv. Letter(if any) Snap</label>
                  <input type="file" id="relv_letter_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
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
                <input type="submit" name="submit_preview" class="btn btn-lg btn-success btn-block" value="Submit">
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
         mscAlert({title: 'CSV not found',subtitle: 'Please Update Roster.', // default: ''
        okText: 'Close',    // default: OK
        });

      }
    </script>

</body>

</html>



<?php 
if(isset($_POST['submit_preview'])) {
  include('connection.php');
  $query = mysqli_query($con,"UPDATE emp_table SET empid = '".$_POST['empid']."', biomatric_id='".$_POST['bmi']."',firstname = '".$_POST['firstname']."',lastname = '".$_POST['last_name']."', gender = '".$_POST['gender']."',dateofbirth= '".$_POST['dateofbirth']."',mobilenumber = '".$_POST['mobilenumber']."',emercontactno = '".$_POST['ecn']."',emailid = '".$_POST['emailid']."',dateofjoining = '".$_POST['dateofjoining']."',bloodgroup = '".$_POST['bloodgroup']."' ,parents = '".$_POST['parents']."',permanentaddress ='".$_POST['parmentaddress']."' ,tempaddress = '".$_POST['tempaddress']."',shift = '".$_POST['shift']."',status = '".$_POST['status']."' ,flag = '".$_POST['flag']."',employeerole = '".$_POST['employeerole']."',workunderteam = '".$_POST['workingteam']."',reportedmanagerid = '".$_POST['rmi']."',refecontactno = '".$_POST['rcn']."' ,bankacdetails = '".$_POST['bankacdetails']."',bankacnumber = '".$_POST['ban']."' ,nameinbank = '".$_POST['nib']."',accounttype = '".$_POST['accounttype']."',ifsccode = '".$_POST['ifsc']."' where id = '".$_POST['id']."'");
  $user = $_POST['empid'];
  $j = 0; 
  $query1= mysqli_query($con,"UPDATE template_roster set firstweekoff='".$_POST['firstweekoff']."',secondweekoff='".$_POST['secondweekoff']."' where emp_id='".$_POST['empid']."'");
  // Declaring Path for uploaded images.
  $target_path = "uploaded_images/";
  if (!file_exists($target_path.$user)) {
    mkdir($target_path.$user, 0777, true);
  }
  for ($i=0; $i<count($_FILES['file']['name']); $i++) {
    $target_path = "uploaded_images/";
    // Loop to get individual element from the array
    $validextensions = array("jpeg", "jpg", "png","JPG");
    $name = $_FILES['file']['name'][$i];
    // Extensions which are allowed.
    $ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
    $file_extension = end($ext); // Store extensions in the variable.
    if($i==0){
      $filename = $user.'_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==1){
      $filename = $user.'_matric_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==2){
      $filename = $user.'_intermediate_snap';
     $name = $filename.'.'.$file_extension;
    }
    if($i==3) {
      $filename = $user.'_graduation_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==4){
      $filename = $user.'_post_graduation_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==5){
      $filename = $user.'_address_proof_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==6) {
      $filename = $user.'_pan_card_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==7){
      $filename = $user.'_experience_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==8){
      $filename = $user.'_relv_letter_snap';
      $name = $filename.'.'.$file_extension;
    }
    $target_path = $target_path .$user.'/'. $name;     // Set the target path with a new name of image
    $j = $j + 1; 
         // Increment the number of uploaded images according to the files in array.
    if (($_FILES["file"]["size"][$i])  // Approx. 500kb files can be uploaded.
    && in_array($file_extension, $validextensions)) {
      if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
      // If file moved to uploads folder.
        
      }
      else {     //  If File Was Not Moved.
        echo '<script>mscAlert("'.$j ." - ".' please try again!");</script>';
      }
      
    }
    
  }
  
  if($query) {
    echo '<script type="text/javascript" >mscAlert({title: "Done",subtitle: "successfully modify.",  // default: ""
        okText: "Close",    // default: OK
        });</script>';    
  }
  else {
    echo '<script type="text/javascript" >mscAlert({title: "Sorry",subtitle: "fail to modify.",  // default: ""
        okText: "Close",    // default: OK
        });</script>';    
  }
}  
?>