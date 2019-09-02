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
		
		if (!($userPrivilegeArray['userType'] !== "writer")){
			header('location:../../invalidPermissions.php');
		}
	}
?>

<html lang="en">
	<head>
		<title>Reviewer</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Reviewer Page for Hive Mind">
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
      <a href="reviewer.php">Review</a>
		<?php 
			$userEmail = $_SESSION['email'];
			
			$userQuery = "SELECT * FROM userProfile WHERE email = '$userEmail'";
			$userResult = mysqli_query($db, $userQuery);
			$user = mysqli_fetch_assoc($userResult);
			
			if ($user['userType'] == 'editor'){
				echo '		
					<a href="../Editor/editor.php">Admin</a>
				';
			} 
		?>
      <a href="../../login.php">Sign-out</a>
    </div>
  </div>





<!--feature 1: View all the submissions the reviewer has been requested to review 
	Submission ID | Paper Title | Topic | Deadline | Download 
	This should be a table -->

	
	<?php include('reviewerHandler.php'); ?>
	

    <!--make a table -->
    <body>
	<br>
	<p></p>
    <h2><b><center>Requested Reviews</center></b></h2>

    <div class="container">
    
    <table class="table table-bordered">
    <thead>
    <tr>
    <th>Submission ID</th>
    <th>Paper Title</th>
	<th>Topic</th>
    <th>Deadline</th>
	<th>Click to Download Paper</th>

    </tr>
    </thead>
    <tbody>
    <tr>

    <!-- populate information in the table --> 
    <?php
			
			$db = mysqli_connect('localhost','root','', 'journal');
			if (!$db)
			{
				 die('Could not connect: ' . mysql_error());
			}

			$email = $_SESSION['email'];
			$today = date("Y-m-d");
           
						//show all papers assigned to this reviewer, whose deadlines haven't expired yet
						$user_check_query = "SELECT AssignedSubmissionID, paperTitle, topic, pdfSubmission, AssignedDeadlineReviewer FROM reviewStatus INNER JOIN submissionProfile ON reviewStatus.AssignedSubmissionID=submissionProfile.submissionId WHERE AssignedReviewerEmail='$email' AND AssignedDeadlineReviewer >= '$today' AND reviewStatus.InterimStatusUpdate = 'submitted'";
						$result = $db->query($user_check_query);
		
					
						if ($result && $result->num_rows > 0)
						{
							
							while ($row = $result->fetch_assoc())
							{
								echo"<td>".$row["AssignedSubmissionID"]."</td>";
								echo"<td>".$row["paperTitle"]."</td>";
								echo"<td>".$row["topic"]."</td>";
								echo"<td>".$row["AssignedDeadlineReviewer"]."</td>";
								echo "<form action='viewPDF.php' method='post'>";
								echo '<td><button type="submit" formaction="viewPDF.php" name = "viewPDF" value =' . $row['AssignedSubmissionID'] . '>View PDF</button></td>';
								echo "</form>";
								echo "</tr>";
							}
						}

						else
						{
							echo "<br>";
							echo "<center><b>You currently have no papers assigned for review</b></center>";
						}


           						
    ?>
    </table>


    <br><br>
          

	<p>
  <!-- circle dots -->
  <div style="text-align:center">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
  </p>
  
  








<!--feature 2: Ask user to upload new review
			Stores information in a .xml file, which is added to the reviewStatus table as a string -->  

<!--Relevant CSS code for the form --> 
<link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
<style type="text/css">
.form-style-10
{
	width:450px;
	padding:30px;
	margin:40px auto;
	background: #FFF;
	border-radius: 10px;
	-webkit-border-radius:10px;
	-moz-border-radius: 10px;
	box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
	-moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
	-webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
}

.form-style-10 .inner-wrap
{
	padding: 30px;
	background: #F8F8F8;
	border-radius: 6px;
	margin-bottom: 15px;
}

.form-style-10 h1
{
	background: #2A88AD;
	padding: 20px 30px 15px 30px;
	margin: -30px -30px 30px -30px;
	border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	color: #fff;
	text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
	font: normal 30px 'Bitter', serif;
	-moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	-webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	border: 1px solid #257C9E;
}

.form-style-10 h1 > span
{
	display: block;
	margin-top: 2px;
	font: 13px Arial, Helvetica, sans-serif;
}

.form-style-10 label
{
	display: block;
	font: 13px Arial, Helvetica, sans-serif;
	color: #888;
	margin-bottom: 15px;
}

.form-style-10 input[type="text"],
.form-style-10 input[type="date"],
.form-style-10 input[type="datetime"],
.form-style-10 input[type="email"],
.form-style-10 input[type="number"],
.form-style-10 input[type="search"],
.form-style-10 input[type="time"],
.form-style-10 input[type="url"],
.form-style-10 input[type="password"],
.form-style-10 textarea,

