   <?php

    //connect to DB
    $db = mysqli_connect('localhost', 'root', '', 'journal');

        if (isset($_POST['reviewPreference'])) 
        {
               $message = $_POST['reviewPreference'];
			   list($email, $submissionId) = explode("/", $message);  //splits the input string into components based on spaces


				//if title paper is not unique then return as error
				$user_check_query = "SELECT * FROM reviewerSelection WHERE reviewerEmail='$email' AND submissionId='$submissionId'  LIMIT 1";
				$result = mysqli_query($db, $user_check_query);
				$userPaper = mysqli_fetch_assoc($result);
	
			
				//doing error checks (to avoid creating duplicate entries in the table)
				if ($userPaper) 
				{
					if ($userPaper['submissionId'] === $submissionId) 
					{
						echo "<b><center>You have already requested to review this paper.</center></b>";
					}
					return;
				}


               //create a new entry in the reviewerSelection table 
               $user_check_query = "INSERT INTO reviewerSelection (reviewerEmail, submissionId) VALUES ('$email', '$submissionId')";
			   
			   if ($db->query($user_check_query) === TRUE) 
			   {
					//echo "New record created successfully";
					echo "<b><center>Selection was successful</center></b>";
				} 
					
				else 
				{
					echo "Error: " . $sql . "<br>" . $db->error;
				}

               
               
        }
        

        ?>



 