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
  <div class="header-right">
    <a href="logout.php">Logout</a>
  </div>
</div>

<div style="padding-left:20px">
  <h1>Responsive Header</h1>
  <p>Resize the browser window to see the effect.</p>
  <p>Some content..</p>
</div>

</body>
</html>