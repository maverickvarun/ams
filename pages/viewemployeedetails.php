<?php  session_start();
 include('checksession.php');
  include('popupform.php');
  $role = $_SESSION['role'];
  $user = $_SESSION['user'];
  if($role == "employee") {
    header('location:dashboard.php');
  }
  $biomatric_id = $_SESSION['biomatric_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $flag = $_SESSION['flag'];
  $check_in_out = $_SESSION['check_in_out'];
  $last_swipe = $_SESSION['last_swipe'];
  $workunderteam=$_SESSION['workunderteam'];
 date_default_timezone_set('Asia/Kolkata'); 
  $date = strtotime(date("Y-m-d"));
  $day = date('d', $date);
  $month = date('m', $date);  
  $year = date('Y', $date);
  $firstDay = mktime(0,0,0,$month, 1, $year);
  $title = strftime('%B', $firstDay);

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
      <div class="navbar-default sidebar " role="navigation"  >
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
                  <li ><a href="viewsigninout.php" >View Attendance</a></li>
                  <?php if($role!="employee"){ 
                         echo '<li><a href="viewemployeedetails.php">View Employee Details<span class="fa arrow"></span></a>
                           <ul class="nav nav-second-level">
                           <li><div class="col-lg-12 filter_top"> 
                           <div class="form-group">
                         
                            ';             
              echo'<ul class="nav">
                    <li ><a href="#">View Others<span class="fa arrow"></span></a>
                      <ul class="nav nav-second-level">
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
                  </ul>
                </div>   
            
            ';
          echo '</select></div>
          <div class="col-sm-12 filter_bottom hidden" id="li_filter_by_choice_team">
            <select class = "form-control input-sm myselect" style="width:100%;" id="filter_by_choice_team" onchange="filtration_view_employee_details();">
            </select>
          </div></li>
                     
        </ul> </li>';
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
                       // else{
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
                     <?php if ($role!='employee'){
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
    <div class="col-lg-6"> <h2 >View Employee Details</h2></div>
  </div>
<!-- /.row -->

<!--  filteration block is started here .....................................................-->   
  <div class="row">
  <div class="col-lg-12">
    <div class="panel">
      <div class="row">
          <div class="col-sm-3 hidden" id="fi_filter_by_choice_button"></div>
        </div>
      </div>
    
  </div>
</div>
    <!--  filteration block is closed here-->   


    <!--
            below code is for the personal details panel of employeee...........
  -->
<div id="view_details">  
<div class="row" >
      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">

              <?php 
                include('connection.php');
                $query = mysqli_query($con,"select empid,biomatric_id,firstname,lastname,dateofbirth,emercontactno,mobilenumber,emailid,dateofjoining,bloodgroup,permanentaddress,tempaddress,parents from emp_table where empid = '".$user."' ");
                while($row = mysqli_fetch_array($query)) {
                echo'
                <form class="form-horizontal"  role="form" enctype="multipart/form-data" >
                <fieldset><legend>Personal Details:</legend>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Employee ID</label>
                        <input class="form-control" id="empid" name="empid">
                  </div>
                </div>
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Biomatric Id</label>
                        <input class="form-control" type="text"  id="biomatric_id"  name="biomatric_id" >
                  </div>
                </div>
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Employee Name</label>
                        <input class="form-control" type="text"  id="firstname"  name="firstname">
                  </div>
                </div> 
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Date of Birth</label>
                        <input class="form-control" type="text" id="dateofbirth"  name="dateofbirth" >
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Mobile Number</label>
                        <input class="form-control"  >
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Emer. Contact No.</label>
                        <input class="form-control" >
                  </div>
                </div> 
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Email Id</label>
                        <input class="form-control" type="text"   >
                  </div>
                </div> 
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Date Of Joining</label>
                        <input class="form-control" type="text" >
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Blood Group</label>
                        <input class="form-control" >
                  </div>
                </div> 
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Permanent Address</label>
                        <input class="form-control" type="text"  >
                  </div>
                </div> 
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Temp. Address</label>
                        <input class="form-control" type="text">
                  </div>
                </div>
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Parents/Gardian</label>
                        <input class="form-control" type="text">
                  </div>
                </div>
                  </fieldset></form>';
                }
                  ?>
        
      </div> 
    </div>
  </div> 
<!--
            below code is for the bank details panel of employeee...........
  -->

      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
             <?php 
                include('connection.php');
                $query = mysqli_query($con,"select bankacdetails,bankacnumber,nameinbank,accounttype,ifsccode from emp_table where empid = '".$user."' ");
                while($row = mysqli_fetch_array($query)) {
                echo'
                <form class="form-horizontal"  role="form" enctype="multipart/form-data" >
                <fieldset><legend>Bank Details:</legend>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Name Of Bank</label>
                        <input class="form-control" value="'.$row['bankacdetails'].'">
                  </div>
                </div> 
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Account Number</label>
                        <input class="form-control" type="text"  value="'.$row['bankacnumber'].'">
                  </div>
                </div> 
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Name In Bank</label>
                        <input class="form-control" type="text" value="'.$row['nameinbank'].'"  >
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Account Type</label>
                        <input class="form-control"  value="'.$row['accounttype'].'" >
                  </div>
                </div> 
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>IFSC Code</label>
                        <input class="form-control" type="text"   value="'.$row['ifsccode'].'" >
                  </div>
                </div> 
                
                </fieldset></form>';
                }
                  ?>
    
      </div> 
    </div>
  </div> 
</div>     
<!--
            below code is for the document details panel of employeee...........
  -->

      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
             <?php 
              echo'
              <form class="form-horizontal"  role="form" enctype="multipart/form-data" >
              <fieldset><legend>Document Details:</legend>';
              $dir = 'uploaded_images/'.$user;
              $files = glob($dir."/*.*");
              for ($i=0; $i<count($files); $i++) {
                $image = $files[$i];
                $supported_file = array('gif','jpg','jpeg','png');
                $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                if(in_array($ext, $supported_file)) {
                   $image ."<br />";
                   echo '<img src="'.$image.'"style="width:110px;height:110px;margin-left:10px;box-shadow:0px 0px 4px 5px #fff;"/>';
              } else {
                  continue;
               }

              }

             echo' </fieldset></form>';
            ?> 
           </div>
      </div> 
    </div>
  </div> 
</div>  
</div> 
   <div class="validate_check_roles" style="display:none";><?php echo $_SESSION["role"]; ?></div>
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
    <script src="custom-js/select2.min.js"></script>
    <script type="text/javascript">

      $(".myselect").select2();

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




