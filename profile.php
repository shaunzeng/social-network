<?php include ("./inc/header.inc.php"); ?>

<?php 
	// identify logged in user's profile page

	if(isset($_GET["u"])){
		$username = mysqli_real_escape_string($conn,$_GET["u"]);
		
		if (ctype_alnum($username)){
			$check = mysqli_query($conn, "SELECT username, first_name, last_name, bio FROM users WHERE username = '$username'");

			if (mysqli_num_rows($check) === 1){
				$get = mysqli_fetch_assoc($check);
				$username = $get["username"];
				$firstname = $get["first_name"];
				$lastname = $get["last_name"];
				$bio = $get["bio"];
			} else {
				echo "<h1>This user does not exist!</h1>";
				exit();
			}
		}
	}

	// check if this is your own profile page

	if ($user != $username){
		$isYourOwn = false;
	} else {
		$isYourOwn = true;
	}

?>

<?php 
	// check if the user is loogged in
	if ($user == ""){
		echo "<h1>Please log in first!</h1>";
		exit();
	}
?>

<?php 
	// getting profile picture
	$check_pic = mysqli_query($conn,"SELECT profile_pic FROM users WHERE username='$username'");
	$get_pic_row = mysqli_fetch_assoc($check_pic);
	$profile_pic_db = $get_pic_row['profile_pic'];
	if ($profile_pic_db == "") {
	  $profile_pic = "/social/img/default_pic.jpg";
	} else {
	  $profile_pic = "/social/userdata/profile_pics/".$profile_pic_db;
	}

?>

<?php
	// get friend list
	$get_friend_check = mysqli_query($conn, "SELECT friend_array FROM users WHERE username='$username'");

	$get_friend_row = mysqli_fetch_assoc($get_friend_check);
	$friend_array = $get_friend_row["friend_array"];
	$friendArray_explode = explode(",",$friend_array);

	if (count($friendArray_explode) !=0){
		$friend_list_array = $friendArray_explode;
	} else {
		$friend_list_array = false;
	}

	//check if this is your friend
	if (in_array($user, $friend_list_array)){
		$isYourFriend = true;
	} else {
		$isYourFriend = false;
	}

?>


<?php include("./inc/navbar.inc.php"); ?>

