<?php
$role =  $_REQUEST['user_role'];
  if($role == 'manager'){
	   $value = 'manager';
  } 
  else {
	  $value = 'employee';
  }
  echo "<option value=''>- ".$value."-id</option>";
    include('connection.php');
    $query = mysqli_query($con,"SELECT empid from emp_table  where employeerole = '".$value."' ");
    if($query) {
      while($result=mysqli_fetch_array($query)) {
      echo  '<option value="'.$result["empid"].'"> '.$result['empid'].'</option>';
    }
    }

  ?>