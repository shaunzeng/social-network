<?php include ("inc/header.inc.php");  ?>


<?php include("./inc/navbar.inc.php"); ?>

<br>
<div>
	<div class="container" id="friend-request">
		<p>
			<?php 
				// find friend request
				$user_from="";
				$output = "";
				$findRequests= mysqli_query($conn, "SELECT * FROM friend_requests WHERE user_to='$user'");
				$numrows = mysqli_num_rows($findRequests);

				if ($numrows == 0 ){
					echo "You have no friend request";
				} else {

					while ($get_row = mysqli_fetch_assoc($findRequests)){
						$id = $get_row["id"];
						$user_to = $get_row["user_to"];
						$user_from = $get_row["user_from"];

						$output = true;

						echo "<div class='one-request'><p>".$user_from." wants to be friends</p>"."<form action ='#' method='post'>
																	<button type='submit' name='acceptrequest_$user_from' class='btn btn-warning accept-friend-btn'>Accept Request</button>
																	<button type='submit' name='ignorerequest_$user_from' class='btn btn-info ignore-friend-btn'>Ignore Request</button>
																</form><br></div>";
					}
				}
			?>
		</p>
		
	</div>
</div>

<script type="text/javascript">
	$("#friend-request").on("click", "button.accept-friend-btn", function(e){
		var thisBtn = $(this);
		e.preventDefault();
		$.post("controllers/accept_friend_request.php", 
				{
					accept_friend_by:'<?php echo $user; ?>',
					accept_friend_from:thisBtn.attr("name"),
				},
				function(data){
					if(data == 1){
						thisBtn.closest("div.one-request").hide();
					};
					
				}).done(function(){
					console.log("successful!");
				}).fail(function(){
					console.log("failed!");
				});
	});

	$("#friend-request").on("click","button.ignore-friend-btn",function(e){
		var thisBtn = $(this);
		e.preventDefault();
		$.post("controllers/ignore_friend_request.php", 
			{
				ignore_by:'<?php echo $user ?>',
				ignore_from: thisBtn.attr("name"),
			},
			function(data){
				if(data == 1){
					thisBtn.closest("div.one-request").hide();
				};

			}).done(function(){
				console.log("Successful");
			}).fail(function(){
				console.log("failed");
			});
	});

</script>

<?php include ("inc/footer.inc.php"); ?>