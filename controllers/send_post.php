<?php 
	include("../inc/connect.inc.php");
	
	$post = $_POST['post'];
	$added_by = $_POST["added_by"];
	$added_to = $_POST["added_to"];

	if ($post != ""){
		$date_added = date("y-m-d");

		$sqlCommand = "INSERT INTO posts VALUE('','$post','$date_added','$added_by','$added_to')";
		$query = mysqli_query($conn, $sqlCommand) or die(mysqli_error());

		echo true;
		
	} else {
		echo false;
	}

?>


