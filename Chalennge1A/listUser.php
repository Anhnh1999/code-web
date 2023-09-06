<?php
    require('index.php');
    if (!isset($_SESSION['id'])) 
    {
        header("Location: login.php");
        exit();
    }
    else
    {
            //get teachers info
            $sql = "SELECT fullname, id FROM users  WHERE role = 'teacher'";
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();   
            ////get students info
            $sql1 = "SELECT fullname, id FROM users  WHERE role = 'student'";
            $result1 = $conn->query($sql1);
            $user1 = $result1->fetch_assoc();   
           ?>
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    table 
                    {
                        /* border-collapse: collapse; */
                        width: 99%;
                        margin: 0 auto;
                    }
                    th, td 
                    {
                        border: 1px solid black;
                        padding: 4px;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <h1>Teacher List</h1>
                <table>
                    <tr>
                        <th>Full Name</th>
                        <th>action </th>
                    </tr>
                    <?php
                        do
                        {
                            
                            echo "<tr>";
                            echo "<td>" . $user["fullname"] . "</td>";
                            echo "<td>";
                            if($_SESSION['fullname'] ===  $user["fullname"])
                            {
                                continue;
                            } 
                            else
                            {
                                echo "<a href='showInfo.php?id=".$user["id"]."'><button type='button'>showInfo</button></a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }while ($user = $result->fetch_assoc()) 
                    ?>
                </table>
                <h1>Students List</h1>
                <table>
                    <tr>
                        <th>Full Name</th>
                        <th>action </th>
                    </tr>
                    <?php
                        do
                        {
                            echo "<tr>";
                            echo "<td>" . $user1["fullname"] . "</td>";
                            echo "<td>";
                            if($_SESSION['role'] === 'teacher')
                            {
                                echo "<a href='edit.php?id=".$user1["id"]."'><button type='button'>edit</button></a>";
                            }     
                            if($_SESSION['fullname'] ===  $user1["fullname"])
                            {       
                                continue;             
                                
                            }
                            else
                            {
                                echo "<a href='showInfo.php?id=".$user1["id"]."'><button type='button'>showInfo</button></a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }while ($user1 = $result1->fetch_assoc()) 
                    ?>
                </table>
            </body>
            </html>  
        <?php  
    }   
    $conn->close();
?>