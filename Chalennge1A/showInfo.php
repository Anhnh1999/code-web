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
                $stmt = $conn->prepare("SELECT username, fullname, email, phone, id FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);            // "i" indicates an integer parameter
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc(); 

                //assigned variable for message feature
                $sender = $_SESSION['username'];
                $receiver = $user['username'];
            }
            else 
            {
                echo "<p id='error-message' style='color: red; text-align: center;'>Invalid URL.</p>";
                exit();
            }
    ?>
            <html>
            <style>
                .chat-container {
                    max-height: 300px;
                    overflow-y: auto;
                    border: 1px solid #ccc;
                    padding: 10px;
                }
                .message {
                    margin-bottom: 10px;
                    padding: 5px;
                    border: 1px solid #ccc;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
                .sender-message {
                    background-color: #f2f2f2;
                    font-weight: bold;
                    margin-right: 10px;
                }
                .receiver-message {
                    background-color: #e2f9ff;
                }
                .message-content {
                    flex: 1;
                }
                .time {
                    font-size: 12px;
                    color: #888;
                }
            </style>
            <link rel="stylesheet" href="style.css">
            <body>
            <header>
            </header>
            <blockquote>
                <div class="container">
                    <h3> <font color="red"><?php echo $user['fullname']; ?></font> Infomation</h3>
                    Full Name:<br><input type="text" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>" readonly/>
                    <br><br>
                    Phone Number:<br><input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" readonly/>
                    <br><br>
                    Email:<br><input type="text" id="email" name="email" value="<?php echo $user['email']; ?>" readonly/>
                    <br><br>
                        <h3>Leave  <font color="red"><?php echo $user['fullname']; ?></font> a message</h3>
                        <form method="post" action="">
                            Message:<br><input type="text" id="message" name="message" required/>
                            <br><br><br>
                            <div class="chat-container">
                                <?php
                                // Prepare the SQL query
                                $sql = "SELECT sender, receiver, message, times FROM chats";
                                $stmt = $conn->prepare($sql);

                                // Execute the prepared statement
                                $stmt->execute();

                                // Bind the result variables
                                $stmt->bind_result($sender, $receiver, $message, $time);

                                // Fetch and display the results
                                while ($stmt->fetch()) 
                                {
                                    $isSender = ($sender === $_SESSION['username']);             // Replace with your logic for determining the sender
                                ?>

                                <div class="message">
                                    <div class="<?php echo $isSender ? 'sender-message' : 'receiver-message'; ?>"><?php echo $isSender ? $sender : $receiver; ?>:</div>
                                    <div class="message-content"><?php echo $message; ?></div>
                                    <span class="time"><?php echo $time; ?></span>
                                </div>
                                <?php
                                }

                                // Close the statement and connection
                                $stmt->close();
                                $conn->close();
                                ?>
                            </div>
                            <input class="button" type="submit" value="Enter"/>
                        </form>
                </div>
            <blockquote>
            </body>
            </html>
            <?php
        }
?>