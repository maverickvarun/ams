<?php session_start();
	$shift_change = $_REQUEST['shift_change'];
	include('connection.php');
	 $query = mysqli_query($con,"SELECT start_time from shift_table where shift_name = '".$shift_change."' ");
	if($query) {
		while($result=mysqli_fetch_array($query)) {
      		echo date("g:i A", strtotime($result['start_time']));
    	}	
	}

?>