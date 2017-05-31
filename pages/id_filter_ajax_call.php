<?php session_start();
	$role = $_SESSION['role'];
	$user = $_SESSION['user'];
	include('connection.php');
	// below code is used for role wise filteration but not until used
	// if($role =='admin') {
 //    $query = mysqli_query($con,"SELECT empid from emp_table where empid != '".$user."'");
	// }
 //  else {
 //    $query = mysqli_query($con,"SELECT empid from emp_table where reportedmanagerid = '".$user."'");
 //  }
	 $query = mysqli_query($con,"SELECT empid,workunderteam,status from emp_table ");
	echo "<option value=''>-employee id-</option>";
	if($query) {
		while($result=mysqli_fetch_array($query)) {
			$team = $result['workunderteam'];
			$empid=$result['empid'];
			$status=$result['status'];
			$firstchr=$empid[0];
			$team_length = strlen($team);
			//$team_length = $team_length -1;
			
		if($status==1){
			
              
               	 echo '<option value="'.$result['empid'].'">'.$result['empid'].'</option>';
             
        }
        else{
        	$newid=$result['empid'];
        	$newid[0]='Z';
        	  echo '<option value="'.$result['empid'].'">'.$newid.'</option>';
        }   
    }	
	}

?>