<?php
include('connection.php');
	$year = '2017';
    $month = '03';
    // for($i=13;$i<=13;$i++) {
    //         //generate date
    //     $date = $i.'-'.$month.'-'.$year;
    //      $converted_date = date("Y-m-d", strtotime($date));
        
    //      // $query = mysqli_query($con,"INSERT into emp_checks(emp_id,date,check_in,check_out,working_hrs,checks,particulars,remarks) VALUES('48','".$converted_date."','','','','P','Present','')");
    //      // if($query){
    //      // 	echo 'done';
    //      // }
    //  }
     // $query = mysqli_query($con,"SELECT * FROM `emp_checks` WHERE `date`='2017-03-13'");
     //     while($row = mysqli_fetch_array($query)){
     //        echo '</br>'.$row['emp_id'].'---'.$row['checks'];
     //        if($row['checks']=='A'){
     //            echo '</br>'.'updated query fired';
     //             mysqli_query($con,"UPDATE emp_checks set checks = 'H',remarks='Holi Festival Holiday',particulars='Holiday',status='0' where date = '2017-03-13' and emp_id='".$row['emp_id']."' ");
     //        }
     //     }
?>