<div class="container profile">

	<div class="row">
		<div class="col-xs-3">
			<div class="profile-pic">
				<img src="<?php echo $profile_pic;?>" alt="<?php echo $username ?> 's profile" />
			</div>

			<div class="profile-title"><?php echo $firstname." ".$lastname ?>'s profile</div>
			<div class="profile-bio">
				<?php echo $bio ?>
				
			</div>
			<br>
			<div role="alert" class="alert alert-success <?php if($isYourFriend == true) { echo 'show-block';} else {echo 'hide-block';}; ?>"><i class="fa fa-check"></i> Friends</div>

			<div class="show-block">
				<?php 

					if($isYourOwn == false) {
						if ($isYourFriend == true) {
							echo "<button type='submit' class='btn btn-danger show-block' id='removefriend' name='removefriend_".$username."'><i class='fa fa-times-circle'></i> Remove this friend</button><br><br>";
						} else if ($isYourFriend == false){
							echo "<button type='submit' id='addfriend' name='addfriend_".$username."' class='btn btn-info show-block'><i class='fa fa-user-plus'></i> Add As Friend</button><br><br>";
						}

						echo "<button type='submit' id='sendmsg' name='sendmsg' class='btn btn-success' onclick='send_msg()'><i class='fa fa-envelope'></i> Send Message</button><br><br>";
					} else {
						echo "<div class='alert alert-success'>Weclome, ".$user."</div>";
					}

					echo "<a href='albums/$username'><button class='btn btn-primary' id='viewalbums' name='viewalbums' ><i class='fa fa-file-photo-o'></i> View Albums</button></a><br><br>";		
				?>
				
			</div>
			<div class="profile-friend-list">
				<div class="profile-title">Friend list</div>
				<ul class="list-unstyled">
					<?php 
						if ($friend_list_array != false) {

							for($row=0; $row<count($friend_list_array) ;$row++){
								if (count($friend_list_array) ==1 && $friend_list_array[0] == ""){
									echo "You have no friend";
								} else {
									echo "<li><a href='/social/$friend_list_array[$row]'>$friend_list_array[$row]</a></li>";
								}
							};

						} else {
							echo "You have no friend";
						}
					?>
				</ul>
			</div>
			
		</div>
		<div class="col-xs-6">
			<div class="wrap">
				
				<div class="row">
					<form id="post_form" action="#">
						<div class="col-xs-9">
							<textarea id="post" name="post" maxlength="100" placeholder="What do you want to say?"></textarea>
						</div>

						<div class="col-xs-3" style="padding-left:0">
							<button type="submit" class="btn btn-primary" id="post-btn">Post</button>
						</div>
					</form>
				</div>
			
			</div>
			<br>
				
			<div class="wrap" style="background-color:#F3F2F2;" id="posts_area" style="padding-bottom:5px;" >

				<?php 
					$getposts = mysqli_query($conn, "SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10") or die(mysqli_error());
					$num_rows = mysqli_num_rows($getposts);

					if ($num_rows !=0){
						while ($row = mysqli_fetch_assoc($getposts)){
							$id = $row['id'];
							$body = $row['body'];
							$date_added = $row['date_added'];
							$added_by = $row["added_by"];

							$getphoto_query = mysqli_query($conn, "SELECT profile_pic FROM users WHERE username='$added_by'");

							$getphoto = mysqli_fetch_assoc($getphoto_query);
							$this_photo = $getphoto["profile_pic"];
							
							if (!$this_photo){
								$this_photo ="img/default_pic.jpg";
							}

							echo "<div class='posted-wrap clearfix' data-post-id='$id'>
									<div class='post-head clearfix'>
										<img src='userdata/profile_pics/$this_photo' alt='image' class='post-pic' />
										<div class='post-title '>
											<p><a href='$added_by'><strong>$added_by</strong></a></p>
											<h6>$date_added</h6>
										</div>
									</div>
								
									<div class='posted-body'><p>$body</p></div>
									<hr>
									<ul class='list-unstyled list-inline'>
										<li><a href='#'><i class='fa fa-heart-o'></i> Like</a></li>
									</ul>
									<div class='comments-list'>";

							$getcomments_query = mysqli_query($conn, "SELECT * FROM comments_on_posts WHERE commented_to='$id'");
							$getcomments_row =  mysqli_num_rows($getcomments_query);

							if ($getcomments_row != 0) {
								while ($comment_row = mysqli_fetch_assoc($getcomments_query)){
									$comment_body = $comment_row["comment_body"];
									$commented_to = $comment_row["commented_to"];
									$comment_time = $comment_row["comment_date"];
									$commented_by = $comment_row["commented_by"];

									echo "<div class='one-comment'><strong><a href='$commented_by'>$commented_by</a></strong> $comment_body</div>";
								}
							} 	

							
							echo	"</div>
									<input maxlength='100' type='text' name='send_comment' placeholder='Leave your comment' class='comment_submit form-control' />
								  </div>";
						}
					} else {
						echo "<p>You have no post yet...</p>";
					}
										
				?>
			</div>
			
		</div>
		<div class="col-xs-3">
			<div class="wrap btn-list <?php if($isYourOwn == true) { echo 'show-block';} else {echo 'hide-block' ;} ?>"> 
				<ul class="list-unstyled">
					<li><a href="account_settings.php">Account Settings</a></li>
					<li><a href="my_messages.php">Message</a></li>
					<li><a href="friend_request.php">Friend Request</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#post_form").submit(function(e){
		e.preventDefault();
		var post = $("#post").val();

		if(post ==""){
			alert("Please write something in the field!");
			return false;
		}

		var added_by = "<?php echo $user; ?>";
		var added_to = "<?php echo $username; ?>";

		$.post("controllers/send_post.php", 
				{
					post:post,
					added_by:added_by,
					added_to:added_to,
				},
				function(data){
					/*var temp = "<div class='posted-wrap clearfix'><div class='post-head clearfix'><img src='userdata/profile_pics/img/default.jpg' alt='image' class='post-pic' /><div class='post-title'><p><a href='"+ added_by +"'><strong>" + added_by + "</strong></a></p>";
						temp +=	"<h6><?php echo date('y-m-d'); ?></h6></div></div><div class='posted-body'><p>" + post + "</p></div><hr><ul class='list-unstyled list-inline'><li><a href='#'><i class='fa fa-thumbs-o-up'></i> Like</a></li></ul><input maxlength='100' type='text' name='send_comment' placeholder='Leave your comment' class='comment_submit form-control' /></div>";
					$("#posts_area").prepend(temp);*/
					location.reload();
				}).done(function(){
					console.log("completed!");
				}).fail(function(){
					console.log("failed!");
				}).always(function(){
					$("#post").val("");
				})

	});


	$("#addfriend").click(function(e){
		e.preventDefault();

		var request_by = "<?php echo $user ?>";
		var request_to = "<?php echo $username ?>";

 		if (request_by != request_to){
 			$.post("controllers/send_friend_request.php", 
 				{
 					request_by: request_by,
 					request_to: request_to,
 				}, 
 				function(data){
 			
 					if(data ==1){
 						alert("Request sent!");
 					} else {
 						alert("Request has been sent already!");
 					}
 				});
 		} else {
 			alert("You cannot send friend request to yourself!");
 		}
	});

	$(".profile").on("click", "#removefriend", function(e){
		e.preventDefault();
		console.log("click!");
		var loggedinUser = "<?php echo $user;?>";
		var profileUser = "<?php echo $username;?>";

		if (loggedinUser != profileUser){
			$.post("controllers/remove_friend.php",
				{
					loggedinUser:loggedinUser,
					profileUser:profileUser,
				},
				function(data){
					if(data ==1){
						location.reload();
					}
				});
		}

	});

	function send_msg(){
		location.href='send_msg.php?sendTo=<?php echo $username; ?>';
	}

	$(".profile").on("keypress", ".comment_submit", function(e){
		if (e.keyCode == 13) {
			var comment = $(this).val();
			var commented_by = "<?php echo $user;?>";
			var commented_to = $(this).closest(".posted-wrap").data("post-id");

			$.post("controllers/send_comments.php", 
				{
					comment_body:comment,
					commented_by:commented_by,
					commented_to:commented_to,
				},
				function(data){
					console.log(data);
					location.reload();
				});
		}
	});


</script>

<?php include ("./inc/footer.inc.php"); ?>