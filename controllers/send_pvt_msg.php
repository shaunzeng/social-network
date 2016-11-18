<?php 
	include("../inc/connect.inc.php");
	
	$send_by = $_POST["send_by"];
	$send_to = $_POST["send_to"];
	$send_title = $_POST["send_title"];
	$send_body = strip_tags($_POST["send_body"]);
	$send_date = date("Y-m-d");
	$opened = "no";

	if ($send_body == "" || $send_by == "" || $send_to == "" || $send_title == ""){
		echo 0;
		return;
	}

	$send_msg = mysqli_query($conn, "INSERT INTO pvt_messages VALUES ('','$send_by','$send_to','$send_title','$send_body','$send_date','$opened')") or die("Send private msg error!");

	echo 1;



?>