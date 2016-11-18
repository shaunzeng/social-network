<?php 
	include("../inc/connect.inc.php");

	$ignore_by = $_POST["ignore_by"];
	$ignore_from = $_POST["ignore_from"];

	$get_right_name = explode("_",$ignore_from);
	$ignore_from = $get_right_name[1];

	$delete_request = mysqli_query($conn,"DELETE FROM friend_requests WHERE user_to='$ignore_by' AND user_from='$ignore_from'") or die("ignore friend request error!");

	echo true;
?>