<?php 
include ("./inc/header.inc.php");
if (!$user){
	die ("You must be logged in to view this page!");
}
?>


<?php 
if (isset($_POST["user"])){
	$thisUser = $_POST["user"];

	$sql = "UPDATE users SET close='yes' WHERE username ='$thisUser' ";
	$update_query = mysqli_query($coon, $sql);

	echo json_encode(true);
}

?>

<?php include("./inc/navbar.inc.php"); ?>

<div class="container">

	<p>Are you sure to close your account?</p>
	<button type="submit" class="btn btn-warning" id="closeaccount" name="closeaccount" onclick="closeAccount()">Yes, close my account</button>
	<a href="account_settings.php"><button class="btn btn-info">Cancel</button></a>
	

</div>




<script type="text/javascript">
	function closeAccount(){
		$.post("controllers/send_close_request.php",
			{
				user:'<?php echo $user; ?>',
			},
			function(data){
				location.href="logout.php";
			});
	}
</script>

<?php 
include ("./inc/footer.inc.php");
?>