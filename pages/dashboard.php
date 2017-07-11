<?php session_start();
  include('checksession.php');
  include('popupform.php');
  $user = $_SESSION['user'];
  $role = $_SESSION['role'];
  $biomatric_id = $_SESSION['biomatric_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $flag = $_SESSION['flag'];
  $check_in_out = $_SESSION['check_in_out'];
  $last_swipe = $_SESSION['last_swipe'];
  $workunderteam = $_SESSION['workunderteam'];
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


    <link href="custom-css/datepicker.css" rel="stylesheet">

    <link href="Timepicki/css/timepicki.css" rel="stylesheet">

   <link rel="stylesheet" href="custom-css/popup.css">

   <link href="custom-css/select2.min.css" rel="stylesheet" />

   <link href="custom-css/sheet.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body >
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
                  echo'<li><a href="javascript:;" id="remote_checkin_popup" onclick="div_show_remote_checkin();"><i class="fa fa-desktop fa-fw" ></i>Remote Checkin</a>
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
      <div class="navbar-default sidebar" role="navigation" >
         <div class="sidebar-nav navbar-collapse"  >
            <ul class="nav" id="side-menu">
               <li>
                  <a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard<span class="fa arrow"></span></a>
                  <ul class="nav">
                   <?php if($role != "employee") {
                      echo'<li><a href="#">View Employee Calendar<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                              <li><div class="navbar-form" role="search">
                                    <div class="input-group">
                                      <input class="form-control searchbox" placeholder="Search Name, Id" id="search_term" type="text" list="filter_by_choice_team" onchange="filteration_calendar_month();">

                                      <div class="input-group-btn" >
                                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-arrow-right"></i></button>
                                      </div>
                                    </div>
                                    <input class="form-control hidden" type="text" id="selectedemp">

                                  </div>
                                </li>
                              <datalist id="filter_by_choice_team" style="width:100%">
                              </datalist>
                            </ul>
                        </li>';
                       }
                     ?>
                     <!--  // <div class="form-group">
                                //   <select class="form-control hidden" id="filter_by_choice_team" onchange="filteration_calendar_month();" >
                                //   </select>
                                // </div> -->
                 <!--  <?php if($role != "employee") {
                      // echo'<li><a href="#">View Employee Calendar<span class="fa arrow"></span></a>
                      //       <ul class="nav nav-third-level">
                      //         <li>
                      //         <div class="col-lg-12 filter_top">
                      //           <div class="form-group">
                      //             <div class="radio">
                      //                <label>
                      //                  <input type="radio" name="choice_filter" id="id_filter" value="employee">Search by Id
                      //                </label>
                      //              </div>
                      //              <div class="radio">
                      //                <label>
                      //                  <input type="radio" name="choice_filter" id="name_filter" value="name">Search by Name
                      //                </label>
                      //              </div>
                      //           </div>
                      //         </div>
                      //         <div class="col-sm-12 hidden filter_bottom" id="li_filter_by_choice_team">
                      //           <select class = "form-control input-sm filtration-block-button myselect" id="filter_by_choice_team" style="width:100%;" onchange="filteration_calendar_month();">
                      //             </select>
                      //         </div>
                      //        </li>
                      //     </ul>
                      //   </li>';
                       }
                     ?> -->
                 </ul>
               </li>
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
                            echo '<li><a href="javascript:;" onclick="div_show_add_new_shift();">Add New Shift</a></li>';
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
                        }else{
                       //    $d=date('d');
                       //   // below if is used for date 1 to 9 and else is used for date is greater than 9 else query is executed
                       //   if($d < 10){
                       //     $d2 = 2*$d-$d;
                       //     $query = mysqli_query($con,"SELECT ".$user." from ".$workunderteam."_table  ");
                       //    }
                       //   else{
                       //     $query = mysqli_query($con,"SELECT ".$user." from ".$workunderteam."_table ");
                       //    }
                       //   // $count=mysqli_fetch_row($query);
                       //   // if($count) {
                            echo'<a href="monthlyshift.php">Monthly Shift</a>';
                       //    // }
                       //   // else {
                       //   //   echo'<a href="javascript:void(0)" onclick="showdialogshift()">Monthly Shift</a>';
                       //   // }
                        }

                       ?>
                     </li>
                   </ul>
               </li>

           <!-- /.nav-fourth-level.................................................................... -->

               <li>
                   <a href="#"><i class="fa fa-clock-o fa-spin fa-fw"></i>Calendar<span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                     <?php if ($role!='employee'){
                           echo '<li><a href="addroster.php">Add Monthly Roaster</a></li>';
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
<!-- /.row

<!-- notification panel.....................................................................................................-->
  <div class="row">
    <div class="col-lg-3 col-md-6">
      <div class="panel panel-primary">
          <div class="panel-heading">
             <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-comments fa-2x"></i>
               </div>
               <div class="col-xs-9 text-right">
                <?php
                 include('connection.php');
                 $query = mysqli_query($con,"SELECT * from notification_table where notification_for = '".$user."' || emp_id='".$user."'");
                 $count = mysqli_num_rows($query);
                 echo '<div class="huge">'.$count.'</div>';
                 ?>
                 <div>Notifications</div>
               </div>
             </div>
          </div>
         <?php if($count == '0') {
          echo'<a href="javascript:void(0)" onclick="showdialog()">
          <div class="panel-footer">
              <span class="pull-left">View Notification Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div></a>
          ';
          }
          else {
           echo'<a href="notifications.php">
          <div class="panel-footer">
              <span class="pull-left">View Notification Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>';
          }?>
      </div>
    </div>

<?php
  include('connection.php');
  $query = mysqli_query($con,"SELECT * from leave_request_table where submit_to = '".$user."'");
  $request_leave = mysqli_num_rows($query);

  $quer2 = mysqli_query($con," SELECT * from emp_table where employeerole !='admin' and status=1 ");
  $total_employee = mysqli_num_rows($quer2);
  $quer20 = mysqli_query($con,"SELECT * from emp_table where employeerole ='manager'");
  $total_manager = mysqli_num_rows($quer20);
  $query1 = mysqli_query($con,"SELECT * from emp_table where reportedmanagerid = '".$user."'");
  $no_of_employee = mysqli_num_rows($query1);

  date_default_timezone_set("Asia/Kolkata");
    $shift = 'undefined';
    $d=date('d');
    // below if is used for date 1 to 9 and else is used for date is greater than 9 else query is executed
    if($d < 10){
      $d2 = 2*$d-$d;
      $query7 = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".date($d2.'-M-y')."' ");
    }
    else{
      $query7 = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".date('d-M-y')."' ");
    }
    if($query7) {
      while($row = mysqli_fetch_array($query7)){
      $shift = $row[0];
    }
   }
  $query=mysqli_query($con,"select leaves from emp_table where empid='".$user."'");
    while($row=mysqli_fetch_array($query)){
           $leaves=$row['leaves'];
    }
    $total=$leaves;
//<!-- requested leave panel...........................................................................................-->
  if($role != 'employee') {
    echo'<div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
          <div class="panel-heading">
             <div class="row" style="min-height:75px;">
                <div class="col-xs-3">
                   <i class="fa fa-inbox fa-2x"></i>
                </div>
                <div class="col-xs-9 text-right">
                  <div class="huge" style="font-size:27px;">'.$request_leave.'</div>
                  <div >Requested Leaves</div>
                </div>
             </div>
          </div>';
          if($request_leave =='0') {
             echo'<a href="javascript:void(0)" onclick="showdialog()">
            <div class="panel-footer">
              <span class="pull-left">View Leave Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div></a>';
          }
          else {
            echo'<a href="leavedetails.php">
            <div class="panel-footer">
            <span class="pull-left">View Leave Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
            </div></a>';
          }
          echo'
        </div>
    </div>';
  }

// employee panel and monthly shift panel for admin and manager.................................................................................................-->
if($role == 'admin'||$role == 'manager') {
 echo'<div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
          <div class="panel-heading">
              <div class="row" style="min-height:75px;">
                <div class="col-xs-3" style="float:left;">
                   <i class="fa fa-male fa-2x"></i>
                </div>';
                if($role == 'admin') {
                  echo'<div class="col-xs-9 text-right">
                         <div class="huge" style="font-size:16px;float:left;position:absolute;left:5px;">Manager</div>
                         <div class="huge"style="font-size:16px;margin-left:70px;">Employee</div>
                         <div class="huge" style="margin-left:5px;font-size:30px;float:left;">'.$total_manager.'</div>
                         <div class="huge"style="font-size:30px;">'.$total_employee.'</div>
                      </div>';
                }

                if($role == 'manager') {
                  echo'<div class="col-xs-9 text-right">
                        <div class="huge" style="font-size:16px;float:left;position:absolute;left:1px;">Employees <br/>Under</div>
                        <div class="huge"style="font-size:16px;margin-left:64px;">Next Shift</div>
                        <div class="huge" style="font-size:19px;float:left;">'.$no_of_employee.'</div>
                        <div class="huge"style="font-size:19px;margin-left:60px;">'.$shift.'</div>
                      </div>';
                }
          echo'</div>
          </div>';
          if($shift == '---') {
          echo'<a href="javascript:void(0)" onclick="showdialog()">
          <div class="panel-footer">
              <span class="pull-left">View Monthly Shift</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div></a>
          ';
          }
          else {
           echo'<a href="monthlyshift.php">
          <div class="panel-footer">
              <span class="pull-left">View Monthly Shift</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>';
          }
        echo'
     </div>
   </div>';
 }



// available leaves panel...........................................................................................-->
 if($role == 'employee') {
    echo'<div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
          <div class="panel-heading">
            <div class="row" style="min-height:75px;">
              <div class="col-xs-3">
                <i class="fa fa-briefcase fa-2x"></i>
              </div>
              <div class="col-xs-9 text-right">
                 <div class="huge">'.$total.'</div>
                 <div>Available Leaves</div>
              </div>
            </div>
          </div>
          <a href="availableleaves.php">
            <div class="panel-footer">
             <span class="pull-left">View Details</span>
             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
             <div class="clearfix"></div>
            </div>
           </a>
        </div>
     </div>';
  }



//-  tomorrow shift panel for employees...........................................................................................-->
 if($role == 'employee') {
echo'<div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
          <div class="panel-heading">
             <div class="row" style="min-height:75px;">
                <div class="col-xs-3">
                    <i class="fa fa-tasks fa-2x"></i>
                </div>
               <div class="col-xs-9 text-right" style="min-height:77px;">
                  <div class="huge" style="font-size:20px;">'.$shift.'</div>
                  <div>Tomorrow </div>
                </div>
             </div>
          </div>';
          if($shift == '---') {
          echo'<a href="javascript:void(0)" onclick="showdialog()">
          <div class="panel-footer">
              <span class="pull-left">View Monthly Shift</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div></a>
          ';
          }
          else {
           echo'<a href="monthlyshift.php">
          <div class="panel-footer">
              <span class="pull-left">View Monthly Shift</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>';
          }
            echo'
        </div>
     </div>';
  }
?>


<!--in and out panel......................................................................................... -->

<div class="col-lg-3 col-md-6" style="margin-top:2px;">
  <div class="panel panel-red">
  <div class="panel-heading" >
  <div class="row" style="min-height:75px;" >
    <div class="col-xs-3" >
      <i class="fa fa-clock-o fa-spin fa-2x"></i>
    </div>
    <div class="col-xs-9 text-right" >
      <div class="huge" style="font-size:18px;float:left;">IN</div>
      <div class="huge"style="font-size:18px;">OUT</div>
      <div class="huge" style="float:left;font-size:12px;">
        <?php include('connection.php');
          $q2 = mysqli_query($con,"SELECT check_in from emp_checks where emp_id='".$biomatric_id."' and date='".date('Y-m-d')."'");
          while($row=mysqli_fetch_array($q2)) {
            echo $row[0];
          }
        ?>
      </div>
      <div class="huge"style="font-size:12px;margin-left:50px;">
        <?php include('connection.php');
          $q2 = mysqli_query($con,"SELECT check_out from emp_checks where emp_id='".$biomatric_id."' and date='".date('Y-m-d')."'");
          while($row=mysqli_fetch_array($q2)) {
            if($row[0]==''){
                        echo '--';
                      }
                      else{
                        echo $row[0];
                      }
                    }
                  ?>
                </div>
                <div style="font-size:15px;">
                    <?php
                        date_default_timezone_set("Asia/Kolkata");
                        echo date('d-M-y');
                    ?>
                </div>
            </div>
</div>
</div>
    <a href="viewsigninout.php">
        <div class="panel-footer">
            <span class="pull-left">View Attendance</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
    </a>
</div>
</div>

</div>


<div style="margin-top:20px;">
  <hr/>
<!-- calendar view .................................. ..................................................................................-->

<?php
/* Set the default timezone */
include('connection.php');
/* Set the date */
date_default_timezone_set('Asia/Kolkata');
 $date = strtotime(date("Y-m-d"));
 $day = date('d', $date);
$month = date('m', $date);
$year = date('Y', $date);
$firstDay = mktime(0,0,0,$month, 1, $year);
$title = strftime('%B', $firstDay);
$dayOfWeek = date('D', $firstDay);
$daysInMonth = cal_days_in_month(0, $month, $year);
/* Get the name of the week days */
$timestamp = strtotime('next Sunday');
$weekDays = array();
for ($i = 0; $i < 7; $i++) {
    $weekDays[] = strftime('%a', $timestamp);
    $timestamp = strtotime('+1 day', $timestamp);
}
$blank = date('w', strtotime("{$year}-{$month}-01"));
?>

<div class="row" style="background:#eeeeee;border:1px solid #ddd;border-bottom:none;">
  <div class="col-xs-4 date-picker-cols">
    <?php if($role != "employee") {
        echo'<div class="hidden" id="fi_filter_by_choice_button" style="font-weight:bolder;margin-bottom:2px;margin-top:7px;margin-left:30px;font-size:18px;"></div>';
    }
    ?>
  </div>
  <div class="col-xs-2 date-picker-cols">
    <input type="text" class="date-picker-month form-control" id="filtered_date_month" value="<?php echo $title;?>" onchange="filteration_calendar_month();" style="font-weight:bolder;margin-bottom:2px;margin-top:2px;text-align:center;">
  </div>
  <div class="col-xs-2 date-picker-cols">
    <input type="text" class="date-picker-year form-control" id="filtered_date_year" value="<?php echo$year;?>" onchange="filteration_calendar_month();"style="font-weight:bolder;margin-bottom:2px;margin-top:2px;text-align:center;">
  </div>

</div>
<div class="panel panel-default table-responsive">
  <table width="100%" class="table table-bordered table-hover common-table" id="calendar-view">

    <tr>
        <?php foreach($weekDays as $key => $weekDay) : ?>
            <th class="text-center" ><?php echo strtoupper($weekDay); ?></th>
        <?php endforeach ?>
    </tr>
    <tr>
        <?php for($i = 0; $i < $blank; $i++): ?>
            <td valign="middle"></td>
        <?php endfor; ?>
        <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
            <?php if($i == $day): ?>
              <?php include('connection.php');
                $q = mysqli_query($con,"select working_hrs,checks from emp_checks where emp_id='".$biomatric_id."' AND date='".date('Y-m-d')."'");
                 $working_hrs = '';
                 $checks = '';
                 $count = mysqli_num_rows($q);
                 if($count != 0) {
          while($row=mysqli_fetch_array($q)) {
                    if($row['particulars']=='Leave' and $row['remarks'] !=''){
                      echo "<td class='leave_checks '  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>L</span></center></td>";
                    }
                    elseif($row['particulars']=='Leave' and $row['remarks'] ==''){
                      echo "<td class='leave_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>L</span></center></td>";
                    }
                    elseif($row['particulars']=='Absent' and $row['remarks'] !=''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='Absent' and $row['remarks'] ==''){
                      echo "<td class='absent_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='Half Day' and $row['remarks'] !=''){
                      echo "<td class='half_day'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>HD</span></center></td>";
                    }
                    elseif($row['particulars']=='Half Day' and $row['remarks'] ==''){
                      echo "<td class='half_day'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>HD</span></center></td>";
                    }
                    elseif($row['particulars']=='WO' and $row['remarks'] !=''){
                      echo "<td class='weekly_off_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>WO</span></center></td>";
                    }
                    elseif($row['particulars']=='WO' and $row['remarks'] ==''){
                      echo "<td class='weekly_off_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>WO</span></center></td>";
                    }
                    elseif($row['particulars']=='' and $row['remarks'] =='A'){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='' and $row['remarks'] =='P'){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['particulars']=='NA' and $row['remarks'] !=''){
                      echo "<td data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>NA</span></center></td>";
                    }
                    elseif($row['particulars']=='NA' and $row['remarks'] ==''){
                      echo "<td ><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>NA</span></center></td>";
                    }
                    elseif($row['particulars']=='MO' and $row['remarks'] !=''){
                      echo "<td class='monthly_off_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>MO</span></center></td>";
                    }
                    elseif($row['particulars']=='MO' and $row['remarks'] ==''){
                      echo "<td class='monthly_off_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>MO</span></center></td>";
                    }
                    elseif($row['particulars']=='Holiday' and $row['remarks'] !=''){
                      echo "<td class='holiday_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>H</span></center></td>";
                    }
                    elseif($row['particulars']=='Holiday' and $row['remarks'] ==''){
                      echo "<td class='holiday_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>H</span></center></td>";
                    }
                    elseif($row['particulars']=='Present' and $row['remarks'] !=''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['particulars']=='Present' and $row['remarks'] ==''){
                      echo "<td class='absent_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['checks']=='R' and $row['particulars'] ==''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>R</span></center></td>";
                    }
                    elseif($row['checks']=='A' and $row['particulars'] ==''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['checks']=='P' and $row['particulars'] ==''){
                      echo "<td data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>P</span></center></td>";
                    }
                    else{
                      echo "<td><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>".$row['checks']."</span></center></td>";
                    }
          }
        }
                else {
                    echo"<td class='bg-warning'><center style='color:gray;'> ".$i." </center></td>";
                 }
              ?>
            <?php else: ?>

            <?php
              $query = mysqli_query($con,"SELECT * from emp_checks where emp_id='".$biomatric_id."' AND DAY(date)='".$i."'  AND MONTH(date)='".$month."' AND YEAR(date)='".$year."'");
              $count = mysqli_num_rows($query);
              if($count != 0) {
                while($row = mysqli_fetch_array($query)) {
                   if($row['particulars']=='Leave' and $row['remarks'] !=''){
                      echo "<td class='leave_checks '  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>L</span></center></td>";
                    }
                    elseif($row['particulars']=='Leave' and $row['remarks'] ==''){
                      echo "<td class='leave_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>L</span></center></td>";
                    }
                    elseif($row['particulars']=='Absent' and $row['remarks'] !=''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='Absent' and $row['remarks'] ==''){
                      echo "<td class='absent_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='Half Day' and $row['remarks'] !=''){
                      echo "<td class='half_day'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>HD</span></center></td>";
                    }
                    elseif($row['particulars']=='Half Day' and $row['remarks'] ==''){
                      echo "<td class='half_day'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>HD</span></center></td>";
                    }
                    elseif($row['particulars']=='WO' and $row['remarks'] !=''){
                      echo "<td class='weekly_off_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>WO</span></center></td>";
                    }
                    elseif($row['particulars']=='WO' and $row['remarks'] ==''){
                      echo "<td class='weekly_off_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>WO</span></center></td>";
                    }
                    elseif($row['particulars']=='' and $row['remarks'] =='A'){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='' and $row['remarks'] =='P'){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['particulars']=='NA' and $row['remarks'] !=''){
                      echo "<td data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>NA</span></center></td>";
                    }
                    elseif($row['particulars']=='NA' and $row['remarks'] ==''){
                      echo "<td ><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>NA</span></center></td>";
                    }
                    elseif($row['particulars']=='MO' and $row['remarks'] !=''){
                      echo "<td class='monthly_off_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>MO</span></center></td>";
                    }
                    elseif($row['particulars']=='MO' and $row['remarks'] ==''){
                      echo "<td class='monthly_off_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>MO</span></center></td>";
                    }
                    elseif($row['particulars']=='Holiday' and $row['remarks'] !=''){
                      echo "<td class='holiday_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>H</span></center></td>";
                    }
                    elseif($row['particulars']=='Holiday' and $row['remarks'] ==''){
                      echo "<td class='holiday_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>H</span></center></td>";
                    }
                    elseif($row['particulars']=='Present' and $row['remarks'] !=''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['particulars']=='Present' and $row['remarks'] ==''){
                      echo "<td class='absent_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['checks']=='R' and $row['particulars'] ==''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>R</span></center></td>";
                    }
                    elseif($row['checks']=='A' and $row['particulars'] ==''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['checks']=='P' and $row['particulars'] ==''){
                      echo "<td data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>P</span></center></td>";
                    }
                    else{
                      echo "<td><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>".$row['checks']."</span></center></td>";
                    }
                }
              }
              elseif($i <= date('d')) {
                //$query = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$biomatric_id."', '".date('Y-m-'.$i)."','','','0','A','Absent','0')");
                echo  "<td >"."<b style='color:gray;'>".$i."</td>";
              }
              else {
                echo  "<td >"."<b style='color:gray;'>".$i."</td>";
              }
            ?>
            <?php endif; ?>
            <?php if(($i + $blank) % 7 == 0): ?>
                </tr><tr>
            <?php endif; ?>
        <?php endfor; ?>
        <?php for($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
            <td></td>
        <?php endfor; ?>
    </tr>
</table>
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
      // When the document is ready
      $('.example1').datepicker({
          autoclose: true,
          minViewMode: 1,
          format: 'MM yyyy'

      });
      $(function() {
        $('.date-picker-month').datepicker( {
            autoclose: true,
            minViewMode: 1,
            format: 'MM'
            });

      });
     $(function() {
        $('.date-picker-year').datepicker( {
            autoclose: true,
            minViewMode: 2,
            format: 'yyyy'
            });
    });
    </script>

    <script type="text/javascript">
      var role = '<?php echo $role; ?>';
      if(role != 'employee') {
        jQuery('.working_checks').css("display","none");
        jQuery('.working_hrs').css("display","block");
      } else {
        jQuery('.working_hrs').css("display","none");
        jQuery('.working_checks').css("display","block");
      }

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
    function showdialog() {
       mscAlert({title: 'Sorry',subtitle: 'No data available right now.',  // default: ''
        okText: 'Close',    // default: OK
        });
    }

    function showdialogshift() {
        mscAlert({title:'CSV not found',subtitle: 'Please Update Roster.', // default: ''
        okText: 'Close',    // default: OK
        });

      }
    </script>
    <script type="text/javascript">

      $(".myselect").select2();

      });

</script>
</body>

</html>
