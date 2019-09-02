<?php
//prints the last sql query error to phpError.log
ini_set("log_errors", 1);
ini_set("error_log", "phpError.log");

$errors = array();

//create db link
$db = mysqli_connect('localhost', 'root', '', 'journal');


// when reviewer submits the form, this reads the input values and updates the reviewStatus table appropriately


if (isset($_POST['reviewSubmission'])) 
		{
			
			$email = $_SESSION['email'];
			$submissionID = $_POST['paperID'];
			$decision = $_POST['decision'];

					
			$writerComments = $_POST['writerComments'];
			
			$editorComments = $_POST['editorComments'];

			
			
			//error checking if user forgot to add anything
			if (empty($email) || empty($submissionID) || empty($decision) || empty($writerComments) || empty($editorComments)) 
			{
				array_push($errors, "<b><center>One or more required fields is missing. Please ensure all relevant information has been entered.</center></b>");
			}
			
			
			$review_check_query = "SELECT * FROM reviewStatus WHERE AssignedSubmissionID='$submissionID' AND AssignedReviewerEmail='$email' LIMIT 1";
			$result = mysqli_query($db, $review_check_query);
			$reviewedPaper = mysqli_fetch_assoc($result);
	
			//doing error checks
			if ($reviewedPaper) 
			{
				if ($reviewedPaper['InterimStatusUpdate'] == 'reviewed') 
				{
					array_push($errors, "This paper already has a review.");
				}

			}
			
			

			//if there are no errors then write all the info to an XML string, and store in the table reviewStatus
			if (count($errors) == 0) 
			{

				$sql = "UPDATE reviewStatus SET ReviewerRecommendation = '$decision', WriterFeedback = '$writerComments', EditorFeedback = '$editorComments', InterimStatusUpdate = 'reviewed' WHERE AssignedSubmissionID = '$submissionID' AND AssignedReviewerEmail = '$email'";		
				
					if ($db->query($sql) === TRUE) 
					{
						//echo "New record created successfully";
						echo "<b><center>Submitted!</center></b>";
					} 
					
					else 
					{
						echo "Error: " . $sql . "<br>" . $db->error;
					}


			}

			

		}


?>