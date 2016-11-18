<?php 
	include("../inc/connect.inc.php");
	
	$comment_body = $_POST['comment_body'];
	$commented_by = $_POST["commented_by"];
	$commented_to = $_POST["commented_to"];
	$comment_date = date("Y-m-d");

	$send_comment = mysqli_query($conn, "INSERT INTO comments_on_posts VALUE('','$comment_body','$commented_by','$commented_to','$comment_date')") or die("Send comment error!");

	echo 1;

?>