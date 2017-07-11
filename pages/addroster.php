<?php session_start();

  include('checksession.php');
  include('popupform.php');
  $role = $_SESSION['role'];
$user = $_SESSION['user'];
/*if($role != "employee") {
      header('location:dashboard.php');
  }*/
$biomatric_id = $_SESSION['biomatric_id'];
$firstname = $_SESSION['firstname'];
 $lastname = $_SESSION['lastname'];
 $flag = $_SESSION['flag'];
 $check_in_out = $_SESSION['check_in_out'];
 $last_swipe = $_SESSION['last_swipe'];
 date_default_timezone_set('Asia/Kolkata'); 
$date = strtotime(date("Y-m-d"));
$day = date('d', $date);
$month = date('m', $date);
$year = date('Y', $date);
$firstDay = mktime(0,0,0,$month, 1, $year);
$title = strftime('%B', $firstDay);
$workunderteam=$_SESSION['workunderteam'];

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

    <title>Add Roster</title>

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
               <li><a href="#"><i class="fa fa-male fa-fw"></i>Employee<span class="fa arrow"></span></a>
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
                        }//else{
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

               <li class="active">
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
      <div class="col-lg-4"> <h2 >Add Monthly Roster</h2></div>
  </div>
<!-- /.row -->
<!-- code of filteration block of this page started here ......................................-->
 <div class="row" >
      
           

      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
               <form class="form-horizontal" method="post" action="monthly-csv.php" role="form" enctype="multipart/form-data" >
                <div class="col-lg-12">
                  <div class="form-group">
                 <?php 
                 if($role=="admin"){
                   echo' <div class="col-lg-4" id="secondwo">
                    <div class="form-group required ">
                    <label class="control-label">Select team</label>
                     <select class="form-control input-sm myselect" name="teamname" required>';
                    
                        $query = mysqli_query($con,"select team_name from team_table");
                         echo '<option value="">-Select team-</option>';
                        while($result = mysqli_fetch_array($query)) {
                          $team_name = $result['team_name'];
                          echo '<option value='.$team_name.'>'.$team_name.'</option>';
                        }
                      
                   echo' </select>
                    </div>
                    </div>';
                  }
                     ?>
                    <label class="control-label">Browse for uploading new monthly shift file </label>
                    <input  type="file" name="csv_file" id="browse_csv_file"  accept=".csv" >
                 </div>   
                </div>
                 <input type="submit" name="btn_submit" id="uploading" value="Upload Monthly Shift" class="btn btn-outline btn-primary btn-lg btn-success">  
              </form>
           </div>
      </div> 
    </div>
  </div> 

      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <form class="form-horizontal" method="post" action="biomatric_csv.php" role="form" enctype="multipart/form-data" >
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Browse for uploading  the biomatric csv</label>
                    <input  type="file" name="file" id="biomatric_csv_file" >
                    <input type="submit" name="upload_csv_button" value="Upload CSV" class="btn btn-outline btn-primary btn-lg btn-success">
                  </div>
                  
                </div>
              </form>
              <form action="addroster.php" method="post">
                <div class="col-lg-12">
                 <div class="form-group">
                  <select  class="form-control" name='choose_month_csv' id='choose_month_csv' required>
                          <option value="">Choose Status</option>
                          <option value="Jan">Jan</option>
                          <option value="Feb">Feb</option>
                          <option value="Mar">March</option>
                          <option value="Apr">April</option>
                          <option value="May">May</option>
                          <option value="Jun">June</option>
                          <option value="Jul">July</option>
                          <option value="Aug">Aug</option>
                          <option value="Sep">Sept.</option>
                          <option value="Oct">Oct.</option>
                          <option value="Nov">Nov.</option>
                          <option value="Dec">Dec.</option>
                    </select>
                    <input type="submit" value="Get Attendance Data" name="get_attendance_data" id="get_attendance_data"class="btn btn-outline btn-primary btn-lg ">
                  </div>
                </div>
              </form>
           </div>
      </div> 
    </div>
  </div> 
</div>

  
<div class="validate_check_roles" style="display:none";><?php echo $_SESSION['role']; ?></div>

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
    <script src="custom-js/select2.min.js"></script>
    <script type="text/javascript">

      $(".myselect").select2();

</script>
<script>
    /*$(document).ready(function(){
    $("#browse_csv_file").on('change',function(){
        var dealers = $("#browse_csv_file");
        var arrfilepath = dealers.val().split("\\");
        var filename = arrfilepath[arrfilepath.length - 1];
        if (filename != "monthly-shift.csv") {
          $("#uploading").hide();
          alert("Wrong file! Please file name must be 'monthly-shift.csv'");
        }
        else {
            $("#uploading").show();
        }
          });
    });
    $('#browse_csv_file').on('click',function() {
      alert("date format in csv is same as previous csv e.g.01-01-2017");
    });*/
    
    /**
* function is used for updating the biomatric csv in the database 
*/
function load_biomatric_csv() {
 $.ajax({
    url: 'biomatric_csv.php',
    method: "post",
    data: {},
    dataType:'text',
    success: function(result){
      document.getElementById("update_biomatric_csv").innerHTML=result;
    }
  });
};

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
        mscAlert({title: 'CSV not found',subtitle: 'Please Update Roster.',  // default: ''
        okText: 'Close',    // default: OK
        });

      }
    </script>

