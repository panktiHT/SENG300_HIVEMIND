   <?php

    //connect to DB
    $db = mysqli_connect('localhost', 'root', '', 'journal');

        if (isset($_POST['viewPDF'])) 
        {
               $submissionId = $_POST['viewPDF'];

                //go into mySQL to retrive pdf profile ID 
                $user_check_query = "SELECT pdfSubmission FROM submissionProfile WHERE submissionId = '$submissionId' LIMIT 1";

                $result = $db->query($user_check_query);

                while ($row = $result->fetch_assoc()) 
                {
                    $fileName1 = $row['pdfSubmission'];

                    //check if this file existis
                    $dir = "../../../uploads/"; // trailing slash is important
                    $file = $dir . $fileName1;


                    //now retrieve this file from the server if it exists 
                    if (file_exists($file)) 
                    {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename='.basename($file));
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file));
                        ob_clean();
                        flush();
                        readfile($file);
                        exit;
                    } 
                    
                    else 
                    {
                        echo "The file $file does not exist";
                    }
                }
               
               
        }
        

        ?>



 