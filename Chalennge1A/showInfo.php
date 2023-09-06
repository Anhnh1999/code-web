<?php
require('index.php');
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
} else {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $conn->prepare("SELECT username, fullname, email, phone, id FROM users WHERE id = ?");
        $stmt->bind_param("i", $id); // "i" indicates an integer parameter
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Assigned variable for message feature
        $receiver = $user['username'];
        $sender = $_SESSION['username'];
       
    } else {
        echo "<p id='error-message' style='color: red; text-align: center;'>Invalid URL.</p>";
        exit();
    }
?>
    <html>
    <style>
        /* Your CSS styles here */
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
                <h3> <font color="red"><?php echo $user['fullname']; ?></font> Information</h3>
                Full Name:<br><input type="text" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>" readonly />
                <br><br>
                Phone Number:<br><input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" readonly />
                <br><br>
                Email:<br><input type="text" id="email" name="email" value="<?php echo $user['email']; ?>" readonly />
                <br><br>
                <br><br><br>
                <div class="chat-container">
                    <?php
                    // $sender = $_SESSION['username'];
                    // Prepare the SQL query
                    $sql = "SELECT message_id, sender,  message, times  FROM chats where receiver ='".$receiver."'";
                    $stmt = $conn->prepare($sql);

                    // Execute the prepared statement
                    $stmt->execute();

                    // Bind the result variables
                    $stmt->bind_result($messageId, $sender, $message, $time);

                    // Fetch and display the results
                    while ($stmt->fetch()) {
                    ?>
                        <div class="message">
                        <?php echo "\t\t\t"; ?>
                            <span class="sender-username"><?php echo $sender; ?>:</span>
                            <?php echo "\t\t\t"; ?>
                            <span class="sender-message"><?php echo $message; ?></span>
                            <?php echo "\t\t\t"; ?>
                            <span class="time"><?php echo $time; ?></span>
                            <?php echo "\t\t\t"; ?>
                            <?php if ($sender === $_SESSION['username']) { 
                                echo "<a href='editMessage.php?id=".$messageId."'><button type='button'>edit</button></a>";
                                echo "<a href='deleteMessage.php?id=".$messageId."'><button type='button'>delete</button></a>";
                           } ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <h3>Leave <font color="red"><?php echo $user['fullname']; ?></font> a message</h3>
                <form method="post" action="">
                    Message:<br><input type="text" id="message" name="message" required />
                    <input class="button" type="submit" id="reloadButton" value="Enter" />
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $time = date("Y-m-d H:i:s");
                        $message = $_POST['message'];
                        $stmt = $conn->prepare("INSERT INTO chats (sender, receiver, message, times) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("ssss", $sender, $receiver, $message, $time);
                        if ($stmt->execute())
                        {
                        ?>
                        <script>
                            document.querySelector(".button").addEventListener("click", function() 
                            {
                                window.location.reload();
                            });
                        </script>
                        <?php
                        } else {
                            echo "Error inserting message: " . $stmt->error;
                        }

                        $stmt->close();
                        $conn->close();
                    }
                    ?>
                </form>
            </div>
        </blockquote>

    </body>

    </html>
<?php
}
?>