</body>

</html>
<?php
  if(isset($_POST['get_attendance_data'])){
    include('connection.php');
    $year = '15';
    $month = $_POST['choose_month_csv'];
    $year1 = date_create_from_format('y', $year);
    $changed_year = $year1->format('Y') ; 
    $changed_month= date('m',strtotime($month.'-'.$changed_year));
    $loop=cal_days_in_month(CAL_GREGORIAN,$changed_month,$changed_year);
    $query = mysqli_query($con,"SELECT * FROM `emp_table` where biomatric_id='3'");
    //count if data is selected or not
    $countEmployee = mysqli_num_rows($query);
    if($countEmployee!=0){
      while($employee = mysqli_fetch_array($query)){
        $Emp_id = $employee['biomatric_id'];
        $workunderteam = $employee['workunderteam'];
        $dateofjoining = $employee['dateofjoining'];
        $date_of_joining = date("Y-m-d",strtotime($dateofjoining));
                // below code for other than chat team employee
        if($workunderteam=='Chat'){
          for($i=1;$i<=$loop;$i++) {
            //generate date
            $date = $i.'-'.$month.'-'.$year;
            $converted_date = date("Y-m-d", strtotime($date));
            $prev_date = date('Y-m-d', strtotime($date .' -1 day'));
            $next_date = date('Y-m-d', strtotime($date .' +1 day'));
            //seldata according date or emp_id
            $query1 = mysqli_query($con,"SELECT * FROM `csv_table` WHERE Emp_id='".$Emp_id."' AND Date ='".$date."'");
            $count = mysqli_num_rows($query1);
            if($count!=0){
              while($result = mysqli_fetch_array($query1)){
                $query5 = mysqli_query($con,"SELECT emp_id,date,check_in,check_out from emp_checks where emp_id = '".$Emp_id."' and date ='".$converted_date."'");
                $count1 = mysqli_num_rows($query5);
                if($count1!=0) {
                  while($row = mysqli_fetch_array($query5)) {
                    // below code is used to calculate the working hours of employee
                    $checkTime = strtotime($row[2]);
                    $newtimestamp = strtotime("+19 hours", $checkTime);
                    $checkout = strtotime($result['Time']);
                    $diff = $checkTime - $checkout;
                    $init = abs($diff);
                    $hours = floor($init / 3600);
                    $minutes = floor(($init / 60) % 60);
                    $seconds = $init % 60;
                    $d = $hours.':'.$minutes.':'.$seconds;
                    if($checkout<$newtimestamp) {
                      mysqli_query($con,"UPDATE emp_checks set check_out = '".$result['Time']."', working_hrs ='".$d."',status='0' where date = '".$prev_date."' and emp_id='".$Emp_id."' ");
                    }else{
                        mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,particulars,remarks,status) VALUES ('".$Emp_id."', '".$converted_date."','".$result['Time']."','','','P','',','1')");
                      }
                  }
                } 
                // else{
                //   $query6 = mysqli_query($con,"SELECT emp_id,date,check_in,check_out from emp_checks where emp_id = '".$Emp_id."' and date ='".$prev_date."'");
                //   $count2 = mysqli_num_rows($query5);
                //   if($count2!=0){
                //       while($row6 = mysqli_fetch_array($query6)){
                //         if($row6['checks']=='P'){
                //           $checkTime = strtotime($row6[2]);
                //           $newtimestamp = strtotime("+19 hours", $checkTime);
                //           $checkout = strtotime($result['Time']);
                //           $diff = $checkTime - $checkout;
                //           $init = abs($diff);
                //           $hours = floor($init / 3600);
                //           $minutes = floor(($init / 60) % 60);
                //           $seconds = $init % 60;
                //           $d = $hours.':'.$minutes.':'.$seconds;
                //           if($checkout<$newtimestamp) {
                //             mysqli_query($con,"UPDATE emp_checks set check_out = '".$result['Time']."', working_hrs ='".$d."',status='0' where date = '".$prev_date."' and emp_id='".$Emp_id."' ");
                //           }else{
                //             mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,particulars,remarks,status) VALUES ('".$Emp_id."', '".$converted_date."','".$result['Time']."','','','P','',','1')");
                //           }
                //         }
                //         //$query3 = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,particulars,remarks,status) VALUES ('".$Emp_id."', '".$converted_date."','".$result['Time']."','','','P','',','1')");
                //       }  
                //   }
                  
                // }
              }
            }
            else if(strtotime($date_of_joining) <= strtotime($converted_date)){
              mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$Emp_id."', '".$converted_date."', '','','','A','Absent','0')");
            }
          }
        }
      }
    }
    if($query){
      echo "<script type='text/javascript'>mscAlert({title: 'Done',subtitle: '".$month."-".$changed_year." Month csv data is successfully uploaded.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
    }
  }
?>
