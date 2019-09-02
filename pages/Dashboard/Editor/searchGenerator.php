<?php
//This class generates a the cells for the search results in editor.php

$db = mysqli_connect('localhost', 'root', '', 'journal');

if (isset($_POST['searchButton'])){
	$searchValue = $_POST['search'];

	$searchQuery = "SELECT * FROM submissionProfile WHERE paperTitle LIKE '%$searchValue%' OR email LIKE '%$searchValue%' OR topic LIKE '%$searchValue%' OR authors LIKE '%$searchValue%'";
	$result = mysqli_query($db, $searchQuery);

	//generate cell information from DB
	while ($row = mysqli_fetch_assoc($result)){
		echo '<tr>';
			echo '<td>' . $row['submissionId'] . '</td>';
			echo '<td>' . $row['paperTitle'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['topic'] . '</td>';
			echo '<td>' . $row['PaperStatus'] . '</td>';
			echo '<td>' . $row['dateOfSubmission'] . '</td>';
			echo '<td><button type="submit" formaction="../Writer/viewPDF.php" name = "viewPDF" value =' . $row['submissionId'] . '>View PDF</button></td>';
		echo '</tr>';
	}
	echo '<table>';
}
?>