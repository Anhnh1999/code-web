<?php
    $hostname = 'localhost:3306';
    $username = 'root';
    $password = '';
    $dbname = "chalennge1a";
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if (!$conn)
    {
        die('cannot connect to database!!!: ' . mysqli_error($conn));
        exit();
    }

?>