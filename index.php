<?php include("./inc/header.inc.php"); ?>

<?php 
	if (isset($_SESSION["user_login"])){
		$user = $_SESSION["user_login"];
		echo "<meta http-equiv=\"refresh\" content=\"0; url=./$user\">";
	}
?>

<?php 

	if (isset($_POST["user_login"]) && isset($_POST["password_login"])) {
		$user_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["user_login"]); // filter everything but numbers and letters
	    $password_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password_login"]); // filter everything but numbers and letters

		$sql = "SELECT id FROM users WHERE username='$user_login' AND password='$password_login' LIMIT 1";
	    $result = mysqli_query($conn, $sql); // query the person

	    // check close or not

	    $sql2 = "SELECT close FROM users WHERE username='$user_login' AND password='$password_login'"; 
	    $result2 = mysqli_query($conn, $sql2);

		//Check for their existance

		$userCount = mysqli_num_rows($result); //Count the number of rows returned

		while($row2 = mysqli_fetch_assoc($result2)){
			$isClose = $row2["close"];
		}

		if ($userCount == 1 && $isClose == "no") {
			while($row = mysqli_fetch_array($result)){ 
	             $id = $row["id"];
			}
			 $_SESSION["id"] = $id;
			 $_SESSION["user_login"] = $user_login;
			 $_SESSION["password_login"] = $password_login;

			 $change_status = mysqli_query($conn, "UPDATE users SET activated='1' WHERE username ='$user_login'");
			 
	         exit("<meta http-equiv=\"refresh\" content=\"0\">");
			} else {
			echo '<h1>That information is incorrect, try again</h1>';
			exit();
		}
	}
?>
	

	<div class="container login_signup_page">
		<div class="row">
			<div class="col-xs-12">
				<form action="index.php" method="post" name="login_form" id="login_form">
					<h3 class="main-title">Looking <small>for the real connections</small></h3>
					<br>
					<div class="form-group">
						<input type="text" class="input-control" name="user_login" id="user_login" placeholder="Username">
					</div>

					<div class="form-group">
						<input type="password" class="input-control" name="password_login" id="password_login" placeholder="Password">
					</div>
					
					<div class="clearfix">
						<div style="float:left; margin-top:10px">
							<a href="#"><p>Forget password?</p></a>
						</div>

						<div style="float:right">
							<button type="submit" class="btn btn-primary" id="login-btn">Login</button>
						</div>
					</div>
					<br>
				</form>

				<br>
				<p style="text-align:center"><a href="create_account.php">Need an account?</a></p>
			</div>
		</div>
	</div>

		
<?php include("./inc/footer.inc.php"); ?>