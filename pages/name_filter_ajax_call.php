<?php session_start();
$role = $_SESSION['role'];
$user = $_SESSION['user'];
$workunderteam=$_SESSION['workunderteam'];
include('connection.php');
$text = $_REQUEST['text'];
if($text !=''){
	if($role=='admin'){
		$query = mysqli_query($con,"SELECT firstname,lastname,empid,status from emp_table where ( firstname LIKE '".$text."%' or lastname LIKE '".$text."%' or empid LIKE '".$text."%')  ");
	}
	else{
		$query = mysqli_query($con,"SELECT firstname,lastname,empid,status from emp_table  where ( firstname LIKE '".$text."%' or lastname LIKE '".$text."%' or empid LIKE '".$text."%') And reportedmanagerid='".$user."' ");
	}
}else {
	if($role=='admin'){
		$query = mysqli_query($con,"SELECT firstname,lastname,empid,status from emp_table  ORDER BY firstname ASC");
	}
	else{
		$query = mysqli_query($con,"SELECT firstname,lastname,empid,status from emp_table  where reportedmanagerid='".$user."' ORDER BY firstname ASC");
	}
}

echo "<option value=''>-Search By Name-</option>";
if($query) {
$listcount=0;
	while($result1=mysqli_fetch_array($query)) {
		$fname=$result1['firstname'];
		$lname=$result1['lastname'];
		$status=$result1['status'];
	    // if ams has two same name employee then we use this below code--------
    $listcount++;
		$query2 = mysqli_query($con,"SELECT firstname,lastname,empid from emp_table where firstname='".$fname."'and lastname='".$lname."' ");
		$count = mysqli_num_rows($query2);
		if($count>1) {
			echo'<option value ="'.$result1['empid'].'" id="search_item'.$listcount.'">'.$result1['firstname'].' '.$result1['lastname'].' ('.$result1['empid'].')</option>';
		}
		else {


			echo'<option value ="'.$result1['firstname'].' '.$result1['lastname'].' ('.$result1['empid'].')" id="'.$result1['empid'].'">';

		}

	}
}
?>
