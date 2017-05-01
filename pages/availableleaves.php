<?php session_start();
  include('checksession.php');
  include('popupform.php');
  $role = $_SESSION['role'];
$user = $_SESSION['user'];
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
               <li><a href="#"><i class="fa fa-male fa-fw"></i>Employee<span class="fa arrow"></span></a>
                 <ul class="nav nav-second-level">
                         <?php if ($role=='admin'){
                                       echo '<li><a href="addemployee.php">Add Employee</a></li>';
                                       echo '<li><a href="modifyemployee.php">Modify Employee</a></li>';
                                   }
                         ?>
                  <li class="active"><a href="viewsigninout.php" >View Attendance</a></li>
                     
                     <?php if($role!="employee"){ 
                         echo '<li><a href="viewemployeedetails.php">View Employee Details</a></li>';
                        
                       }
                     ?>
                  </ul>
               </li>

               <li class="active">
                  <a href="#"><i class="fa fa-briefcase fa-fw"></i>Leave<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                   <?php if($role != "admin"){
                     echo '<li><a href="javascript:;" onclick="div_leave_request_show();">Leave Request</a></li>';
                      } 
                        if($role != "employee") {
                         echo'<li><a href="leavedetails.php">Leave Details</a></li>';
                        } 
                     ?>
                    <li class="active"><a href="availableleaves.php">Available Leaves</a>
                      <ul class="nav nav-second-level">
                     <li>
                        <div class="col-lg-12 "> 
                           <div class="form-group">
                              <label>By date</label>
                              <div class="radio">
                                  <label>
                                    <input type="radio" name="date" id="single_date" value="single date">Single Date
                                  </label>
                              </div>
                              <div class="radio">
                                  <label>
                                    <input type="radio" name="date" id="multiple_dates" value="multiple dates">Multiple Dates
                                  </label>
                              </div>
                           </div> 
                        </div>
                      <div class="col-sm-12 hidden filter_top" id="li_one_date_filter">
                        <input type="date" placeholder=" Single date" class="example1 form-control input-sm " id="onedate" onchange="filtration_leavehistory();">
                      </div>
                      <div class="col-sm-12 filter_top hidden" id="li_from_date_filter">
                      <input type="date" placeholder="From Date" class="example1 form-control input-sm" id="fromdate" onchange="filtration_leavehistory();">
                      </div>
                      <div class="col-sm-12 filter_top hidden " id="li_to_date_filter">
                      <input  type="date" placeholder="To Date"  class="example1 form-control input-sm" id="todate" onchange="filtration_leavehistory();">
                     </div>
                     </li>
                     
                 <?php if($role != "employee") { 
                echo'<li><div class="col-lg-12 filter_top"> 
                      <div class="form-group">
                      <label>View Others</label>
                        <div class="radio">
                          <label>
                            <input type="radio" name="choice_filter" id="shift_filter" value="shift">Shift
                          </label>
                        </div>';
                        if($role =='admin') {
                          echo'<div class="radio">
                           <label>
                             <input type="radio" name="choice_filter" id="team_filter" value="team">Team
                            </label>
                          </div>';
                        }
                        echo'<div class="radio">
                          <label>
                            <input type="radio" name="choice_filter" id="id_filter" value="employee">Employee Id
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="choice_filter" id="name_filter" value="name">Employee Name
                          </label>
                        </div>
                      </div> 
                    </div>

                    <div class="col-sm-12 filter_bottom hidden" id="li_filter_by_shift">
                      <select class="form-control input-sm myselect" style="width:100%;" id="filter_by_shift">
                        <option value="">-filter by shift-</option>';
                       $query = mysqli_query($con,"SELECT DISTINCT shift from emp_table where employeerole != 'admin'");
                      while($result=mysqli_fetch_array($query)) {
                        echo'<option value="'.$result['shift'].'">'.$result['shift'].'</option>';
                      } 
                      echo'</select></div>
                      <div class="col-sm-12 filter_bottom hidden" id="li_filter_by_team">
                      <select class = "form-control input-sm myselect" style="width:100%;"  id="filter_by_team" >
                      <option value="">-filter by team-</option>';
                      $query = mysqli_query($con,"SELECT DISTINCT workunderteam from emp_table where employeerole != 'admin' ");
                      while($result = mysqli_fetch_array($query)) {
                        echo '<option value="'.$result["workunderteam"].'">'. $result["workunderteam"].'</option>';
                      }
                    echo '</select></div>
                    <div class="col-sm-12 filter_bottom hidden" id="li_filter_by_choice_team">
                      <select class = "form-control input-sm myselect" style="width:100%;" id="filter_by_choice_team" name="filter_by_choice_team" onchange="filtration_leavehistory();">
                      </select>
                    </div></li>';
                }
              ?>
                </ul> </li>
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
      <div class="col-lg-4"> <h2 >Available Leaves </h2></div>
      <div class="col-lg-4">  
        <h6><a href="availableleaves.php"><i class="fa fa-calendar" ></i></a> <?php echo $title."-".$year;?></h6>
      </div>
      <div class="col-lg-4">
      <a href="pdf/actionpdf.php" class="pdfbutton"><input type="button" value=" Download as PDF"></a>
      </div>
    </div>
