<?php



//Connect DB
//Create query based on the ID passed from you table
//query : delete where Staff_id = $id
// on success delete : redirect the page to original page using header() method
$db = mysqli_connect('localhost', 'root', '', 'journal');



// Check connection
if (!$db) 
{
    die("Connection failed: " . mysqli_connect_error());
}


$id = $_POST['submissionId'];

// sql to delete a record
$sql = "DELETE FROM submissionProfile WHERE submissionId = $id"; 

if (mysqli_query($db, $sql)) 
{
    mysqli_close($db);
    header('Location: writer.php'); //If writer.php is your main page where you list your all records
    exit;
} 


else 
{
    echo "Error in deleting the record";
}


?>