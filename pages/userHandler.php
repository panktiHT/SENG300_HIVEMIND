<?php
//initialize a session 
session_start();

$email = "";

//prints the last sql query error to phpError.log
ini_set("log_errors", 1);
ini_set("error_log", "phpError.log");

$errors = array();

//create db link
$db = mysqli_connect('localhost', 'root', '', 'journal');

if (isset($_POST['register']))
{
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$institution = $_POST['institution'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	
	$user_check_query = "SELECT * FROM userProfile WHERE email='$email' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	
	//doing error checks 
	if ($password !== $confirmPassword)
	{
		array_push($errors, "Passwords do not match");
	}
	
	if ($user) 
	{
		if ($user['email'] === $email) 
		{
		  array_push($errors, "E-mail already exists");
		}
	}
	
	//Register the user if there are no errors
	if (count($errors) == 0) 
	{
		$password = md5($password);//encrypt the password

		$query = "INSERT INTO userProfile (email, password, firstName, lastName, institution) 
				  VALUES('$email', '$password', '$firstName', '$lastName', '$institution')";
		$result = mysqli_query($db, $query);
		
		$_SESSION['email'] = $email;
  	    $_SESSION['success'] = "You are now registered and logged-in. Welcome!";
		header('location: Dashboard/dashboard.php');

	}
}

//for logging in users 
if (isset($_POST['login'])) 
{
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  //adding error checks
  if (empty($email)) 
  {
  	array_push($errors, "email is required");
  }
  
  if (empty($password)) 
  {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) 
  {
  	$password = md5($password);
  	$query = "SELECT * FROM userProfile WHERE email='$email' AND password='$password'";
  	$results = mysqli_query($db, $query);
   
  	if (mysqli_num_rows($results) == 1) 
   {
  	  $_SESSION['email'] = $email;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: Dashboard/dashboard.php');
  	}
     
   else 
   {
  		array_push($errors, "Wrong email/password combination");
  	}
  }

}



//feature 3: Backend Stuff
//	getting all the information from feature 2 and adding to the submissionProfile Table --> 


if (isset($_POST['newPaperSubmission'])) 
		{
			
			$email = $_SESSION['email'];
			$paperTitle = $_POST['paperTitle'];
			$topicPaper = $_POST['topicPaper'];
			$authorsPaper = $_POST['authorsPaper'];
			$dateOfSubmission = $_POST['dateOfSubmission'];

			$paperUpload = $_POST['paperUpload'];

			
			$Reviewer_Preference_1 = $_POST['Reviewer_Preference_1'];
			$Reviewer_Preference_2 = $_POST['Reviewer_Preference_2'];
			$Reviewer_Preference_3 = $_POST['Reviewer_Preference_3'];
			$PaperStatus = "Submitted";

			//three types of status are Submitted, Rejected, Accepted, Review
			
			
			//error checking if user forgot to add anything
			if (empty($paperTitle) || empty($topicPaper) || empty($authorsPaper) || empty($dateOfSubmission) || empty($paperUpload)) 
			{
				array_push($errors, "<b><center>One or more of the requird field is missing. Please ensure all the relevant information has been entered.</center></b>");
			}
			

			//if title paper is not unique then return as error
			$user_check_query = "SELECT * FROM submissionProfile WHERE paperTitle='$paperTitle' LIMIT 1";
			$result = mysqli_query($db, $user_check_query);
			$userPaper = mysqli_fetch_assoc($result);
	
			
			//doing error checks 
			if ($userPaper) 
			{
				if ($userPaper['paperTitle'] === $paperTitle) 
				{
					array_push($errors, "This paper title already exists.");
				}
				return;
			}
			

			// currently, this feature does not upload actual pdf on the database. will work on this later


			//if there are no errors then add all the info to database table submissionProfile
			if (count($errors) == 0) 
			{
				

				$sql = "INSERT INTO submissionProfile ( paperTitle, email, topic, authors, pdfSubmission, PaperStatus, dateOfSubmission, reviewerPreference1, reviewerPreference2, reviewerPreference3) 
						VALUES ('$paperTitle', '$email', '$topicPaper', '$authorsPaper', '$paperUpload', '$PaperStatus', '$dateOfSubmission','$Reviewer_Preference_1','$Reviewer_Preference_2', '$Reviewer_Preference_3')";   
				//$rows = mysqli_query($db, $sql);			
				
					if ($db->query($sql) === TRUE) 
					{
						//echo "New record created successfully";
						echo "<b><center>Submitted!</center></b>";
					} 
					
					else 
					{
						echo "Error: " . $sql . "<br>" . $db->error;
					}


				//echo "<b><center>Submitted!</center></b>";
			}



		}


?>