<?php
    require('index.php');
    if (!isset($_SESSION['id'])) 
    {
        header("Location: login.php");
        exit();
    }
    else
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {

            

            $time = date("Y-m-d H:i:s");
            $message = $_POST['message'];
            $stmt = $conn->prepare("INSERT INTO chats (sender, receiver, message, times) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $sender, $receiver, $message, $time);
            if ($stmt->execute()) 
            {
                echo "Message inserted successfully.";
            } else 
            {
                echo "Error inserting message: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();

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
                    <?php echo $time; ?> <?php echo $sender; ?><br>: <?php echo $message; ?>
                    <br><br>
                </div>
            </form>
            <blockquote>
            
            </body>
            </html>
            <?php
     }
