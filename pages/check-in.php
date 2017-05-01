<?php session_start();
$user = $_SESSION['user'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$biomatric_id = $_SESSION['biomatric_id'];
include('connection.php');
$text1 = $_REQUEST['name'];
date_default_timezone_set('Asia/Kolkata');
$d=date('d');
if($d < 10){
  $d2 = 2*$d-$d;
  $combine_date = date($d2.'-M-y');
}
else{
  $combine_date = date('d-M-y');
}
 $q = mysqli_query($con,"SELECT * FROM `emp_checks` WHERE emp_id='".$biomatric_id."' and date='".date('Y-m-d')."' ");
  $count = mysqli_num_rows($q);
  //if block is used for sign out 
  if($count !=0) {
    $query = mysqli_query($con,"UPDATE emp_checks SET check_out = '".date('g:i a')."' , status = '0' WHERE emp_id = '".$biomatric_id."' AND date = '".date('Y-m-d')."'");
    $query1 = mysqli_query($con,"SELECT check_in,check_out,remarks from emp_checks WHERE emp_id = '".$biomatric_id."' AND date = '".date('Y-m-d')."' ");
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
    $query1 = mysqli_query($con,"SELECT ".$user." from monthly_shift_table where date = '".$combine_date."'");
    $count = mysqli_num_rows($query1);
    if($count !=0){
      while($row=mysqli_fetch_array($query1)) {
        $text = $row[0];
      }  
      if($text == 'Holiday' || $text == 'holiday') {
        // below query update the working_hrs in emp_checks table on current date of employee......
        $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."' WHERE emp_id = '".$biomatric_id."' AND date = '".date('Y-m-d')."'");
      }
      else {
        $query8 = mysqli_query($con,"SELECT end_time from shift_table where shift_name = '".$text."' ");
        while($res=mysqli_fetch_array($query8)) {
          $end_time = $res[0];
        }
        $expire_end_time = date('H:i:s', strtotime($end_time."-15 min"));
        $expire_end_time = strtotime($expire_end_time);
        $current_time = date("H:i:s ");//9
        $current_time = strtotime($current_time);
        $diff = $expire_end_time - $current_time;
        $minutes   = round($diff / 60);
        $qur2 = mysqli_query($con,"SELECT reportedmanagerid from emp_table where empid = '".$user."' ");
        while($row = mysqli_fetch_array($qur2)) {
          $reportedmanagerid = $row['reportedmanagerid'];
        }
        if( $current_time < $expire_end_time ) {
          $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."', remarks = '".$remarks.",Early Going' WHERE emp_id = '".$biomatric_id."' AND date = '".date('Y-m-d')."'");
          $quer = mysqli_query($con,"INSERT INTO notification_table(n_date,emp_id,description,notification_for) VALUES('".date('Y-m-d')."','".$user."','".$firstname." "." ".$lastname." ".$minutes.""." minutes early going','".$reportedmanagerid."')");
        }
        else {
           $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."',remarks = '".$remarks.",Late Going' WHERE emp_id = '".$biomatric_id."' AND date = '".date('Y-m-d')."'");
        }
      }
    }
    else{
      $query = mysqli_query($con,"UPDATE emp_checks SET working_hrs = '".$d."',remarks = '' WHERE emp_id = '".$biomatric_id."' AND date = '".date('Y-m-d')."'");
    }  
  }
  $_SESSION['last_swipe'] = 'Last Swipe';
  echo  $_SESSION['check_in_out'] = 'Sign In';
}
//else block is used for sign in 
else {
    $query = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date,   check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$biomatric_id."', '".date('Y-m-d')."', '".date('g:i a ')."','','','P','','1')");
    $query1 = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".$combine_date."' ");
    $count = mysqli_num_rows($query1);
    if($count !=0){
      while($row = mysqli_fetch_array($query1)) {
      $text = $row[0];
      if($text == 'Holiday' || $text == 'holiday') {
        // $query4 = mysqli_query($con,"UPDATE monthly_shift_table set ".$user." = 'holiday-working' where date = '".date('d-m-Y')."' ");
        $query = mysqli_query($con,"UPDATE emp_checks set remarks='holiday-working' where emp_id='".$biomatric_id."' and date='".date('Y-m-d')."'");
        // $query = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$biomatric_id."', '".date('Y-m-d')."', '".date('g:i a ')."','','','P','holiday-working','1')");
      }
      else {
        // below query is used to fetch the start time of shift for checking the range of check in time of employe.......      
        $query8 = mysqli_query($con,"SELECT start_time from shift_table where shift_name = '".$text."' ");
        while($res=mysqli_fetch_array($query8)) {
          $start_time = $res[0];
        }
        $expire_time = date('H:i:s', strtotime($start_time."+15 min"));
        $expire_time = strtotime($expire_time);
        $current_time = date("H:i:s ");//9
        $current_time = strtotime($current_time);
        $diff = $expire_time - $current_time;
        $minutes   = round($diff / 60);
        $qur2 = mysqli_query($con,"SELECT reportedmanagerid from emp_table where empid = '".$user."' ");
        while($row = mysqli_fetch_array($qur2)) {
          $reportedmanagerid = $row['reportedmanagerid'];
        }
        if($current_time > $expire_time) {
          $query = mysqli_query($con,"UPDATE emp_checks set remarks='Late Coming' where emp_id='".$biomatric_id."' and date='".date('Y-m-d')."'");
          // $query=mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$biomatric_id."', '".date('Y-m-d')."', '".date('g:i a ')."','','','P','Late Coming','1')");
          $quer = mysqli_query($con,"INSERT INTO notification_table(n_date,emp_id,description,notification_for) VALUES('".date('Y-m-d')."','".$user."','".$firstname." "." ".$lastname." ".$minutes.""." minutes late','".$reportedmanagerid."')");
        }
        else {
          $query = mysqli_query($con,"UPDATE emp_checks set remarks='Good' where emp_id='".$biomatric_id."' and date='".date('Y-m-d')."'");
          // $query = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$biomatric_id."', '".date('Y-m-d')."', '".date('g:i a ')."','','','P','Good','1')");
        }
        // this query is used to insert the current check_in time of the employee in emp_checks table and also tick present.
      }
    }
  }
 
  $_SESSION['last_swipe'] = 'Latest Sign In';
  echo $_SESSION['check_in_out'] = 'Sign Out';

  }



?>