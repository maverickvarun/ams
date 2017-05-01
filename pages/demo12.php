<?php
include('connection.php');
	// $query = mysqli_query($con,"SELECT * FROM `csv_table` WHERE `Employee Code`='15'");
 //        while($result = mysqli_fetch_array($query)){
 //            $converted_date = date("Y-m-d", strtotime($result[2]));
 //            $check_in = $result[3];
 //              $check_out = $result[4];
 //              $checkTime = strtotime($result[3]);
 //              $checkout = strtotime($result[4]);
 //              $diff = $checkTime - $checkout;
 //              $init = abs($diff);
 //              $hours = floor($init / 3600);
 //              $minutes = floor(($init / 60) % 60);
 //              $seconds = $init % 60;
 //              $d = $hours.':'.$minutes.':'.$seconds;
 //              if($check_in=='00:00' and $check_out=='00:00') {
 //                mysqli_query($con,"INSERT INTO  emp_checks(emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$result[1]."', '".$converted_date."', '','','','A','Absent','0')");
 //              }
 //              elseif($check_in==$check_out){
 //                mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$result[1]."', '".$converted_date."', '".$result[3]."','','','P','','1')");
 //              }
 //              elseif($check_in!=$check_out){
 //                mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$result[1]."', '".$converted_date."', '".$result[3]."','".$result['4']."','".$d."','P','','0')");
 //              }
         
 //         }

?>