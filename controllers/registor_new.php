<?php 
	include("../inc/connect.inc.php");

	$thisusername = mysqli_real_escape_string($conn, $_POST["username"]);
	$fname =  mysqli_real_escape_string($conn, $_POST["fname"]);
	$lname =  mysqli_real_escape_string($conn, $_POST["lname"]);
	$email =  mysqli_real_escape_string($conn, $_POST["email"]);
	$password =  mysqli_real_escape_string($conn, $_POST["password"]);
	$bio =  mysqli_real_escape_string($conn, $_POST["bio"]);
	$signup_date = date("Y-m-d");
	$last_login_date = date("Y-m-d");
	$authorization = "regular";

	$insert_new = mysqli_query($conn,"INSERT INTO users VALUE('','$thisusername','$fname','$lname','$authorization','$email','$password','$signup_date','$last_login_date','0','$bio','','','no')") or die("registor new user error!");

	header("Contnt-Type:application/json");
	echo json_encode(true);
?>