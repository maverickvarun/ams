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
               <li><a href="javascript:;" id="remote_checkin_popup" onclick="div_show_remote_checkin()"><i class="fa fa-desktop fa-fw" ></i>Remote Checkin</a>
               </li>
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
                         echo '<li><a href="remotecheckin.php">Remote Check IN</a></li>';
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
        <h2> Preview Add Employee</h2>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
    <div class="row">
   <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >
    <div class="col-lg-6">
      <div class="panel panel-default">
      <div class="panel-body">
      <fieldset><legend>Personal Details:</legend>
          <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Employee ID</label>
                  <input class="form-control" placeholder="Enter employee id" id="empid" name="empid" value="<?php echo $_POST['empid'];?>">
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Biomatric Id</label>
                  <input class="form-control" type="text"value="<?php echo $_POST['bmi'];?>" id="bmi"  name="bmi" >
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group required">
              <label class="control-label">First Name</label>
                  <input class="form-control" type="text"  id="firstname"  name="firstname" value="<?php echo $_POST['firstname'];?>">
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Last Name</label>
                  <input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo $_POST['last_name'];?>">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Password</label>
                  <input class="form-control" type="text"  id="password"  name="emppassword" value="<?php echo $_POST['emppassword'];?>">
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group required">
              <label class="control-label">Email ID</label>
                <input class="form-control" type="text" value="<?php echo $_POST['emailid'];?>" name="emailid" id="email" >
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Mobile Number</label>
                <input class="form-control" type="text" value="<?php echo $_POST['mobilenumber'];?>" id="mobilenumber"  name="mobilenumber" >
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Emergency Contact No.</label>
                  <input class="form-control" type="text"  value="<?php echo $_POST['ecn'];?>" id="ecn"  name="ecn" >
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Reference Cont No.</label>
                  <input class="form-control" type="text" id="rcn" name="rcn" value="<?php echo $_POST['rcn']; ?>">
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Gender</label>
                <input class="form-control" type="text" name="gender"  value="<?php echo $_POST['gender'];?>" >
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Check IN</label>
                <input class="form-control" type="text" name="flag" value="<?php if($_POST['flag']== 'Remote')
                    { echo $_POST['flag'] ;}else { echo 'manual'; }?>">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Date of Birth</label>
              <input class="form-control" type="text"  name="dateofbirth" value="<?php echo $_POST['date_birth']; ?>">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Blood Group</label>
              <input class="form-control" type="text" id="bloodgroup" name="bloodgroup" value="<?php echo $_POST['bloodgroup']; ?>" >
            </div>
          </div> 
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Date of Joining</label>
               <input class="form-control" type="text"  name="dateofjoining" value="<?php echo $_POST['date_joining']; ?>" >
                
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Parents/Guardians</label>
                  <input class="form-control" type="text" id="parents" name="parents" value="<?php echo $_POST['parents']; ?>" >
            </div>
          </div> 
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Parment Address</label>
              <input class="form-control" type="text"  id="parmentaddress" name="parmentaddress" value="<?php echo $_POST['parmentaddress']; ?>" >
            </div>
          </div> 
          
      </fieldset>         
    </div>
    </div>
  </div> 
  <div class="col-lg-6">
      <div class="panel panel-default">
      <div class="panel-body">
      <fieldset><legend>Personal Details:</legend>
          
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Temporary Address</label>
                <input class="form-control" type="text" id="tempaddress" name="tempaddress"  value="<?php echo $_POST['tempaddress']; ?>">
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group required">
              <label class="control-label">Employee Role</label>
              <input class="form-control" type="text"  id="employeerole" name="employeerole" value="<?php echo $_POST['employeerole']; ?>">
            </div>
          </div>
          <div class="col-lg-6"> 
             <div class="form-group">
              <label class="control-label">Working Team</label>
              <input class="form-control" type="text" id="workingteam" name="workingteam" value="<?php echo $_POST['workingteam']; ?>">
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Shift</label>
              <input class="form-control" type="text"  id="shift" name="shift" value="<?php echo $_POST['shift']; ?>">
            </div>
          </div>
        
          <div class="col-lg-6">
            <div class="form-group ">
              <label class="control-label">Reportee</label>
              <input class="form-control" type="text"  id="rmi" name="rmi" value="<?php echo $_POST['reportee_manager_id']; ?>">
            </div>
          </div> 

           <div class="col-lg-6">
            <div class="form-group ">
              <label class="control-label">Week Off</label>
              <input class="form-control" type="text"  id="rmi" name="firstweekoff" value="<?php echo $_POST['firstweekoff']; ?>">
              </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group ">
              <label class="control-label">Second Week Off</label>
              <input class="form-control" type="text"  id="rmi" name="secondweekoff" value="<?php echo $_POST['secondweekoff']; ?>">
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
            <input class="form-control" type="text" id="nib" name="nib" value="<?php echo $_POST['nib']; ?>">
        </div>
      </div> 
      <div class="col-lg-6"> 
        <div class="form-group">
          <label class="control-label">Bank A/C Details</label>
          <input class="form-control" type="text"  id="bankacdetails" name="bankacdetails" value="<?php echo $_POST['bankacdetails']; ?>">
        </div>
      </div>
      <div class="col-lg-6">  
       <div class="form-group">
        <label class="control-label">Account Type</label>
        <input class="form-control" type="text" id="accounttype" name="accounttype" value="<?php echo $_POST['accounttype']; ?>">
       </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group">
          <label class="control-label">Bank A/C Number</label>
            <input class="form-control" type="text" id="ban"  name="ban" value="<?php echo $_POST['ban']; ?>" >
        </div>
      </div> 
      <div class="col-lg-6"> 
         <div class="form-group">
          <label class="control-label">IFSC Code</label>
            <input class="form-control" type="text" id="ifsc"  name="ifsc" value="<?php echo $_POST['ifsc']; ?>">
        </div>
      </div>
      <div class="col-lg-8">
              <div class="form-group">
                <input type="submit" name="submit_preview" class="btn btn-lg btn-success btn-block" value="Submit">
              </div>
            </div> 
    </fieldset>
    </div>
    </div> 
  </div>     
