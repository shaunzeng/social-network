<?php include("./inc/header.inc.php"); ?>


<div class="container signup-page" >
	<br>
	<h2 class="title">Looking</h2>
	<br>
	<form name="registration_form" id="registration_form" action="#">
		<div class="sub-title">REGISTRATION FORM</div>
		<div class="table-wrap clearfix">
			<div class="form-group ">
				<label for="username" class="col-xs-4">Username</label>
				<input type="text" maxlength="50" class="input-control col-xs-8" id="username" name="username" placeholder="Username">
			</div>
			<br>
			<br>
			<div class="form-group">
				<label for="first_name" class="col-xs-4">Full name</label>
				<input type="text" maxlength="50" class="input-control col-xs-4" id="first_name" name="first_name" placeholder="First name">
				<input type="text" maxlength="50" class="input-control col-xs-4" id="last_name" name="last_name" placeholder="Last name">
			</div>
			<br>
			<br>
			<div class="form-group">
				<label for="email" class="col-xs-4">Email</label>
				<input type="email" class="input-control col-xs-8" id="email" name="email" placeholder="Email">
			</div>
			<br>
			<br>
			<div class="form-group">
				<label for="password" class="col-xs-4">Password</label>
				<input type="password" maxlength="50" class="input-control col-xs-8" id="password" name="password" placeholder="Password">
			</div>
			<br>
			<br>
			<div class="form-group">
				<label for="password2" class="col-xs-4">Password again</label>
				<input type="password" maxlength="50" class="input-control col-xs-8"  name="password_mirror" id="password_mirror" placeholder="Password again">
			</div>
			<br>
			<br>
			<div class="form-group">
				<label for="Bio" class="col-xs-4">Bio</label>
				<textarea type="text" class="input-control col-xs-8" id="bio" name="bio" placeholder="Brief bio" row="10"></textarea>
			</div>
			<br>
			<br>
			<br>
			<div class="btn-wrap">
				<button style="float:right" type="submit" class="btn" id="signup-btn">Sign up</button>
			</div>
			
		</div>
	</form>
	<br>
	<br>
	<div style="text-align:center">Already registered? <a href="index.php">Log in here</a></div>
</div>

<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>

<script type="text/javascript">

$(function(){
	$("#registration_form").validate({
		rules:{
			username:{
				required:true, 
				minlength:4,
				remote:"controllers/check_username.php",
			},
			first_name:{
				required:true, 
				minlength:2,
			},
			last_name:{
				required:true,
				minlength:2,
			},
			email:{
				required:true, 
				email:true,
			},
			password:{
				required:true,
				minlength:5,
			},
			password_mirror:{
				required:true,
				minlength:5,
				equalTo:"#password",
			},
			bio:{
				required:true,
				minlength:5,
			},
		},
		messages:{
			username:{required:"", minlength:"",remote:"Username is already taken!"},
			first_name:{required:"Please enter your first name", minlength:"At least 2 characters",},
			last_name:{required:"Please enter your last name", minlength:"At least 2 characters",},
			email:{required:"Please enter your email", email:"Email please",},
			password:{required:"Please enter your password", minlength:"At least 5 digits",},
			password_mirror:{required:"Please enter your password again", minlength:"At least 5 digits",equalTo:"Enter same password"},
			bio:{required:"Please enter your brief bio", minlength:"At least 5 characters",},
		},
		wrapper:"div",
		errorElement:"div",
		errorPlacement:function(error, element){
			if (element.attr("name") == "username"){
				error.insertAfter("#username");
			}
		},
		submitHandler:function(){
			send_registor_request();

		},
	});
});

function send_registor_request(){
	event.preventDefault();
	$.post("controllers/registor_new.php", 
		{
			username:$("#username").val(),
			fname:$("#first_name").val(),
			lname:$("#last_name").val(),
			password:$("#password").val(),
			email:$("#email").val(),
			bio:$("#bio").val(),
		},
		function(data){
			console.log(data);
			if (data == "true"){
				alert("Signup successful!");
				location.href="index.php";
			} else {
				alert("Signup failed! Please try again");
			}
		});
}
	
</script>

<?php include("./inc/footer.inc.php"); ?>