<!-- /.row -->
<!-- code of filteration block of this page started here ......................................-->
 <div class="row">
  <div class="col-lg-12">
    <div class="panel ">
      
        <div class="row">
          <div class="col-sm-4 hidden" id="fi_onedate"></div>
          <div class="col-sm-4 hidden" id="fi_fromdate"></div>
          <div class="col-sm-4 hidden" id="fi_todate"></div>
          <?php if($role != "employee") { 
              echo'<div class="col-sm-3 hidden" id="fi_filter_by_choice_button"></div>';
            }
          ?>
        </div>
      
    </div>
  </div>
</div>

<!-- filtration block of leave history is closed here............................-->
 <!-- panel default and panel heading div and filtration block also is closed here........................................-->  

<!-- fetching the available leaves from the database............................................--> 
             
<?php 
  include('connection.php');
  $query = mysqli_query($con,"select leaves from emp_table where empid='".$user."'" );
  echo'<div class="row"><div class="col-lg-12"><div class="panel panel-default">
      <table width="100%" class="table table-striped table-bordered table-hover common-table" id="balance_leave">
      <tbody>
    <tr><td>Leave</td></tr>';

  while($row=mysqli_fetch_row($query)) {
        print "<tr> <td>"; echo $row[0];
        print "</td>";
  }
  echo'</tbody></table>';
  if($role=='admin'){
    echo '<div>
          <form method="post" name="adjust_leave_form" id="adjust_leave_form">
            <input type="button" class="btn" value="Adjust Leave" id="adjust_leave"/>
            <input type="hidden" class="form-control" id="adjust_leave_empid" name="adjust_leave_empid" value="'.$user.'">
            <input type="text" class="form-control hidden" id="input_adjust_leave" name="input_adjust_leave"/>
            <input type="submit" value="Submit" id="submit_adjust_leave"class="btn hidden" name="submit_adjust_leave">
          </form>
        </div>';
  }
  echo'</div></div></div>';
?>

 <?php 
    include('connection.php');
    $query = mysqli_query($con,"select * from leave_history_table where empid='".$user."' ");
    echo'<div class="row"><div class="col-lg-12"><div class="panel ">
      <div class="panel-body">
      <caption align="top"><label>Leaves History</label></caption>
      <table width="100%" class="table table-striped table-bordered table-hover common-table" id="tableleavehistory">
      <tbody>';
      $_SESSION['pdf'] = '';
      $_SESSION['pdf'] .= '<tr><td>Submission Date</td><td>From </td><td>To</td>
        <td>Type</td> <td>Description</td>
        <td>Status</td> <td>Approved By</td>
      </tr>';
      while($row = mysqli_fetch_row($query)) {
        $_SESSION['pdf'] .= "<tr> <td>".$row[3]."</td> <td>".$row[4]."</td> <td>".$row[5]."</td> <td>".$row[6]."</td> <td>".$row[7]."</td> <td>".$row[8]."</td> <td>".$row[9]."</td>";
      }
      echo $_SESSION['pdf'];
      echo'</tbody></table></div></div></div></div>';
  ?>
  <div class="validate_check_roles" style="display:none";><?php echo $_SESSION["role"]; ?></div>

</div>
</div>
<!-- /#wrapper -->

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
        mscAlert({title: 'Sorry',subtitle: 'Shift not yet updated.',  // default: ''
        okText: 'Close',    // default: OK
        });

      }


    $('#adjust_leave').click(function(){
      $('#input_adjust_leave').removeClass('hidden').addClass('visible');
      $('#submit_adjust_leave').removeClass('hidden').addClass('visible'); 
    });

    $('#filter_by_choice_team').change(function () {
      var selectedText = document.getElementById('filter_by_choice_team').value;
      document.getElementById('adjust_leave_empid').value =selectedText;
    });
    </script>

</body>

</html>

<?php
if(isset($_POST['submit_adjust_leave'])){
  $value = $_POST['input_adjust_leave'];
  $value2 =$_POST['adjust_leave_empid'];
  if($value =='') {
     echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Please fill up the leave`.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
  }
  else { 
    $query2 = mysqli_query($con," UPDATE emp_table SET leaves ='".$value."' where empid='".$value2."'");
    if($query2) { 
      echo"<script type='text/javascript'>
        mscConfirm({ title: 'Available leaves are changed',
        okText: 'I Agree',    // default: OK
        cancelText: 'I Dont', // default: Cancel,
        dismissOverlay: true, // default: false, closes dialog box when clicked on overlay.
        onOk: function() {
          mscAlert('Awesome.');
          location.href = window.location.href;
        },
        onCancel: function() {
          mscAlert('Sad face :( .');
        }
      });
      </script>";
    }
    else {
      echo"<script type='text/javascript'>
        mscAlert({title: 'Sorry',subtitle: 'Fialed to Change the leaves.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
    }
  }
}

?>