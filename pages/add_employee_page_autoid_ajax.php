<?php
session_start();
	$role = $_SESSION['role'];
	$user = $_SESSION['user'];
	include('connection.php');
	 $team = $_REQUEST['team'];
	$query = mysqli_query($con,"SELECT empid from emp_table where workunderteam='".$team."' ");
	$count=mysqli_num_rows($query);
	$counter=0;
	//if ($counter==$count)
	 //	{
	 	
	 		 
	 	//     echo strtoupper($team[0]).'01';
	 		
		//}
	//if($query) {
	 //	while($result1=mysqli_fetch_array($query)) {
	 	///$counter++;
	 	//if ($counter==$count)
	 	//{
	 	
	 		// $str=substr($result1[0],1)+1;
	 	    // echo strtoupper($team[0]).'0'.$str;
	        $newid=$count+1;
	        if($newid>9)
	        {
	       echo strtoupper($team[0]).'00'.$newid;
	 		}
	 		else{
	 			 echo strtoupper($team[0]).'000'.$newid;
	 		}
		//}
	  //}
	//}
?>