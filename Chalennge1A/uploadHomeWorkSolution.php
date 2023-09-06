<?php
require('index.php');

// Define the upload directory outside the conditional blocks
$uploadDirectory = getcwd() . '\\' . 'uploads';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
} else {
    $allowedExtensions = array("jpg", "jpeg", "png", "pdf", "doc", "docx");

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
        // Process the selected students
        if (isset($_POST['userid']) && isset($_FILES['file'])) {
            // Get student ID and full name
            $studentId = $_POST['userid'];
            $currentUser = $_POST["fullname"];
            $homeWorkID = $_POST["homework_id"];

            // Define the directory where you want to store the uploaded files
            $uploadDirectory = getcwd() . '\\' . 'uploads';

            // Get the uploaded file's information
            $uploadedFileTmpName = $_FILES['file']['tmp_name'];
            $uploadedFileName = $_FILES['file']['name'];
            $uploadedFileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);

            $uploadFolder = $uploadDirectory . '\\' . $currentUser;

            // Create a "solutions" folder within the student's folder
            $solutionsFolder = $uploadFolder . '\\' . $homeWorkID . '\\solutions';
            if (!is_dir($solutionsFolder)) {
                if (mkdir($solutionsFolder, 0777, true)) {
                    echo "New solutions directory created for homework '".$homeWorkID."'";
                } else {
                    echo 'Failed to create the solutions directory.';
                }
            }

            // Set the upload path to the solutions folder
            $uploadFile = $solutionsFolder . '\\' . $uploadedFileName;

            if (!in_array(strtolower($uploadedFileExtension), $allowedExtensions)) {
                echo "Invalid file type. Only " . implode(", ", $allowedExtensions) . " files are allowed.";
            } else {
                if (move_uploaded_file($uploadedFileTmpName, $uploadFile)) {
                    echo "The file " . htmlspecialchars($uploadedFileName) . " has been uploaded to solutions folder.";

                    $stmt = $conn->prepare("UPDATE users SET homework = 1 WHERE id = ?");
                    $stmt->bind_param("i", $studentId);

                    if ($stmt->execute()) {
                        $message = "Upload homework successful";
                    } else {
                        $message = "Error updating user information: " . $stmt->error;
                    }
                    echo "<p id='message' style='color: green;'>'" . $message . "'</p>";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
                // Close the prepared statement
                $stmt->close();
            }
        }
    }

    // Home work information
    $sql = "SELECT * FROM homeworks";
    $result = $conn->query($sql);

    // Get students' info
    $sql1 = "SELECT id, fullname FROM users WHERE role = 'student'";
    $result1 = $conn->query($sql1);
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 99%;
            margin: 0 auto;
        }

        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }

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
<?php
while ($user1 = $result1->fetch_assoc()) {
    if ($user1['fullname'] === $_SESSION['fullname']) {
        // List directories in the student's folder
        $StudentHomeWork = $uploadDirectory . '\\' . $user1['fullname'];

        if (is_dir($StudentHomeWork)) {
            $directories = scandir($StudentHomeWork);

            foreach ($directories as $directory) {
                if ($directory !== '.' && $directory !== '..') {
                    $solutionsFolderPath = $StudentHomeWork . '\\' . $directory . '\\solutions';
                    if (!is_dir($solutionsFolderPath)) {
                        echo "<form method='post' action='' enctype='multipart/form-data'>";
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>Full Name</th>";
                        echo "<th>Homework Path</th>";
                        echo "<th>Upload Homework</th>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>" . $user1["fullname"] . "</td>";
                        echo "<td>" . $StudentHomeWork . '\\' . $directory . "</td>";
                        echo '<td>';
                        echo '<input type="file" name="file" required>';
                        echo '<input type="hidden" name="userid" id="userid"  value="' . $user1['id'] . '">';
                        echo '<input type="hidden" name="homework_id" id="homework_id"  value="' . $directory . '">';
                        echo '<input type="hidden" name="fullname" id="fullname"  value="' . $user1['fullname'] . '">';
                        echo "<input class='my-button' type='submit' name='submit' value='Upload Homework'>";
                        echo '</td>';
                        echo '</tr>';
                        echo "</table>";
                        echo "</form>";
                    }
                }
            }
        }
    }
}
?>
</body>
</html>

<?php
$conn->close();
?>
