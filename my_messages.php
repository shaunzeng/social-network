<?php include ("./inc/header.inc.php"); ?>

<?php include("./inc/navbar.inc.php"); ?>

<div class="container message-box">
<h4>My mesasges</h4><br>
<?php 
	$grab_messages = mysqli_query($conn, "SELECT * FROM pvt_messages WHERE user_to='$user' ORDER BY id DESC") or die("loading messages error!");
	$num_rows = mysqli_num_rows($grab_messages);

	if ($num_rows != 0){
		while ($get_msg = mysqli_fetch_array($grab_messages)){
			$msg_id = $get_msg["id"];
			$user_from = $get_msg["user_from"];
			$user_to = $get_msg["user_to"];
			$msg_title=$get_msg["msg_title"];
			$msg_body = $get_msg["msg_body"];
			$date = $get_msg["date"];
			$opened = $get_msg["opened"];


			if ($opened == "no"){
		
				echo "<div class='one-msg' data-opened='$opened'><i class='fa fa-circle'></i> <label data-id='$msg_id'>$date</label>, <label><a href='$user_from'>$user_from</a>: </label> <a href='#' class='msg-title' >$msg_title</a> <i class='fa fa-times'></i> <i class='fa fa-reply'></i> </div><div class='msg-content'><p>$msg_body</p></div><hr>";
			} else {
				echo "<div class='one-msg read-msg' data-opened='$opened'><i class='fa fa-circle-o'></i> <label data-id='$msg_id'>$date</label>, <label><a href='$user_from'>$user_from</a>: </label> <a href='#' class='msg-title' >$msg_title</a>  <i class='fa fa-times'></i> <i class='fa fa-reply'></i> </div><div class='msg-content'><p>$msg_body</p></div><hr>";
			}
			
		}
	} else {
		echo "<p>You have no message</p>";
	}

?>

</div>

<script type="text/javascript">
	$(".message-box").on("click", ".msg-title", function(e){
		var thisDiv = $(this).closest(".one-msg")
		$(this).closest(".one-msg").next().toggle();

		var isRead = $(this).closest(".one-msg").data("opened");
		var id =$(this).closest(".one-msg").find("label[data-id]").data("id");

		if (isRead = "no"){
			$.post("controllers/update_msg_status.php",
			{
				status:"yes",
				id:id,
			},
			function(data){
				if (data == 1){
					thisDiv.addClass("read-msg").data("opened","yes").find("i.fa-circle").removeClass("fa-circle").addClass("fa-circle-o");
				}
			});
		}
	});
</script>
<?php include ("./inc/footer.inc.php"); ?>