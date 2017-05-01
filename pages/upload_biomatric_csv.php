<?php 
  include('connection.php');
  $query = mysqli_query($con,"SELECT Emp_id,Date,Time from csv_table "); 
  while($result = mysqli_fetch_array($query)) { 
    $converted_date = date("Y-m-d", strtotime($result[1]));
    $yesterday = date('Y-m-d',strtotime("-1 day",strtotime($converted_date)));
    $query5 = mysqli_query($con,"SELECT emp_id,date,check_in,check_out,status from emp_checks where emp_id = '".$result[0]."' and date ='".$yesterday."' ");
    $count = mysqli_num_rows($query5);
    if($count !='0') {
      while($row = mysqli_fetch_array($query5)) {
        if($row['status']==1){
          // below code is used to calculate the working hours of employee
          $checkTime = strtotime($row[2]);
          $newtimestamp = strtotime("+19 hours", $checkTime);
          $checkout = strtotime($result[2]);
          $diff = $checkTime - $checkout;
          $init = abs($diff);
          $hours = floor($init / 3600);
          $minutes = floor(($init / 60) % 60);
          $seconds = $init % 60;
          $d = $hours.':'.$minutes.':'.$seconds;
          if($checkout<$newtimestamp) {
            mysqli_query($con,"UPDATE emp_checks set check_out = '".$result[2]."', working_hrs ='".$d."',status='0' where date = '".$converted_date."' and emp_id='".$result[0]."' ");
          }
          else {
            echo $tomorrow = date('Y-m-d',strtotime("+1 day", strtotime($converted_date)));
            echo 'entry is greater than 16 hours'.'</br>';
          }
        }
      } 
      // end of while 
    }
    else{
      mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$result[0]."', '".$converted_date."', '".$result[2]."','','','P','','1')");
    }
  }
?>