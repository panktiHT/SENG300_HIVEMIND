<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Hive Mind - Join For Free</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Registration Page for Hive Mind">
		<meta name="author" content="Nathan Moton">

    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    	<link href="../css/global.css" rel="stylesheet" media="screen">
    	<link href="../css/signup.css" rel="stylesheet" media="screen">
	</head>
	<body>
		<div class="wrapper">
			<form class="form-signin" method="post">
				<h2 class="temp-logo-holder text-center">Hive Mind Logo</h2>
				<h2 class="form-signin-heading text-center">Create your Hive Mind Account</h2>
				<?php 
					include '../pages/userHandler.php';
					include '../errors/errors.php'; 
				?>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" class="form-control" name="firstName" placeholder="First Name" required="" autofocus=""/>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="text" class="form-control" name="lastName" placeholder="Last Name" required="" autofocus=""/>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
						<input type="text" class="form-control" name="institution" placeholder="Institution" required="" />
					</div>
					<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
						<input type="text" class="form-control" name="email" placeholder="Email Address" required="" autofocus=""/>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="password" class="form-control" name="password" placeholder="Password" required="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required="" />
					</div>
				</div>
				<button class="btn btn-lg btn-primary btn-block" name = "register">Complete Registration</button>
			</form>
		</div>
		<div class="wrapper" id="underLogin">
			<small>
				<a href="../index.html">Home</a>
                .
				<a href="">Help</a>
                .
				<a href="">Privacy</a>
				.
			</small>
			<small>
				Already have an account?
				<a href="login.php">Login Here</a>
			</small>
		</div>


		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>
