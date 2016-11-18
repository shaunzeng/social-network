<?php include ("./inc/header.inc.php"); ?>

<?php 
	if(isset($_GET["sendTo"])){
		$username = mysqli_real_escape_string($conn,$_GET["sendTo"]);
		
		if (ctype_alnum($username)){
			$check = mysqli_query($conn, "SELECT username, first_name, last_name, bio FROM users WHERE username = '$username'");

			if (mysqli_num_rows($check) === 1){
				$get = mysqli_fetch_assoc($check);
				$username = $get["username"];
				$firstname = $get["first_name"];
				$lastname = $get["last_name"];
				$bio = $get["bio"];
			} else {
				header("Location:$user");
			}
		}
	}


	if ($username == $user){
		echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/social_network/$user\">";
	}

?>

<?php include("./inc/navbar.inc.php"); ?>

<div class="container send-msg">
	<form action="#" onsubmit="send_msg();" class="col-xs-6">
		<div class="form-group ">
			<label for="msg_title">Your message to <?php echo $username; ?> :</label>
			<input type="text" maxlength="30" placeholder="Message title" class="form-control" name="msg_title" id="msg_title">
		</div>
		<textarea cols='50' class="form-control" rows='7' cols="10" name='msg_body' id="msg_body" placeholder='Enter your message' style="margin-bottom:15px"></textarea>
		
		<button type='submit' class='btn btn-primary' >Send</button>
	</form>
</div>

<script type="text/javascript">
	function send_msg(){

		event.preventDefault();
	
		var send_by = "<?php echo $user; ?>";
		var send_to ="<?php echo $username; ?>";
		var send_body = $("#msg_body").val();
		var send_title = $("#msg_title").val();

		if (send_body == "" || send_title ==""){
			alert("Please write something in message body and messa title");
			return false;
		} else if(send_body.length <= 5) {
			alert("You message is too short")
			return false;
		} 
		
		$.post("controllers/send_pvt_msg.php",
			{
				send_by:send_by,
				send_to:send_to,
				send_body:send_body,
				send_title:send_title,
			},
			function(data){
				console.log(data);
				if (data == 1){
					alert("Your message is sent");
				}
			}).done(function(){
				$("#msg_body").val("");
				$("#msg_title").val("");
				console.log("Msg send Completed!")
			})
	}
</script>
<?php include ("./inc/footer.inc.php"); ?>