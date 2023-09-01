<?php
include "connectDB.php";

if(isset($_POST['username']) && isset($_POST['password']))
{
    $uname=$_POST['username'];
    $password = $_POST['password'];

    //hash password input to check with database 
    $hashedPassword = md5($password);

    // query DB
    $sql = "SELECT * FROM users WHERE username='".$uname."' AND password='".$hashedPassword."'";
    $result = $conn->query($sql);
    
    
    // Check if there's at least one row 
    if($result && $result->num_rows > 0)
    {
        $user = $result->fetch_assoc();
        if ($uname ===  $user['username'] && $hashedPassword ===  $user['password']) 
        {
            session_start();
            $_SESSION['id'] = $user['id'];         // Store user ID in session
            $_SESSION['role'] = $user['role'];          // Store user role in session
            $_SESSION['fullname'] = $user['fullname'];  // Store username in session
            $_SESSION['username'] = $user['username'];  // Store username in session
            header("Location: index.php");
        }
        else
        {
            // Failed login
            header("Location: login.php?error=1");      
        }
    }
    else
    {
        // Failed login
        header("Location: login.php?error=1");       
    }
}
?>