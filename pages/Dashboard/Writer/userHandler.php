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



//	getting all the information from feature 2 and adding to the submissionProfile Table --> 


if (isset($_POST['newPaperSubmission'])) 
		{

			$email = $_SESSION['email'];
			$paperTitle = $_POST['paperTitle'];
			$topicPaper = $_POST['topicPaper'];
			$authorsPaper = $_POST['authorsPaper'];
			$dateOfSubmission = $_POST['dateOfSubmission'];
			$paperUpload = $_POST['paperUpload'];
			$paperUpload = basename($paperUpload); //just stores the terminal filename in the SQL table
			
			$Reviewer_Preference_1 = $_POST['Reviewer_Preference_1'];
			$Reviewer_Preference_2 = $_POST['Reviewer_Preference_2'];
			$Reviewer_Preference_3 = $_POST['Reviewer_Preference_3'];
			$PaperStatus = "Submitted";

			//three types of status are Submitted, Rejected, Accepted, Review
			
			
			//error checking if user forgot to add anything
			if (empty($paperTitle) || empty($topicPaper) || empty($authorsPaper) || empty($dateOfSubmission) || empty($paperUpload)) 
			{
				array_push($errors, "<b><center>One or more required fields is missing. Please ensure all relevant information has been entered.</center></b>");
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