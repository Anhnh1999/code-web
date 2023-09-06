<html>
<link rel="stylesheet" href="style.css">
<body>
<header>
<blockquote>
    <!-- <a href="index.php"><img src="image/logo.png"></a> -->
</blockquote>
</header>
<blockquote>
<div class="container">
<center><h1>Login</h1></center>
<form action="handleLogin.php" method="post">
    Username:<br><input type="text" id="username" name="username" required/>
    <br><br>
    Password:<br><input type="password" id="password" name="password" required/>
    <br><br>
    <input class="button" type="submit" value="Login"/>
    <!-- <input class="button" type="button" name="cancel" value="Cancel" onClick="window.location='index.php';" /> -->
</form>
</div>
<blockquote>
<?php
    if (isset($_GET['error']) && $_GET['error'] === '1') 
    {
        echo "<p id='error-message' style='color: red;'>Login failed. Please check your credentials.</p>";
    }

?>
</body>
</html>