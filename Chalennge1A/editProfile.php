<?php
    require('index.php');
    if (!isset($_SESSION['id'])) 
    {
        header("Location: login.php");
        exit();
    }
    else
    {
        if($_SESSION['role'] === 'student')
        {
            $id = (int)$_SESSION['id'];
            $stmt = $conn->prepare("SELECT email, phone, password FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);             // "i" indicates an integer parameter
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc(); 
        }
        else 
        {
            exit();
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
                    Email:<br><input type="text" id="email" name="email" value="<?php echo $user['email']; ?>" required/>
                    <br><br>
                    Phone Number:<br><input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required/>
                    <br><br>
                    Current password:<br><input type="password" id="currentpassword" name="currentpassword" required/>
                    <br><br>
                    New Password:<br><input type="password" id="newpassword" name="newpassword" required/>
                    <br><br>
                    Verify Password:<br><input type="password" id="verifypassword" name="verifypassword" required/>
                    <br><br>
                    <input class="button" type="submit" value="change information"/>
                </div>
            </form>
            <blockquote>
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {

                $currentPassword = $_POST['currentpassword'];
                $newPassword = $_POST['newpassword'];
                $verifyPassword = $_POST['verifypassword'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];

                if($newPassword !== $verifyPassword)
                {
                    echo "<p id='error-message' style='color: red; text-align: center;'>new password does not match, please try again!!</p>";
                }
                else
                {

                    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
                    $stmt->bind_param("i", $id);             // "i" indicates an integer parameter
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc(); 

                    if($user['password'] === $currentPassword)
                    {
                        $newPassword = md5($verifyPassword);
                        $stmt = $conn->prepare("UPDATE users SET password = ?, email = ?, phone = ? WHERE id = ?");
                        $stmt->bind_param("sssi", $password, $email, $phone, $id);     // "ssi" indicates string, string, integer parameters
                    
                        if ($stmt->execute()) {
                            $message = "User information updated successfully.";
                        } else {
                            $message = "Error updating user information: " . $stmt->error;
                        }
                        echo "<p id='message' style='color: green;'>'".$message."'</p>";
                        // Close the prepared statement
                        $stmt->close();
                    }
                    else
                    {
                        echo "<p id='error-message' style='color: red; text-align: center;'>current password does not match, please try again!!</p>";
                        $stmt->close();
                    }
                }

            ?>
            </body>
            </html>
            <?php
            }
    }

?>