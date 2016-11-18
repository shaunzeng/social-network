<?php 
include ("./inc/header.inc.php");
if (!$user){
	die ("You must be logged in to view this page!");
}
?>

<?php

	//check whether the user has uploaded a profile pic

	$check_pic = mysqli_query($conn,"SELECT profile_pic FROM users WHERE username='$user'");
	$get_pic_row = mysqli_fetch_assoc($check_pic);
	$profile_pic_db = $get_pic_row['profile_pic'];
	if ($profile_pic_db == "") {
	  $profile_pic = "img/default_pic.jpg";
	} else {
	  $profile_pic = "userdata/profile_pics/".$profile_pic_db;
	}


	// profile image upload script

	if (isset($_FILES["profilepic"])){
		if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)) 
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$rand_dir_name = substr(str_shuffle($chars),0,15);
			mkdir("userdata/profile_pics/$rand_dir_name");
			if (file_exists("userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"])){
				echo @$_FILES["profilepic"]["name"]."already exists";
			} else {
				move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/profile_pics/$rand_dir_name/".$_FILES["profilepic"]["name"]);
			    echo "<script>alert('saved')</script>";
			    $profile_pic_name = @$_FILES["profilepic"]["name"];
			    $profile_pic_query = mysqli_query($conn, "UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username='$user'");
			    header("Location:account_settings.php");
			}
		} else {
			echo "Invailid File! Your image must be no larger than 1MB and it must be either a .jpg, .jpeg, .png or .gif";
		}
	} 
	
?>


<?php include("./inc/navbar.inc.php"); ?>

<div class="container">
	<div class="row">
		<h2>Edit your Account Settings below</h2>
		<div class="col-xs-4">
			
			<br>
			<p>Upload your profile photo</p>
			<form action="account_settings.php" method="post" enctype="multipart/form-data" id="profile_photo_upload" name="profile_photo_upload">
				<img src="<?php echo $profile_pic ?>" width="70" alt="user image"/>
				<br>
				<input type="file" name="profilepic" /> <br>
				<button type="submit" name="uploadpic" class="btn btn-primary">Upload Image</button>

			</form>
			<br>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-4">
			<form>
				<p>Change your password</p>
				<br>
				<div class="form-group">
					<label for="oldpassword">Your old password</label>
					<input class="form-control" type="password" name="oldpassword" id="oldpassword" placeholder="Old password">
				</div>
				<br>
				<div class="form-group">
					<label for="newpassword">Your new password</label>
					<input class="form-control" type="password" name="newpassword" id="newpassword" placeholder="New password">
				</div>
				<br>
				<div class="form-group">
					<label for="newpassword2">Repeat your new password</label>
					<input class="form-control" type="password" name="newpassword2" id="newpassword2" placeholder="New password again">
				</div>
				<button type="submit" name="changepassword" id="changepassword" class="btn btn-success">Change password</button>
			</form>
		</div>

		<div class="col-xs-4 col-xs-offset-4">
			<form>
				<p>Update your profile info</p>
				<br>
				<div class="form-group">
					<label for="fname">First name:</label>
					<input class="form-control" type="text" name="fname" id="fname" placeholder="First name" >
				</div>
				<br>
				<div class="form-group">
					<label for="fname">Last name:</label>
					<input class="form-control" type="text" name="lname" id="lname" placeholder="Last name" >
				</div>
				<div class="form-group">
					<label for="aboutyou">About you:</label>
					<textarea class="form-control" type="text" name="aboutyou" row="7" col="40" id="aboutyou" placeholder="About you"></textarea>
				</div>
				<button type="submit" name="senddata" id="senddata" class="btn btn-warning">Update info</button>
			</form>
		</div>
	</div>
	<br>
	<hr>	
	<br>
	<br>
	<a href="close_account.php"><button class="btn btn-danger" type="submit" ><i class="fa fa-times"></i> Close my account</button></a>
</div>



<?php 
include ("./inc/footer.inc.php");
?>