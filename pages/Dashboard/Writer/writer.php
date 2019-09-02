
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Writer</title>
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
		<a href="writer.php">Submissions</a>
		<?php 
			include('userHandler.php');
			
			$userEmail = $_SESSION['email'];
			
			$userQuery = "SELECT * FROM userProfile WHERE email = '$userEmail'";
			$userResult = mysqli_query($db, $userQuery);
			$user = mysqli_fetch_assoc($userResult);
			
			if ($user['userType'] == 'editor'){
				echo '		
					<a href="../Reviewer/reviewer.php">Review</a>
					<a href="../Editor/editor.php">Admin</a>
				';
			} else if ($user['userType'] == 'reviewer'){
				echo '
					<a href="../Reviewer/reviewer.php">Review</a>
				';
			}
		?>
		<a href="../../login.php">Sign-out</a>
		</div>
	</div>








<!--feature 1: View all the submission made by the writer with their status 
	Paper ID | Paper Title | Status 
	This should be a table -->
	

    <!--make a table -->
    <body>
	<br>
	<p></p>
    <h2><b><center>Your Submissions:</center></b></h2>
	<p></p>

	<h4><b><center>Recently submitted</center></b></h4>

	    <div class="container">
    
    <table class="table table-bordered">
    <thead>
    <tr>
    <th>Submission ID</th>
    <th>Paper Title</th>
	<th>Topic</th>
    <th>Status</th>
	<th>Click to Download Paper</th> 
    </tr>
    </thead>
    <tbody>
    <tr>

    <!-- shows all papers that have been submitted in the current quarter --> 
    <?php
			
			$db = mysqli_connect('localhost','root','', 'journal');
			if (!$db)
			{
				 die('Could not connect: ' . mysql_error());
			}

			$email = $_SESSION['email'];

			$user_check_query = "SELECT * FROM submissionProfile WHERE email='$email'";
           
						
						$result = $db->query($user_check_query);

						
						if (!empty($result) && $result->num_rows > 0)
						{

							while ($row = $result->fetch_assoc())
							{
								echo"<td>".$row["submissionId"]."</td>";
								echo"<td>".$row["paperTitle"]."</td>";
								echo"<td>".$row["topic"]."</td>";
								echo"<td>".$row["PaperStatus"]."</td>";
								echo "<form action='viewPDF.php' method='post'>";
								echo '<td><button type="submit" formaction="viewPDF.php" name = "viewPDF" value =' . $row['submissionId'] . '>View PDF</button></td>';
								echo "</form>";
								echo "</tr>";

							}
						}
						else
						{
							echo "<br>";
							echo "<center><b>You have no new submissions. Make one today!</b></center>";
						}		
    ?>
    </table>
    <br><br>



	<!-- shows all papers that have been reviewed -->
	<h4><b><center>Reviewed</center></b></h4>

    <div class="container">
    
    <table class="table table-bordered">
    <thead>
    <tr>
    <th>Submission ID</th>
    <th>Paper Title</th>
    <th>Status</th>
	<th>Comments From Reviewer</th>
	<th>Resubmit Deadline</th>
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
			

			$update = "CREATE VIEW reviewMergeWriterStatus 
								AS SELECT *
								FROM (submissionProfile INNER JOIN reviewStatus ON submissionProfile.submissionId=reviewStatus.AssignedSubmissionID) ";
			$update = mysqli_query($db,$update);
				

			$user_check_query = "SELECT *
								FROM reviewMergeWriterStatus 
								WHERE email='$email'";
           
						
						$result = $db->query($user_check_query);
		
						if (!empty($result) && $result->num_rows > 0)
						{
							
							while ($row = $result->fetch_assoc())
							{
								echo"<td>".$row["submissionId"]."</td>";
								echo"<td>".$row["paperTitle"]."</td>";
								echo"<td>".$row["PaperStatus"]."</td>";
								echo"<td>".$row["WriterFeedback"]."</td>";
								echo"<td>".$row["WritersResubmissionDate"]."</td>";
								echo "<form action='viewPDF.php' method='post'>";
								echo '<td><button type="submit" formaction="viewPDF.php" name = "viewPDF" value =' . $row['submissionId'] . '>View PDF</button></td>';
								echo "</form>";
								echo "</tr>";

							}
						}


						else
						{
							echo "<br>";
							echo "<center><b>None of your papers have been reviewed yet.</b></center>";
						}
					

    ?>
    </table>

	<p>Note: to resubmit a paper after incorporating feedback, please withdraw the submission and create a new one.</p>
    <br><br>




          

	<p>
  <!-- circle dots -->
  <div style="text-align:center">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
  </p>
  
  



<!--feature 2: Ask user to upload new submission if they have any
			In the form ask to write Title, Topic, authors, pdf submission upload, select date, reviewer preference1, reviewer prefernce 2, reviewer preference 3 -->  

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







<!--Making a submission --> 
<div class="form-style-10">
<h1>Part 1: Make a new Submission!<span> Follow 3 Easy Steps Below!</span></h1>
<form method="post" action="writer.php">
	<?php include('errors.php'); ?>
	<center> 
    <div class="section"><span>1</span>Paper Information</div>
    <div class="inner-wrap">
        <label>Title of the paper <input type="text" name="paperTitle" /></label>
				<label>Topic of the paper <input type="text" name="topicPaper" /></label>
				<label>Authors of the paper <input type="text" name="authorsPaper" /></label>
				<label>Enter date <input type="date" name="dateOfSubmission" /></label>
    </div>


    <div class="section"><span>2</span>Upload</div>
    <div class="inner-wrap">
        <label>Upload your PDF <input type="file" name="paperUpload" /></label>
    </div>


    <div class="section"><span>3</span>Reviewer Preference. Enter up to 3 names or emails.</div>
    <div class="inner-wrap">
        <label>Reviewer Preference 1 <input type="text" name="Reviewer_Preference_1" /></label>
				<label>Reviewer Preference 2 <input type="text" name="Reviewer_Preference_2" /></label>
				<label>Reviewer Preference 3 <input type="text" name="Reviewer_Preference_3" /></label>	
    </div>


    <div class="input-group">
     	<button type="submit" class="btn" name="newPaperSubmission">Submit</button>
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










<!--uploading feature--> 
<div class="form-style-10">
<h1> Part 2: Upload your PDF!<span> Complete after Part 1</span></h1>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	<div class="inner-wrap">
		<center> 
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload PDF" name="submit">
		</center>
	</div>
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










<!--Enter submissionId of the paper you'd like to withdraw --> 
<!--Delete a submisison--> 
<div class="form-style-10">
<h1> Withdraw a Submission<span> Wrong submission? No Problem! </span></h1>
<form action="delete.php" method="post">
	<div class="inner-wrap">
		<center> 
			<label> Enter Submission ID: </label>
			<input type="int" name="submissionId" required>
		</center>
	</div>

	<div class="input-group">
			<button type="submit" class="btn" name="deleteSubmission">Delete</button>
	</div>
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


		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>

	
</html>




