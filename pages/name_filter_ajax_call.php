<?php session_start();
	$role = $_SESSION['role'];
	$user = $_SESSION['user'];
	include('connection.php');
	$query = mysqli_query($con,"SELECT firstname,lastname,empid,status from emp_table ");
	echo "<option value=''>-employee name-</option>";
	if($query) {
	 	while($result1=mysqli_fetch_array($query)) {
	 		$fname=$result1['firstname'];
	 		$lname=$result1['lastname'];
	 		$status=$result1['status'];
	    
	 		$query2 = mysqli_query($con,"SELECT firstname,lastname,empid from emp_table where firstname='".$fname."'and lastname='".$lname."'");
	     	$count = mysqli_num_rows($query2);
	 		if($count>1) {
	 			echo'<option value ="'.$result1['empid'].'" >'.$result1['firstname'].' '.$result1['lastname'].' ('.$result1['empid'].')</option>';	
	 		}	
	 		else {
	 			echo'<option value ="'.$result1['empid'].'" >'.$result1['firstname'].' '.$result1['lastname'].'</option>';
	 		}
	 	  
		}
	}
?>