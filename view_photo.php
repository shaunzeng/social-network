<?php 
	include ("./inc/header.inc.php"); 

	//Identify which user's photo is being shown
	if(isset($_GET["uid"])){
		$picture = mysqli_real_escape_string($conn,$_GET["uid"]);
		
		if (ctype_alnum($picture)){ 
			$get_photos = mysqli_query($conn, "SELECT * FROM photos WHERE uid = '$picture'") or die("Loading photos error!");
		} else {
			echo "Photo loading error, please go back to home page and do it again";
			exit();
		}
	}

?>

<?php include("./inc/navbar.inc.php"); ?>

<div class="container show-photo-page">

<h4>Photos in this album</h4>
<?php 

$numrows = mysqli_num_rows($get_photos);

if ($numrows != 0) {
	while($row = mysqli_fetch_assoc($get_photos)){
		$id = $row["id"];
		$uid = $row["uid"];
		$username = $row["username"];
		$date_posted = $row["date_posted"];
		$description = $row["description"];
		$image_url=$row["image_url"];

		echo "<div class='one-photo'><img alt='one image' src='$image_url'/> <label> $date_posted</label><h5>$description</h5></div>";
	}
} else {
	echo "<h2>This albums has no photo yet</h2>";
}


?>

</div>


<?php include ("./inc/footer.inc.php"); ?>