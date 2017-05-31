<?php 
include('connection.php');
date_default_timezone_set('America/Los_Angeles');

$year = '17';
$month = '3';
$year1 = date_create_from_format('y', $year);
$changed_year = $year1->format('Y') ; 
$changed_month= date('m',strtotime($month.'-'.$changed_year));
$loop=cal_days_in_month(CAL_GREGORIAN,$changed_month,$changed_year);
for($i=1;$i<=$loop;$i++) {
//generate date
   if($i<10){
    echo"<br>".  $date = $month.'/'.$i.'/'.$changed_year;  
   }else{
     echo"<br>".$date = $month.'/'.$i.'/'.$changed_year;  
   }
   


 $query1 = mysqli_query($con,"SELECT * FROM `csv_table` WHERE `Employee Code`='3' and `AttendanceDate`= '".$date."'");
 $count = mysqli_num_rows($query1);
 if($count!=0){
   while($result = mysqli_fetch_array($query1)){
       $query = mysqli_query($con,"SELECT * FROM `emp_table` where biomatric_id='3'");
          while($employee = mysqli_fetch_array($query)){
            $Emp_id = $employee['biomatric_id'];
            $workunderteam = $employee['workunderteam'];
           }
        // below code for sale team employee
         if($workunderteam=='Chat'){
             // below code is used to calculate the working hours of employee
               $converted_date = date("Y-m-d", strtotime($result[2]));
               $prev_date = date('Y-m-d', strtotime($converted_date .' -1 day'));
               $check_in = $result[3];
               $check_out = $result[4];
              if($check_in=='00:00' and $check_out=='00:00') {
                 mysqli_query($con,"INSERT INTO  emp_checks(emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$result[1]."', '".$converted_date."', '','','','A','Absent','0')");
               }
               else{

                  $query6 = mysqli_query($con,"SELECT * from emp_checks where emp_id = '3' and date ='".$prev_date."'");
                  $count2 = mysqli_num_rows($query6);
                  if($count2!='0'){
                  while($prev_result=mysqli_fetch_array($query6)) {
                      if($prev_result['check_in']=='' && $prev_result['check_out']==''){
                           $query12 = mysqli_query($con,"SELECT * from emp_checks where emp_id='3' and date='".$converted_date."'");
                           $count5 = mysqli_num_rows($query12);
                            if($count5=='0'){
                             mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,particulars,remarks,status) VALUES ('".$result[1]."', '".$converted_date."','".$result[3]."','".$result[4]."','','P','','present','1')");    
                            }
                            else{
                              while($result12 = mysqli_fetch_array($query12)){
                                 $prev_checkTime = strtotime($result12['check_in']);
                                 echo "control in update";
                                   //$time=date("Y-m-d h:i:s A T", $prev_checkTime);
                                   //$prev_newtimestamp = strtotime("+19 hours", $prev_checkTime);
                                   //$time2=date("Y-m-d h:i:s A T", $prev_newtimestamp);
                                   //$prev_checkout = strtotime($prev_check_join_date);
                                   //$new_checkout =  $result['Date'].' '.$result['Time'];
                                   $new_checkout = strtotime($result[4]);
                                   $diff = $prev_checkTime - $new_checkout;
                                   $init = abs($diff);
                                   $hours = floor($init / 3600);
                                   $minutes = floor(($init / 60) % 60);
                                   $seconds = $init % 60;
                                   $d = $hours.':'.$minutes.':'.$seconds;
                                   mysqli_query($con,"UPDATE emp_checks set check_out = '".$result[4]."', working_hrs ='".$d."',status='0' where date = '".$converted_date."' and emp_id='".$result[0]."' ");  
                                }
                           }
                    }else{
                      echo "control in update";
                      $prev_check_join_date = $prev_result['date'].' '.$prev_result['check_in'];
                      $prev_checkTime = strtotime($prev_check_join_date);
                      //$time=date("Y-m-d h:i:s A T", $prev_checkTime);
                      echo"<br/>".$prev_newtimestamp = strtotime("+19 hours", $prev_checkTime);
                      //$time2=date("Y-m-d h:i:s A T", $prev_newtimestamp);
                      //$prev_checkout = strtotime($prev_check_join_date);
                      $new_checkout =  $result['AttendanceDate'].' '.$result[4];
                     echo"<br/>". $new_checkout = strtotime($new_checkout);
                     
                      $diff = $prev_checkTime - $new_checkout;
                      $init = abs($diff);
                      $hours = floor($init / 3600);
                      $minutes = floor(($init / 60) % 60);
                      $seconds = $init % 60;
                      $d = $hours.':'.$minutes.':'.$seconds;
                      if($new_checkout<$prev_newtimestamp){
                          mysqli_query($con,"UPDATE emp_checks set check_out = '".$result['OutTime']."', working_hrs ='".$d."',status='0' where date = '".$prev_date."' and emp_id='".$result['Emp_id']."' ");
                           }else{
                             $query11=mysqli_query($con,"select * from emp_checks where emp_id='3' and date='".$converted_date."'");
                             $count4=mysqli_num_rows($query11);
                             if($count4==0){
                                 mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,particulars,remarks,status) VALUES ('".$result[1]."', '".$converted_date."','".$result[3]."','".$result[4]."','','P','','present','1')"); 
                              }else{
                                echo "control in update";
                                 while($result11 = mysqli_fetch_array($query11)){
                                   $prev_checkTime = strtotime($result11['check_in']);
                                   //$time=date("Y-m-d h:i:s A T", $prev_checkTime);
                                   //$prev_newtimestamp = strtotime("+19 hours", $prev_checkTime);
                                   //$time2=date("Y-m-d h:i:s A T", $prev_newtimestamp);
                                   //$prev_checkout = strtotime($prev_check_join_date);
                                   //$new_checkout =  $result['Date'].' '.$result['Time'];
                                   $new_checkout = strtotime($result[4]);
                                   $diff = $prev_checkTime - $new_checkout;
                                   $init = abs($diff);
                                   $hours = floor($init / 3600);
                                   $minutes = floor(($init / 60) % 60);
                                   $seconds = $init % 60;
                                   $d = $hours.':'.$minutes.':'.$seconds;
                                   mysqli_query($con,"UPDATE emp_checks set check_out = '".$result[4]."', working_hrs ='".$d."',status='0' where date = '".$converted_date."' and emp_id='".$result[1]."' ");  
                                }
                              } 
                           } 
                     }
                  }
              }
           }  
        }
     }
   }
 }
?>