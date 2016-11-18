<?php 
	include("../inc/connect.inc.php");

	$thisusername = mysqli_real_escape_string($conn, $_GET["username"]);

	$check_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$thisusername'");

	$rows = mysqli_num_rows($check_username);

	if ($rows != 0) {
		$result = false;

	} else {
		$result = true;
	}

	header("Content-Type: application/json");
	echo json_encode($result);
	
?>