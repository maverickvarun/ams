<?php
//if user is not login then he redirected to login form for login.	
	if(!isset($_SESSION['user']))
	{
		header('location:index.php');
	}
?>