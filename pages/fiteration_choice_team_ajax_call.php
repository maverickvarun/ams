<?php session_start();
	$role = $_SESSION['role'];
	$user = $_SESSION['user'];
	include('connection.php');
	if(isset($_REQUEST['choice'])) {
		$choice = $_REQUEST['choice'];
		$query = mysqli_query($con,"SELECT empid from emp_table  where workunderteam = '".$choice."' and empid !='".$user."' ");
		
	}
	if(isset($_REQUEST['choice-shift'])) {
		$choice2 = $_REQUEST['choice-shift'];
		if($role == 'admin') { 
			if($choice == '') {
				$query = mysqli_query($con,"SELECT empid from emp_table  where shift = '".$choice2."' and empid !='".$user."' ");		
			}
			else {
				$query = mysqli_query($con,"SELECT empid from emp_table  where workunderteam ='".$choice."' AND shift = '".$choice2."' and empid !='".$user."' ");	
			}
		}
		else {
			$query = mysqli_query($con,"SELECT empid from emp_table  where shift = '".$choice2."' AND reportedmanagerid = '".$user."' ");
		}
	}
	echo "<option value=''>".$choice." ".$choice2." employee</option>";
	if($query) {
		while($result=mysqli_fetch_array($query)) {
     echo'<option value = "'.$result['empid'].'"> '.$result['empid'].'</option>';
   	} 	
	}

?>