<?php
include('connection.php');
	$year = '2017';
    $month = '03';
    for($i=1;$i<=31;$i++) {
            //generate date
        $date = $i.'-'.$month.'-'.$year;
         echo'</br>'.$converted_date = date("Y-m-d", strtotime($date));
         //$query = mysqli_query($con,'DELETE FROM `emp_checks` WHERE emp_id="51" and date="'.$converted_date.'"');
         if($query){
         	echo 'done';
         }
     }

?>