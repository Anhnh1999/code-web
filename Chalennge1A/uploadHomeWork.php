<?php
    require('index.php');
    if (!isset($_SESSION['id'])) 
    {
        header("Location: login.php");
        exit();
    }
    else
    {  
            //get students info
            $sql1 = "SELECT id, fullname FROM users  WHERE role = 'student'";
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
                            echo '<input type="checkbox" name="selected_users[]" value="' . $id . '"> User ' . $id;                          
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