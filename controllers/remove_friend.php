<?php 
	include("../inc/connect.inc.php");

	$loggedinUser = $_POST["loggedinUser"];
	$profileUser = $_POST["profileUser"];

	// logged in user's friend array

	$get_friend_check = mysqli_query($conn, "SELECT friend_array FROM users WHERE username='$loggedinUser'");
	$get_friend_row = mysqli_fetch_assoc($get_friend_check);
	$friend_array = $get_friend_row["friend_array"];
	$friend_array_explode = explode(",",$friend_array);
	$friend_array_count = count($friend_array_explode);

	// user who owns the profile , his a friend array
	$get_friend_check_username = mysqli_query($conn, "SELECT friend_array FROM users WHERE username='$profileUser'");
	$get_friend_row_username = mysqli_fetch_assoc($get_friend_check_username);
	$friend_array_username = $get_friend_row_username["friend_array"];
	$friend_array_explode_username = explode(",",$friend_array_username);
	$friend_array_count_username = count($friend_array_explode_username);


	$usernameComma =",".$loggedinUser;
	$usernameComma2 = $loggedinUser.",";

	$userComma = ",".$profileUser;
	$userComma2 = $profileUser.",";

	// remove profile user from logged in user
	if (strstr($friend_array,$userComma)){
		$friend1 = str_replace($userComma,"",$friend_array);
	} else if (strstr($friend_array,$userComma2)){
		$friend1 = str_replace($userComma2,"",$friend_array);
	} else if (strstr($friend_array,$profileUser)){
		$friend1 = str_replace($profileUser,"",$friend_array);
	}

	// remove logged in user from profile user

	if (strstr($friend_array_username,$usernameComma)){
		$friend2 = str_replace($usernameComma,"",$friend_array_username);
	} else if (strstr($friend_array_username,$usernameComma2)){
		$friend2 = str_replace($usernameComma2,"",$friend_array_username);
	} else if (strstr($friend_array_username,$loggedinUser)){
		$friend2 = str_replace($loggedinUser,"",$friend_array_username);
	}

	$removeFriendQuery = mysqli_query($conn, "UPDATE users SET friend_array='$friend1' WHERE username='$loggedinUser'");
	$removeFriendQuery2 = mysqli_query($conn, "UPDATE users SET friend_array='$friend2' WHERE username='$profileUser'");

	echo true;
?>