.form-style-10 select 
{
	display: block;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	width: 100%;
	padding: 8px;
	border-radius: 6px;
	-webkit-border-radius:6px;
	-moz-border-radius:6px;
	border: 2px solid #fff;
	box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
	-moz-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
	-webkit-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
}

.form-style-10 .section
{
	font: normal 20px 'Bitter', serif;
	color: #2A88AD;
	margin-bottom: 5px;
}

.form-style-10 .section span 
{
	background: #2A88AD;
	padding: 5px 10px 5px 10px;
	position: absolute;
	border-radius: 50%;
	-webkit-border-radius: 50%;
	-moz-border-radius: 50%;
	border: 4px solid #fff;
	font-size: 14px;
	margin-left: -45px;
	color: #fff;
	margin-top: -3px;
}

.form-style-10 input[type="button"], 
.form-style-10 input[type="submit"]
{
	background: #2A88AD;
	padding: 8px 20px 8px 20px;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	color: #fff;
	text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
	font: normal 30px 'Bitter', serif;
	-moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	-webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	border: 1px solid #257C9E;
	font-size: 15px;
}

.form-style-10 input[type="button"]:hover, 
.form-style-10 input[type="submit"]:hover
{
	background: #2A6881;
	-moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
	-webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
	box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
}

.form-style-10 .privacy-policy
{
	float: right;
	width: 250px;
	font: 12px Arial, Helvetica, sans-serif;
	color: #4D4D4D;
	margin-top: 10px;
	text-align: right;
}
</style>


<!--error checking --> 



<div class="form-style-10">
<h1>Write a review!<span></span></h1>
<form method="post" action="reviewer.php">
	<?php include('errors.php'); ?>
	<center> 
    <div class="section"><span>1</span>Paper Information</div>
    <div class="inner-wrap">
        <label>Submission ID <input type="number" name="paperID" /></label>
		<label>Decision <select name="decision">
			  <option value="accept">Accept</option>
			  <option value="minor_rev">Accept with minor revisions</option>
			  <option value="major_rev">Accept with major revisions</option>
			  <option value="reject">Reject</option>
			</select>
    </div>


    <div class="section"><span>2</span>Comments for the Authors</div>
    <div class="inner-wrap">
        <label><textarea name="writerComments" style="width:300px; height:300px;">Type your suggestions here.</textarea></label>
    </div>

	<div class="section"><span>3</span>Comments for the Editors</div>
    <div class="inner-wrap">
        <label><textarea name="editorComments" style="width:300px; height:300px;">Type your suggestions here.</textarea></label>
    </div>

    <div class="input-group">
     	<button type="submit" class="btn" name="reviewSubmission">Submit</button>
    </div>
	</center>
</form>
</div>



<p>
  <!-- circle dots -->
  <div style="text-align:center">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
</p>





<!--Feature 3: allow reviewer to indicate preferences on which papers to review -->
    <body>
	<br>
	<p></p>
    <h4><b><center>Recent submissions:</center></b></h4>

    <div class="container">
    
    <table class="table table-bordered">
    <thead>
    <tr>
    <th>Submission ID</th>
    <th>Paper Title</th>
	<th>Topic</th>
	<th>Authors</th>
    <th>Date Submitted</th>
	<th>Select</th>
	<th>Click to Download Paper</th>

    </tr>
    </thead>
    <tbody>
    <tr>

    <!-- populate information in the table --> 
    <?php
			
			$db = mysqli_connect('localhost','root','', 'journal');
			if (!$db)
			{
				 die('Could not connect: ' . mysql_error());
			}

			$email = $_SESSION['email'];
			$today = date("Y-m-d");
           
						//show all papers assigned to this reviewer, whose deadlines haven't expired yet
						$user_check_query = "SELECT * FROM submissionProfile WHERE PaperStatus='submitted'";
						$result = $db->query($user_check_query);
		
					
						if ($result && $result->num_rows > 0)
						{
							
							while ($row = $result->fetch_assoc())
							{

								echo"<td>".$row["submissionId"]."</td>";
								echo"<td>".$row["paperTitle"]."</td>";
								echo"<td>".$row["topic"]."</td>";
								echo"<td>".$row["authors"]."</td>";
								echo"<td>".$row["dateOfSubmission"]."</td>";

								$message = $email."/".$row['submissionId'];
								echo "<form action='reviewPreference.php' method='post'>";
								echo '<td><button type="submit" formaction="reviewPreference.php" name = "reviewPreference" value =' . $message . '>Ask to review</button></td>';
								echo "</form>";

								echo "<form action='viewPDF.php' method='post'>";
								echo '<td><button type="submit" formaction="viewPDF.php" name = "viewPDF" value =' . $row['submissionId'] . '>View PDF</button></td>';
								echo "</form>";
								echo "</tr>";
							}
						}

						else
						{
							echo "<br>";
							echo "<center><b>There are no recent submissions</b></center>";
						}


           						
    ?>
    </table>


    <br><br>
          

	<p>
  <!-- circle dots -->
  <div style="text-align:center">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
  </p>
  













		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>

	
</html>



