<?php
    require('index.php');
    if (!isset($_SESSION['id'])) 
    {
        header("Location: login.php");
        exit();
    }
    else
    {
        
        if (isset($_GET['id'])) 
        {
            $id = (int)$_GET['id'];
            $stmt = $conn->prepare("SELECT *  FROM chats WHERE message_id = ?");
            $stmt->bind_param("i", $id);            // "i" indicates an integer parameter
            $stmt->execute();
            $result = $stmt->get_result();
            $chats = $result->fetch_assoc(); 
        }
    }    
    ?>
            <html>
            <link rel="stylesheet" href="style.css">
            <body>
            <header>
            </header>
            <blockquote>
            <form method="post" action="">
                <div class="container">
                    Message:<br><input type="text" id="message" name="message" value="<?php echo $chats['message']; ?>" required/>
                    <br><br>
                    <input class="button" type="submit" value="Edit"/>
                </div>
            </form>
            <blockquote>
            <?php
                
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                $message = $_POST['message'];

                $stmt = $conn->prepare("UPDATE chats SET message = ? WHERE message_id = ?");
                $stmt->bind_param("si", $message, $id);      // "ssi" indicates string, string, integer parameters
            
                if ($stmt->execute()) {
                    header("Location: {$_SERVER['HTTP_REFERER']}");
                    exit();
                } else {
                    $message = "Error updating user information: " . $stmt->error;
                }
                echo "<p id='message' style='color: green;'>'".$message."'</p>";
                // Close the prepared statement
                $stmt->close();

            ?>
            </body>
            </html>
            <?php
            }

?>