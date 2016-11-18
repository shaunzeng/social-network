<?php 
	include("../inc/connect.inc.php");
	

	$request_by = $_POST["request_by"];
	$request_to = $_POST["request_to"];

	$check_exist = mysqli_query($conn, "SELECT * FROM friend_requests WHERE user_from='$request_by' AND user_to='$request_to'") or die("checking request list error!");

	if (mysqli_num_rows($check_exist) == 0) {
		$send_request = mysqli_query($conn, "INSERT INTO friend_requests VALUE('','$request_by','$request_to','0')") or die(mysqli_error());
		echo true;
	} else {
		echo false;
	}

?>