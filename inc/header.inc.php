<?php 
include("./inc/connect.inc.php"); 
session_start();
if(isset($_SESSION["user_login"])){
	$user = $_SESSION["user_login"];
} else {
	$user = "";
}

?>
<!doctype html>
<html>
	<head>
		<title>Looking</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="/social/css/style.css">
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	</head>

	<body>