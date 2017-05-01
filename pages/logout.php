<?php
	session_start(); //check that user is set or not
	if(isset($_SESSION['user']))
	{
		unset($_SESSION['user']);//unset the active user session
		session_destroy(); //session of active user is destroy
		header("Location: index.php");
		exit;
	}
	else{
	header("Location: index.php");
	}
?>