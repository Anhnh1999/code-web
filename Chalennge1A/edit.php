<?php
    require('index.php');
    if (!isset($_SESSION['id'])) 
    {
        header("Location: login.php");
        exit();
    }
    else
    {
        if($_SESSION['role'] === 'teacher')
        {
            if (isset($_GET['id'])) 
            {
                $id = (int)$_GET['id'];
                $stmt = $conn->prepare("SELECT username, fullname, email, phone, id FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);            // "i" indicates an integer parameter
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc(); 
            }
            else 
            {
                echo "<p id='error-message' style='color: red; text-align: center;'>Invalid URL.</p>";
                exit();
            }
    ?>
            <html>
            <link rel="stylesheet" href="style.css">
            <body>
            <header>
            <blockquote>
                <!-- <a href="index.php"><img src="image/logo.png"></a> -->
            </blockquote>
            </header>
            <blockquote>
            <form method="post" action="">
                <div class="container">
                    Full Name:<br><input type="text" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>" required/>
                    <br><br>
                    Phone Number:<br><input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required/>
                    <br><br>
                    Email:<br><input type="text" id="email" name="email" value="<?php echo $user['email']; ?>" required/>
                    <br><br>
                    <input class="button" type="submit" value="Edit"/>
                    <!-- <input class="button" type="button" name="cancel" value="Cancel" onClick="window.location='index.php';" /> -->
                </div>
            </form>
            <blockquote>
            <?php
                
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                $fullname = $_POST['fullname'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];

                $stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, phone = ? WHERE id = ?");
                $stmt->bind_param("sssi", $fullname, $email, $phone, $id);      // "ssi" indicates string, string, integer parameters
            
                if ($stmt->execute()) {
                    $message = "User information updated successfully.";
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
        }
    }

?>