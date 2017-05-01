<?php session_start();
	$role = $_SESSION['role'];
	$user = $_SESSION['user'];
	include('connection.php');
	// below code is used for role wise filteration but not until used
	// if($role =='admin') {
	 //    $query = mysqli_query($con,"SELECT firstname,lastname,empid from emp_table where empid !='".$user."'");
	 //  }
	 //  else {
	 //    $query = mysqli_query($con,"SELECT firstname, lastname ,empid from emp_table where reportedmanagerid = '".$user."' or employeerole=='manager'");  
	 //  }
	$query = mysqli_query($con,"SELECT firstname,lastname,empid from emp_table where empid !='".$user."' and employeerole !='admin'");
	echo "<option value=''>-employee name-</option>";
	if($query) {
		while($result = mysqli_fetch_array($query)) {
      		echo'<option value ="'.$result['empid'].'" >'.$result['firstname'].' '.$result['lastname'].'</option>';
    	}	
	}

?>