<!DOCTYPE html>

<?php
	include '../../userHandler.php';

	//this code displays different navigation options on the menu bar based on the users privileges
	if (!isset($_SESSION['email'])){
		header('location:../../invalidPermissions.php');
	} else {
		$email = $_SESSION['email'];
		
		$userPrivilegeQuery = "SELECT * FROM userProfile WHERE email = '$email'";
		$userPrivilegeResult = mysqli_query($db, $userPrivilegeQuery);
		$userPrivilegeArray = mysqli_fetch_assoc($userPrivilegeResult);
		
		if ($userPrivilegeArray['userType'] != "editor"){
			header('location:../../invalidPermissions.php');
		}
	}
?>


<html lang="en">
	<head>
		<title>Editor</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Registration Page for Hive Mind">
		<meta name="author" content="Nathan Moton">

    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    	<link href="../css/global.css" rel="stylesheet" media="screen">
    	<link href="../css/signup.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="stylesheet.css">
	</head>


  <body> 
  <!-- add a logo --> 
  <div class = "logo"><a href = ""><img src = "" style="width:5%"></a>
  </div>
  
  <!-- Navigation -->
  <div class="topnav">
    <div class="topnav-right">
      <a href="../dashboard.php">Dashboard</a>
      <a href="../Writer/writer.php">Submissions</a>
      <a href="../Reviewer/reviewer.php">Review</a>
      <a href="editor.php">Admin</a>
      <a href="../../login.php">Sign-out</a>
    </div>
  </div>
  
  	<br>
	<b><h2><center> To Do List for This Quarter </center></h2></b>
	
  <form method="post" action="addReviewer.php">
  	<?php 
		include 'editorHandler.php';
		include '../../../errors/errors.php';
	?>
	<br>
		<b><h4><center> Papers Awaiting a Decision </center></h4></b>
	<br>	
 	<!--Generate columns -->
  	<table class = "table table-bordered">
	<tr>
		<th>Submission ID</th>
		<th>Title</th>
		<th>Submitter Email</th>
		<th>Topic</th>
		<th>Status</th>
		<th>Date Submitted</th>
		<th></th>
		<th></th>
		<th></th>
	<tr>
	<!--Generate cells -->
	<?php 
		include 'toDoListTableGenerator.php';
	?>
	</table>
   </form>
	
	
  <form method="post" action="addReviewer.php">
	<br>
		<b><h4><center> Papers Awaiting a Reviewer </center></h4></b>
	<br>	
 	<!--Generate columns -->
  	<table class = "table table-bordered">
	<tr>
		<th>Submission ID</th>
		<th>Title</th>
		<th>Submitter Email</th>
		<th>Topic</th>
		<th>Status</th>
		<th>Date Submitted</th>
		<th></th>
		<th></th>
	<tr>
	<!--Generate cells -->
	<?php 
		include 'reviewerTableGenerator.php';
	?>
	</table>
  </form>
  
  	<br>
  	<br>
		<b><h2><center> Assign Reviewer Privileges </center></h2></b>
	<br>
	<form method="post">
		<center>
		<div class="input-group">
			<input type="text" placeholder="Enter the email of the user you want to assign privileges to" name = "enteredEmail">
		</div>
		<div class="input-group">
			<button type="submit" name="createReviewer">Assign</button>
		</div>
		</center>
    </form>
	
	<br>
  	<br>
		<b><h2><center> Search All Papers </center></h2></b>
	<br>
	
	 <form method="post">
		<center>
		<div class="input-group">
			<input type="text" placeholder="Search.." name="search">
		</div>
		<div class="input-group">
			<button type="submit" name="searchButton">Search</button>
		</div>
		</center>
    </form>
   
  	<table class = "table table-bordered">
	<tr>
		<th>Submission ID</th>
		<th>Title</th>
		<th>Submitter Email</th>
		<th>Topic</th>
		<th>Status</th>
		<th>Date Submitted</th>
		<th></th>
	<tr>
	
	<form method = "post">
	<!--Generate search results -->
	<?php 
		include 'searchGenerator.php';
	?>
	</form>
  
</html>