<!-- /col-lg-6
            below code is for the document details panel of employeee...........
  -->

    
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

<?php
if(isset($_POST['submit'])) {
  $user = $_POST['empid'];
  $j = 0;     // Variable for indexing uploaded image.
  // Declaring Path for uploaded images.
  $target_path = "uploaded_images/";
  if (!file_exists($target_path.$user)) {
    mkdir($target_path.$user, 0777, true);
  }
  for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
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
      $filename = 'matric_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==2) {
      $filename = 'intermediate_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==3){
      $filename = 'graduation_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==4){
      $filename = 'post_graduation_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==5) {
      $filename = 'address_proof_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==6){
      $filename = 'pan_card_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==7){
      $filename = 'experience_snap';
      $name = $filename.'.'.$file_extension;
    }
    if($i==8){
      $filename = 'relv_letter_snap';
      $name = $filename.'.'.$file_extension;
    }
    $target_path = $target_path .$user.'/'. $name;     // Set the target path with a new name of image.
    $j = $j + 1;      // Increment the number of uploaded images according to the files in array.
    if (($_FILES["file"]["size"][$i])     // Approx. 500kb files can be uploaded.
    && in_array($file_extension, $validextensions)) {
      if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
      // If file moved to uploads folder.
      }
      else {     //  If File Was Not Moved.
        echo '<script>mscAlert("'.$j ." - ".' please try again!");</script>';
      }
    }
  }
}
if(isset($_POST['submit_preview'])) {
  include('connection.php');
  $emp_id = $_POST['empid'];
  $pass = $_POST['emppassword'];
   $new_password =base64_encode($pass);
  $query = mysqli_query($con," INSERT INTO emp_table (empid,biomatric_id,firstname,lastname,gender,password,dateofbirth,mobilenumber,emercontactno,emailid,dateofjoining,bloodgroup,parents,permanentaddress,tempaddress,shift,status,flag,employeerole,workunderteam,reportedmanagerid,refecontactno,bankacdetails,bankacnumber,nameinbank,accounttype,ifsccode,leaves) values ('".$_POST['empid']."','".$_POST['bmi']."','".$_POST['firstname']."','".$_POST['last_name']."','".$_POST['gender']."','".$new_password."','".$_POST['dateofbirth']."','".$_POST['mobilenumber']."','".$_POST['ecn']."','".$_POST['emailid']."','".$_POST['dateofjoining']."','".$_POST['bloodgroup']."','".$_POST['parents']."','".$_POST['parmentaddress']."','".$_POST['tempaddress']."','".$_POST['shift']."',1,'".$_POST['flag']."','".$_POST['employeerole']."','".$_POST['workingteam']."','".$_POST['rmi']."','".$_POST['rcn']."','".$_POST['bankacdetails']."','".$_POST['ban']."','".$_POST['nib']."','".$_POST['accounttype']."','".$_POST['ifsc']."',21)");
 // $query1 = mysqli_query($con,"ALTER TABLE monthly_shift_table ADD $emp_id varchar(500) DEFAULT '' ");
   $query2=mysqli_query($con,"INSERT INTO template_roster (emp_id,shift,firstweekoff,secondweekoff) values('".$_POST['empid']."','".$_POST['shift']."','".$_POST['firstweekoff']."','".$_POST['secondweekoff']."')");
    $query3 = mysqli_query($con,"ALTER TABLE template_roster ADD $emp_id varchar(500) DEFAULT '' ");
  if($query) {
    echo '<script type="text/javascript" >alert("success");
         window.location = "http://localhost/ams/pages/addemployee.php";
      </script>';    
  }

}
?>