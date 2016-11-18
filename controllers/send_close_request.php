<?php
	include("../inc/connect.inc.php");

	$this_user = $_POST["user"];

	$update_query = mysqli_query($conn, "UPDATE users SET close='yes', profile_pic='' WHERE username='$this_user'") or die("close account error!");

	echo json_encode(true);
?>