<?php
//This class generates the cells for the reviewer table in editor.php

$db = mysqli_connect('localhost', 'root', '', 'journal');

$paperQuery = "SELECT * FROM submissionProfile WHERE PaperStatus='submitted' OR (numReviewers < '3' AND PaperStatus = 'underReview')";
$result = mysqli_query($db, $paperQuery);
	
	//generate cell information from DB
	while ($row = mysqli_fetch_assoc($result)){
		echo '<tr>';
			echo '<td>' . $row['submissionId'] . '</td>';
			echo '<td>' . $row['paperTitle'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['topic'] . '</td>';
			echo '<td>' . $row['PaperStatus'] . '</td>';
			echo '<td>' . $row['dateOfSubmission'] . '</td>';
			//The value of the button is set to be the same as the submission ID
			echo '<td><button type="submit" name = "addReviewer" value =' . $row['submissionId'] . '>Add Reviewer</button></td>';
			echo '<td><button type="submit" formaction="../Writer/viewPDF.php" name = "viewPDF" value =' . $row['submissionId'] . '>View PDF</button></td>';
		echo '</tr>';
	}
	echo '<table>';
?>