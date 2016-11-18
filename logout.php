<?php
ob_start();
	include ("./inc/header.inc.php"); 
	session_start();
	$change_status = mysqli_query($conn, "UPDATE users SET activated='0' WHERE username ='$user'") or die("logout error");
	session_destroy();

	
	header("Location: index.php");
	exit();
	
	ob_end_flush();
?>