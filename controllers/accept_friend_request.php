<?php 
	include("../inc/connect.inc.php");

	// get friend_array row from logged in user
	$accept_friend_by = $_POST["accept_friend_by"];
	$accept_friend_from = $_POST["accept_friend_from"];

	$get_friend_check = mysqli_query($conn, "SELECT friend_array FROM users WHERE username='$accept_friend_by'");

	$get_friend_row = mysqli_fetch_assoc($get_friend_check);
	$friend_array = $get_friend_row["friend_array"];
	$friendArray_explode = explode(",",$friend_array);
	$friendArray_count = count($friendArray_explode);


	// get friend_array from the user who sent the friend request
	$get_right_name = explode("_",$accept_friend_from);
	$accept_friend_from = $get_right_name[1];
	$get_friend_check_friend = mysqli_query($conn, "SELECT friend_array FROM users WHERE username='$accept_friend_from'");

	$get_friend_row_friend = mysqli_fetch_assoc($get_friend_check_friend);
	$friend_array_friend = $get_friend_row_friend["friend_array"];
	$friendArray_explode_friend = explode(",",$friend_array_friend);
	$friendArray_count_friend = count($friendArray_explode_friend);

	// if the user has no friend we just concat the friends username
	
	if($friend_array == ""){
		$friendArray_count = count(NULL);
	}

	if ($friend_array_friend == ""){
		$friendArray_count_friend = count(NULL);
	}

	
	if($friendArray_count == NULL)	{
		$add_friend_query = mysqli_query($conn,"UPDATE users SET friend_array=CONCAT(friend_array,'$accept_friend_from') WHERE username='$accept_friend_by'") or die("update ".$accept_friend_by."'s friends list error");;	
	}

	if($friendArray_count_friend == NULL){
		$add_friend_query_friend = mysqli_query($conn, "UPDATE users SET friend_array=CONCAT(friend_array,'$accept_friend_by') WHERE username='$accept_friend_from'") or die("update ".$accept_friend_from."'s friends list error");;
	}
	
	
	if($friendArray_count >= 1)	{
		$add_friend_query = mysqli_query($conn,"UPDATE users SET friend_array=CONCAT(friend_array,',$accept_friend_from') WHERE username='$accept_friend_by'") or die("update ".$accept_friend_by."'s friends list error");
	}

	if($friendArray_count_friend >= 1)	{
		$add_friend_query = mysqli_query($conn,"UPDATE users SET friend_array=CONCAT(friend_array,',$accept_friend_by') WHERE username='$accept_friend_from'") or die("update ".$accept_friend_from."s friends list error");;	
	}
	

	$delete_request = mysqli_query($conn,"DELETE FROM friend_requests WHERE user_to='$accept_friend_by' AND user_from='$accept_friend_from'");
	
		
	echo true;

?>