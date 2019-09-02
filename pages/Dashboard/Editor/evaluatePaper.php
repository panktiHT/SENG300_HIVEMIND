<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Dashboard</title>
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
      <a href="../Writer/writer.php">Writer</a>
      <a href="../Reviewer/reviewer.php">Reviewer</a>
      <a href="../Editor/editor.php">Editor</a>
      <a href="../../login.php">Sign-out</a>
    </div>
	
	<div class="topnav-left">
	   <a href="editor.php">Back</a>
	   </div>
  </div>
  
  
  	<br>
		<b><h2><center> Accept/Reject this Paper </center></h2></b>
	<br>
	
  	<table class = "table table-bordered">
	<tr>
		<th>Submission ID</th>
		<th>Title</th>
		<th>Submitter Email</th>
		<th>Topic</th>
		<th>Status</th>
		<th>Date</th>
	<tr>
	
<?php
	include 'editorHandler.php';
	include '../../../errors/errors.php';
?>
  
 </html>