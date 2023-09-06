<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}
.header-left {
  float: left;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}
.chat-container 
{
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 10px;
}

.message 
{
    margin-bottom: 10px;
    padding: 5px;
    border: 1px solid #ccc;
    display: flex;
    flex-direction: row;
    align-items: center;
}

.sender-message 
{
    background-color: #f2f2f2;
    font-weight: bold;
    margin-right: 10px;
}

.receiver-message 
{
    background-color: #e2f9ff;
}

.message-content 
{
    flex: 1;
}

.time 
{
    font-size: 12px;
    color: #888;
}
</style>
<?php
    include "connectDB.php";
    session_start();
?>
</style>
</head>
<body>

<div class="header">

  <a class="active" href="index.php"><?php echo $_SESSION['fullname']?></a>
  <a href="ListUser.php">List User</a>
  <?php
    if($_SESSION['role'] === 'student')
    {
      echo '<a href="editProfile.php">Edit Profile</a>';
    }
  ?>
  <?php
    if($_SESSION['role'] === 'teacher')
    {
      echo '<a href="uploadHomeWork.php">Create HomeWork</a>';
    }
  ?>
  <?php
    if($_SESSION['role'] === 'student')
    {
      echo '<a href="uploadHomeWorkSolution.php">Get HomeWork</a>';
    }
  ?>
  <div class="header-right">
    <a href="logout.php">Logout</a>
  </div>
</div>
<?php
      
      $currentPage = basename($_SERVER['PHP_SELF']);
      if ($currentPage === 'index.php') 
      {
        echo '<div style="padding-left:20px">';
        echo '<div class="chat-container">'; 
        // $sender = $_SESSION['username'];
        // Prepare the SQL query
        $sql = "SELECT message_id, sender,  message, times  FROM chats where receiver ='".$_SESSION['username']."'";
        $stmt = $conn->prepare($sql);
        
        // Execute the prepared statement
        $stmt->execute();
        
        // Bind the result variables
        $stmt->bind_result($messageId, $sender, $message, $time);
        

        // Fetch and display the results
        while ($stmt->fetch()) 
        {
        ?>
          <div class="message">
          <?php echo "\t\t\t"; ?>
            <span class="sender-username"><?php echo $sender; ?>:</span>
            <?php echo "\t\t\t"; ?>
            <span class="sender-message"><?php echo $message; ?></span>
            <?php echo "\t\t\t"; ?>
            <span class="time"><?php echo $time; ?></span>
            <?php echo "\t\t\t"; ?>
          </div>
          <?php
        }
      }
?>
</body>
</html>