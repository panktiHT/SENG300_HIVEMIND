<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Dashboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Registration Page for Hive Mind">
		<meta name="author" content="Nathan Moton">

    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    	<link href="css/global.css" rel="stylesheet" media="screen">
    	<link href="dashboard.css" rel="stylesheet" media="screen" />
	</head>


  	<body> 
		<nav class="navbar fixed-top navbar-expand-lg navbar-light">
			<div class="container" id="home">
				<!--<div class="input-group md-form form-sm form-2 pl-0" id="search">
	  				<input class="form-control my-0 py-1" type="text" placeholder="Search Papers" aria-label="Search">
	  				<div class="input-group-append">
	    				<span class="input-group-text lighten-2" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
	  				</div>
				</div>-->
				<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<u1 class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link text-black" href="dashboard.php">Dashboard</a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-black" href="Writer/writer.php">Submissions</a>
						</li>
						<?php 
							include('../userHandler.php');
							
							$userEmail = $_SESSION['email'];
							
							$userQuery = "SELECT * FROM userProfile WHERE email = '$userEmail'";
							$userResult = mysqli_query($db, $userQuery);
							$user = mysqli_fetch_assoc($userResult);
							
							if ($user['userType'] == 'editor'){
								echo '		
									<li class="nav-item">
										<a class="nav-link text-black" href="Reviewer/reviewer.php">Review</a>
									</li>
									<li class="nav-item">
										<a class="nav-link text-black" href="Editor/editor.php">Admin</a>
									</li>
								';
							} else if ($user['userType'] == 'reviewer'){
								echo '
									<li class="nav-item">
										<a class="nav-link text-black" href="Reviewer/reviewer.php">Review</a>
									</li>
								';
							}
						?>
						<li class="nav-item">
							<a class="nav-link text-black" href="../login.php">Sign Out</a>
						</li>
					</u1>
				</div>
			</div>
		</nav>
	<form method = "post">
		<div class="container" id="dashboard-journals">
			<?php 
				//Displays the most recent 10 published papers
				$db = mysqli_connect('localhost', 'root', '', 'journal');

				$paperQuery = "SELECT * FROM submissionProfile WHERE PaperStatus = 'accepted' ORDER BY dateOfSubmission ASC";
				$papersResult = mysqli_query($db, $paperQuery);
				
				$paperNumber = 0;
				while (($paper = mysqli_fetch_assoc($papersResult)) && $paperNumber <= 10){
			
					echo '
					<div class="card">			
						<div class="card-header">
							<h4>' . $paper['authors'] . '</h4>
							Published a Paper in ' . $paper['topic'] . '
						</div>
						<div class="card-body">
							<h5 class="card-title">' . $paper['paperTitle'] . '</h5>
							<td><button type="submit" formaction="Writer/viewPDF.php" name = "viewPDF" value =' . $paper['submissionId'] . '>View PDF</button></td>
						</div>
						<div class="card-footer text-muted">
							On ' . $paper['dateOfSubmission'] . '
						</div>
					</div>';
					
					$paperNumber++;
				}
				?>
		</div>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>
