<?php include ("./inc/header.inc.php"); ?>

<?php 
	
	//Identify which user's album is being shown
	if(isset($_GET["u"])){
		$username = mysqli_real_escape_string($conn,$_GET["u"]);
		
		if (ctype_alnum($username)){
			$check = mysqli_query($conn, "SELECT username, first_name, last_name, bio FROM users WHERE username = '$username'");

			if (mysqli_num_rows($check) == 0){
				echo "<h1>This user does not exist!</h1>";
				exit();
			} 
		}
	}

	// check if it is the user who logged in viewing his own albums
	if ($user != $username){
		$isYourOwn = false;
	} else {
		$isYourOwn = true;
	}



?>

<?php include("./inc/navbar.inc.php"); ?>

<div class="container albums">
	<h4><?php echo $username.'\'s' ;?> Albums</h4>
	<hr>

	<?php 
		if ($isYourOwn == true) {
			echo "<div class='albums-container'>
					<div class='one-album add-album'>
						<div> + Create Album</div>
					</div>
				</div>";
		}
	?>
	
	<?php 
		$get_albums = mysqli_query($conn,"SELECT * FROM albums WHERE created_by='$username'") or die("Loading photo albums error");
		$numrows = mysqli_num_rows($get_albums);

		if ($numrows !=0) {
			while ($row = mysqli_fetch_assoc($get_albums)){
				$id = $row["id"];
				$album_title = $row["album_title"];
				$created_by = $row["created_by"];
				$date = $row["date_created"];
				$uid = $row["uid"];

				echo "<a href='viewphoto/$uid'><div class='one-album'>";
				echo "<img src='http://maxuecong.com/image/default_album.png' height='200' width='140' alt='photo album'/>";
				echo "<div class='album-title'>".$album_title."</div>";
				echo "</div></a>";
				
			}
		} else {
			echo "$username have no photo albums yet";
		}
	?>
</div>

<?php include ("./inc/footer.inc.php"); ?>