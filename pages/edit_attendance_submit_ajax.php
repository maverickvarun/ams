<?php
date_default_timezone_set('Asia/Kolkata'); 
    include('connection.php');
    $emp_id = $_REQUEST['emp_id'];
	 $user_one =  $_REQUEST['edit_attendance_id'];
    $action = $_REQUEST['edit_checkin'];
    $time = $_POST['edit_time'];
    $remarks =$_POST['edit_remarks'];
    if($time == "") {
      $time = date('g:i A ');
    }
    if($action == "check_in") {
      $query = mysqli_query($con,"UPDATE emp_checks SET check_in = '".$time."',particulars='',remarks='".$remarks."',status = '1',checks='P' WHERE id = '".$user_one."'");
        if($query) {
            echo"<script type='text/javascript'>
          mscAlert({title: 'Done',subtitle: 'check in is done.',  // default: ''
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
           $query2 = mysqli_query($con,"UPDATE emp_checks SET check_out = '".$time."' , status = '0',remarks ='".$remarks."',particulars='' WHERE id = '".$user_one."'");
           $query1 = mysqli_query($con,"SELECT check_in,check_out,remarks from emp_checks WHERE id = '".$user_one."' ");
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
              $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."' WHERE id = '".$user_one."' ");
            }
            if($query) {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Done',subtitle: 'check out is done.',  // default: ''
                okText: 'Close',    // default: OK
                });</script>";
              }
              else {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Sorry',subtitle: 'Failed to check out.',  // default: ''
                  okText: 'Close',    // default: OK
                });</script>";
              }
        }
        elseif($action=='NA'){
          $query3 = mysqli_query($con,"UPDATE emp_checks SET remarks = '".$remarks."' , status = '0',checks='NA',particulars='".$action."' WHERE id = '".$user_one."'");
          if(mysqli_affected_rows($con)>0) {
                echo"<script type='text/javascript'>
                  mscAlert({title: 'Done',subtitle: '',  // default: ''
                okText: 'Close',    // default: OK
                });</script>";
              }
          else{
              echo"<script type='text/javascript'>
                  mscAlert({title: 'Sorry',subtitle: 'Failed to excute action because no entry available on selected date or same data is copied',  // default: ''
                  okText: 'Close',    // default: OK
                });</script>";
              }
        }
        elseif($action=='WO'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0',checks='WO',remarks = '".$remarks."' WHERE id = '".$user_one."' ");
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
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0',checks='H',remarks ='".$remarks."' WHERE id = '".$user_one."' ");
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
        elseif($action=='Leave'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars= '".$action."' , status = '0',checks='L',remarks='".$remarks."' WHERE id = '".$user_one."'");
            if(mysqli_affected_rows($con)>0) {
                $query1 = mysqli_query($con,"select leaves from emp_table where biomatric_id='".$emp_id."'");
                while($row = mysqli_fetch_array($query1)){
                  $l = $row['leaves'];
                  $d = $l-'1';
                  mysqli_query($con," UPDATE emp_table SET leaves ='".$d."' where biomatric_id='".$emp_id."'");
                }
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
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0',checks='HD',remarks ='".$remarks."' WHERE id = '".$user_one."' ");
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
        elseif($action=='Present'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0',checks='P',remarks ='".$remarks."',check_in='10:00 AM',check_out='6:00 PM' WHERE id = '".$user_one."' ");
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
        elseif($action=='Remarks'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET checks='R',remarks ='".$remarks."' WHERE id = '".$user_one."' ");
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
        elseif($action=='MO'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' ,status= '0',checks='MO',remarks = '".$remarks."' WHERE id = '".$user_one."' ");
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
         elseif($action=='Absent'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0',checks='A',remarks = '".$remarks."' WHERE id = '".$user_one."' ");
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
         elseif($action=='Comp Off'){
          $query2 = mysqli_query($con,"UPDATE emp_checks SET particulars = '".$action."' , status = '0',checks='CO',remarks = '".$remarks."' WHERE id = '".$user_one."' ");
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

        echo 'done';
?>