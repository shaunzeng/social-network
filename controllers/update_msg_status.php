<?php 
	include("../inc/connect.inc.php");
	
	$status = $_POST["status"];
	$id = $_POST["id"];

	$change_status = mysqli_query($conn, "UPDATE pvt_messages SET opened='$status' WHERE id ='$id' ") or die("Update pvt message status error");

	echo 1;	
?>