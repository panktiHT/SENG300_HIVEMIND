<?php
$errors = array();

//initialize error log (use for debugging). Ex;
//error_log(mysqli_error($db)); 
//prints the last sql query error to editorHandlerErrorlog
ini_set("log_errors", 1);
ini_set("error_log", "editorHandlerError.log");

$db = mysqli_connect('localhost', 'root', '', 'journal');

updateExpiredPapers($db);

//handles the "evaluate" button on the "To Do List" table
if (isset($_POST['evaluate'])){
	$submissionId = $_POST['evaluate'];
	
	$submissionQuery = "SELECT * FROM submissionProfile WHERE submissionId = '$submissionId'";
	$submission = mysqli_query($db, $submissionQuery);
	
	//echo paper information
	while ($row = mysqli_fetch_assoc($submission)){
		echo '<tr>';
			echo '<td>' . $row['submissionId'] . '</td>';
			echo '<td>' . $row['paperTitle'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['topic'] . '</td>';
			echo '<td>' . $row['PaperStatus'] . '</td>';
			echo '<td>' . $row['dateOfSubmission'] . '</td>';
		echo '</tr>';
	}
	echo '</table>';
	echo '<br \><br>';
	
	echo '<b><h2><center> Reviewer Feedback </center></h2></b><br>';
	echo 'These reviewers have not yet submitted a review:';
	
	$reviewerQuery = "SELECT * FROM reviewStatus WHERE AssignedSubmissionId = '$submissionId' AND InterimStatusUpdate != 'reviewed'";
	$incompleteReviewers = mysqli_query($db, $reviewerQuery);
	
	//echo which reviewers have not submitted a review
	while ($row = mysqli_fetch_assoc($incompleteReviewers)){
		echo $row['AssignedReviewerEmail'] . "&nbsp&nbsp";
	}
	
	//echo the column structure for the table displaying reviewer feedback
	echo '
	<table class = "table table-bordered">
	<tr>
		<th>&nbsp&nbspReviewer&nbsp&nbsp</th>
		<th>&nbsp&nbspReviewer Recommendation&nbsp&nbsp</th>
		<th>&nbsp&nbspFeedback for the Submitter&nbsp&nbsp</th>
		<th>&nbsp&nbspNotes to the Editor&nbsp&nbsp</th>
		<th>&nbsp&nbspWriter Resubmission Date&nbsp&nbsp</th>
	<tr>';
	
	$reviewStatusQuery = "SELECT * FROM reviewStatus WHERE AssignedSubmissionId = '$submissionId' AND InterimStatusUpdate = 'reviewed'";
	$reviewStatus = mysqli_query($db, $reviewStatusQuery);
	
	//echo the cell information for the table displaying reviewer feedback
	while ($row = mysqli_fetch_assoc($reviewStatus)){
		echo '<tr>';
			echo '<td>' . $row['AssignedReviewerEmail'] . '</td>';
			echo '<td>' . $row['ReviewerRecommendation'] . '</td>';
			echo '<td>' . $row['WriterFeedback'] . '</td>';
			echo '<td>' . $row['EditorFeedback'] . '</td>';
			echo '<td>' . $row['WritersResubmissionDate'] . '</td>';
		echo '</tr>';
	}
	
	echo '</table>';
	
	//echo the buttons that allow the editor to accept/reject papers
	echo '<form method="post"';
	echo '<div class="input-group">
			<center>
			<button type="submit" style="width:140px; class="btn" name="accept" value = ' . $submissionId .'>Accept</button>
			<button type="submit" style="width:300px; class="btn" name="acceptMinorRevision" value = ' . $submissionId .'>Accept With Minor Revisions</button>
			<button type="submit" style="width:300px; class="btn" name="acceptMajorRevision" value = ' . $submissionId .'>Accept With Major Revisions</button>
			<button type="submit" style="width:140px; class="btn" name="reject" value = ' . $submissionId .'>Reject</button>
		</div>';
}

//handles the "accept" button on the evaluatePaper.php page
if (isset($_POST['accept'])){
	$submissionId = $_POST['accept'];
	
	$updateQuery = "UPDATE submissionProfile SET PaperStatus = 'accepted' WHERE submissionId = '$submissionId'";
	$update = mysqli_query($db,$updateQuery);
	
	header('location: editor.php');
}

//handles the "Accept With Minor Revisions" button on the evaluatePaper.php page
if (isset($_POST['acceptMinorRevision'])){
	$submissionId = $_POST['acceptMinorRevision'];
	
	$updateQuery = "UPDATE submissionProfile SET PaperStatus = 'acceptMinor' WHERE submissionId = '$submissionId'";
	$update = mysqli_query($db,$updateQuery);
	
	header('location: editor.php');
}

//handles the "Accept With Major Revisions" button on the evaluatePaper.php page
if (isset($_POST['acceptMajorRevision'])){
	$submissionId = $_POST['acceptMajorRevision'];
	
	$updateQuery = "UPDATE submissionProfile SET PaperStatus = 'acceptMajor' WHERE submissionId = '$submissionId'";
	$update = mysqli_query($db,$updateQuery);
	
	header('location: editor.php');
}

//handles the "Reject" button on the evaluatePaper.php page
if (isset($_POST['reject'])){
	$submissionId = $_POST['reject'];
	
	$updateQuery = "UPDATE submissionProfile SET PaperStatus = 'rejected' WHERE submissionId = '$submissionId'";
	$update = mysqli_query($db,$updateQuery);
	
	header('location: editor.php');
}

//handles the "Add Reviewer" button on the "Papers Awaiting a Reviewer" table
if (isset($_POST['addReviewer']))
{
	$submissionId = $_POST['addReviewer'];
	
	$submissionQuery = "SELECT * FROM submissionProfile WHERE submissionId = '$submissionId'";
	$submission = mysqli_query($db, $submissionQuery);
	
	//echos cell information for paper information
	while ($row = mysqli_fetch_assoc($submission)){
		echo '<tr>';
			echo '<td>' . $row['submissionId'] . '</td>';
			echo '<td>' . $row['paperTitle'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['topic'] . '</td>';
			echo '<td>' . $row['PaperStatus'] . '</td>';
			echo '<td>' . $row['dateOfSubmission'] . '</td>';
		echo '</tr>';
	}
	echo '</table>';
	echo '<br \><br>';
	
	$reviewerQuery = "SELECT * FROM reviewStatus WHERE AssignedSubmissionID = '$submissionId'";
	$reviewers = mysqli_query($db, $reviewerQuery);
	
	if (mysqli_num_rows($reviewers) == 0){
		echo "There are no reviewers currently assigned to this submission";
	} else {
		echo "These are the reviewers currently assigned to this submission:";
		
		//echo reviewers currently assigned to the submission
		while ($row = mysqli_fetch_assoc($reviewers)){
			echo $row['AssignedReviewerEmail'] . "&nbsp&nbsp";
		}
	}
	
	echo '<br \><br>';
	
	
	echo "The submitter has requested these reviewers: ";
	$submissionQuery = "SELECT * FROM submissionProfile WHERE submissionId = '$submissionId'";
	$submission = mysqli_query($db, $submissionQuery);
	
	//echos reviewer preferences
	while ($row = mysqli_fetch_assoc($submission)){
		echo $row['reviewerPreference1'] . "&nbsp&nbsp";
		echo $row['reviewerPreference2'] . "&nbsp&nbsp";
		echo $row['reviewerPreference3'];
	}
	
	//echos paper preferences
	echo "<br \><br>These reviewers have requested to review this paper: ";
	$reviewerSelectionQuery = "SELECT * FROM reviewerSelection WHERE submissionId = '$submissionId'";
	$reviewerSelectionResult = mysqli_query($db, $reviewerSelectionQuery);
	while ($reviewerSelection = mysqli_fetch_assoc($reviewerSelectionResult)){
		echo $row['reviewerEmail'] . "&nbsp&nbsp";
	}
	
	
	//echos the form that allows the editor to assign a reviewer to a paper
	echo '<br \><br><br>';
	echo '<form method="post">
		<div class="input-group">
			<label>Enter the E-mail of the reviewer you would like to assign to this paper</label>
			<input type="text" name="email"" required>
		</div>
			<div class="input-group">
			<label>Enter the review deadline</label>
			<input type="date" name="reviewDeadline" required>
		</div>
			</div>
			<div class="input-group">
			<label>Enter the resubmission deadline</label>
			<input type="date" name="resubmissionDeadline" required>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="add" value = ' . $submissionId .'>Add</button>
		</div>
	</form>	';
}

//handles the create a reviewer field on the editor page.
if (isset($_POST['createReviewer'])){
	$enteredEmail = $_POST['enteredEmail'];

	$validEmailQuery = "SELECT * FROM userProfile WHERE email = '$enteredEmail'";
	$validEmail = mysqli_query($db, $validEmailQuery);
	
	if (mysqli_num_rows($validEmail) == 0){
		array_push($errors, "This user does not exist");
	} else {
		$userProfile = mysqli_fetch_assoc($validEmail);
		if ($userProfile['userType'] == 'writer'){
			
			//privileges are assigned when the user exists and has writer privileges
			$updateTypeQuery = "UPDATE userProfile SET userType = 'reviewer' WHERE email = '$enteredEmail'";
			$result = mysqli_query($db, $updateTypeQuery);
			
			echo 'Succesfully assigned privileges';
		} else {
			array_push($errors, "This user already has reviewer privileges");
		}
	}
	
}

//handles the add button the addReviewer page
if (isset($_POST['add']))
{
	$email = $_POST['email'];
	$submissionId = $_POST['add'];

	//check if the email belongs to a reviewer
	$validEmailQuery = "SELECT * FROM userProfile WHERE email = '$email' AND userType = 'reviewer'";
	$validEmail = mysqli_query($db, $validEmailQuery);
	
	$alreadyAssignedQuery = "SELECT * FROM reviewStatus WHERE AssignedreviewerEmail = '$email' AND AssignedSubmissionID = '$submissionId'";
	$alreadyAssigned = mysqli_query($db, $alreadyAssignedQuery);
	
	
	if (mysqli_num_rows($alreadyAssigned) > 0){
		array_push($errors, "This reviewer is already assigned to this paper");
	}
	else if (mysqli_num_rows($validEmail)){

		$assignedDeadlineReviewer = $_POST['reviewDeadline'];
		$writerResubmissionDate = $_POST['resubmissionDeadline'];
	
		//updates tables to reflect the selected reviewer being assigned a paper
		$query = "INSERT INTO reviewStatus (AssignedSubmissionID, AssignedReviewerEmail, AssignedDeadlineReviewer, InterimStatusUpdate,WritersResubmissionDate) 
		 VALUES('$submissionId', '$email', '$assignedDeadlineReviewer', 'submitted', '$writerResubmissionDate')";
		$result = mysqli_query($db,$query);
		
		$updateSubmission = "UPDATE submissionProfile SET PaperStatus = 'underReview' WHERE submissionId = '$submissionId'";
		mysqli_query($db,$updateSubmission);
		
		$updateNumReviewers = "UPDATE submissionProfile SET numReviewers = numReviewers + 1 WHERE submissionId = '$submissionId'";
		mysqli_query($db,$updateNumReviewers);

		header('location: editor.php');

		
		
	} else {
		array_push($errors, "Please enter a valid reviewer E-mail");
	}
}

//function that returns true if $month is in the same quarter as the current date.
//param: $month int (1-12)
function thisQuarter($month){
	$currentMonth = (int)date('m');
	
	if (($currentMonth == 1 || $currentMonth == 2 || $currentMonth == 3) && ($month == 1 || $month == 2 || $month == 3)){
		return true;
	}
	if (($currentMonth == 4 || $currentMonth == 5 || $currentMonth == 6) && ($month == 4 || $month == 5 || $month == 6)){
		return true;
	}
	if (($currentMonth == 7 || $currentMonth == 8 || $currentMonth == 9) && ($month == 7 || $month == 8 || $month == 9)){
		return true;
	}
	if (($currentMonth == 10 || $currentMonth == 11 || $currentMonth == 12) && ($month == 10 || $month == 11 || $month == 12)){
		return true;
	}
	return false;
}

//function that updates the database. 
//All papers that are not in the current quarter that have not been accepted with major/minor revisions
//will be assigned to "expired" status and subsequently not displayed on the editor's to do list.
//@param the link to the database to update
function updateExpiredPapers($dbLink){
	$papersQuery = "SELECT * FROM submissionProfile WHERE paperStatus = 'submitted' OR paperStatus = 'underReview'";
	$papersResult = mysqli_query($dbLink, $papersQuery);
	
	while ($paper = mysqli_fetch_assoc($papersResult)){
		$dateSubmitted = $paper['dateOfSubmission'];
		
		$month = (int) substr($dateSubmitted,5,2);
		
		if (!thisQuarter($month)){
			$submissionId = $paper['submissionId'];
			$updateQuery = "UPDATE submissionProfile SET paperStatus = 'expired' WHERE submissionId = '$submissionId'";
			$updateResult = mysqli_query($dbLink,$updateQuery);
		}
	}
	
}

?>