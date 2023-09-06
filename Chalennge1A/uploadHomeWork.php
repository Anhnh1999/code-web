<?php
function bytesToKB($bytes) 
{
    if ($bytes < 1024) 
    {
        return $bytes . ' B';
    } else {
        return round($bytes / 1024, 2) . ' KB';
    }
}
?>
<?php
    require('index.php');
    if (!isset($_SESSION['id'])) 
    {
        header("Location: login.php");
        exit();
    }
    else
    {
        $allowedExtensions = array("jpg", "jpeg", "png", "pdf", "doc", "docx");
        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
            // Process the selected students
            if (isset($_POST['userid']) && isset($_FILES['file'])) {
                // Get student ID
                $studentId = $_POST['userid'];
                $currentUser = $_POST["fullname"];

                // Define the directory where you want to store the uploaded files
                $uploadDirectory = getcwd() . '\\' . 'uploads';

                // Get the uploaded file's information
                $uploadedFileTmpName = $_FILES['file']['tmp_name'];
                $uploadedFileName = $_FILES['file']['name'];
                $uploadedFileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
                $UploadFileSize = bytesToKB($_FILES['file']['size']);


                $uploadFolder = $uploadDirectory . '\\' . $currentUser;
                
                // Check if the directory doesn't exist
                if (!is_dir($uploadFolder)) 
                {
                    // Create the directory with read/write permissions (0777)
                    if (mkdir($uploadFolder, 0777, true)) {
                        echo "New directory created for '".$currentUser."'";
                        echo "<br>\n";
                    } else 
                    {
                        echo 'Failed to create the directory.';
                    }
                }
              
                $uploadFile = $uploadDirectory . '\\' . $currentUser . "\\" . $uploadedFileName;

                if (!in_array(strtolower($uploadedFileExtension), $allowedExtensions)) {
                    echo "Invalid file type. Only " . implode(", ", $allowedExtensions) . " files are allowed.";
                } else {
                    if (move_uploaded_file($uploadedFileTmpName, $uploadFile)) {
                        //echo "The file " . htmlspecialchars($uploadedFileName) . " has been uploaded.";
                        // unlink($uploadFile);
                        
                        //set status for student homework
                        $stmt = $conn->prepare("UPDATE users SET homework = 1 WHERE id = ?");
                        $stmt->bind_param("i", $studentId);
                        

                        //insert file status into db 
                        $stmt1 = $conn->prepare("INSERT INTO homeworks (filename, filesize, fileext) VALUES (?, ?, ?)");
                        $stmt1->bind_param("sss", $uploadedFileName, $UploadFileSize, $uploadedFileExtension);
                        $stmt1->execute();

                        //get homework_id 
                        $sql = "SELECT homework_id from homeworks ORDER BY homework_id DESC LIMIT 1";
                        $result = $conn->query($sql);
                        $homework = $result->fetch_assoc();
                        $currentHomeWorkID = $homework['homework_id'];
                        

                        //create a new folder as filename is homework_id 
                        $uploadFolderID = $uploadDirectory . '\\' . $currentUser . '\\' .  $currentHomeWorkID;
                        if (!is_dir($uploadFolderID)) 
                        {
                            // Create the directory with read/write permissions (0777)
                            if (mkdir($uploadFolderID, 0777, true)) 
                            {
                                echo "New directory created '".$uploadFolderID."'";
                                echo "<br>\n";
                            } else 
                            {
                                echo 'Failed to create the directory.';
                            }
                        }
                        //file name to upload a homework in a uploadFolderID 
                        $uploadFileID = $uploadDirectory . '\\' . $currentUser . '\\' .  $currentHomeWorkID . '\\' . $uploadedFileName;

                        //upload homework to folder
                        if (copy($uploadFile, $uploadFileID)) 
                        {
                            echo "The file " . htmlspecialchars($uploadFileID) . " has been uploaded.";
                            unlink($uploadFile);
                            $message = "Upload homework successful";
                        } else 
                        {
                            $message = "Not uploaded because of error #".$_FILES["file"]["error"];
                        }
                        echo "<p id='message' style='color: orange;'>'" . $message . "'</p>";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                    // Close the prepared statement
                    $stmt->close();
                }
            }
        }

        // Get students' info
        $sql1 = "SELECT id, fullname FROM users WHERE role = 'student'";
        $result1 = $conn->query($sql1);
        
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <style>
            table {
                /* border-collapse: collapse; */
                width: 99%;
                margin: 0 auto;
            }

            th, td {
                border: 1px solid black;
                padding: 4px;
                text-align: center;
            }

            /* Center the button horizontally */
            .center-button {
                text-align: center;
            }

            /* Style the button (adjust as needed) */
            .my-button {
                padding: 10px 20px;
                background-color: #ff66ff;
                color: #fff;
                border: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <h1>Students List</h1>
        <?php
            while ($user1 = $result1->fetch_assoc()) {
                echo "<form method='post' action='' enctype='multipart/form-data'>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Full Name</th>";
                echo "<th>Upload Homework</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>" . $user1["fullname"] . "</td>";
                echo "<td>";
                echo '<input type="file" name="file" required>';
                echo '<input type="hidden" name="userid" id="userid"  value="' . $user1['id'] . '">';
                echo '<input type="hidden" name="fullname" id="fullname"  value="' . $user1['fullname'] . '">';
                echo "<input class='my-button' type='submit' name='submit' value='Upload Homework'>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "</form>";
                
            }
        ?>
    </body>
    </html>

<?php     
    }
    $conn->close();
?>
