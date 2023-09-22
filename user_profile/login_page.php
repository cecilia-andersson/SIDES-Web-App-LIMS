<html>
<link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->

<head>
<title>SIDES</title>
<h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline;">ES</h3>
<nav style="display: inline;">
    <a href="../index.php">Home</a>
    <a href="#">Contact</a>
    <a href="#">About us</a>
    <a href="#">My profile</a>
    <a href="#">Forum</a>
</nav>
</head>
<body>

<h3> Log in </h3>
<p>
    <?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "sides";
    // Create connection
    $link = mysqli_connect($servername, $username, $password, $dbname);
    // Check if connection is established
    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $link->close();
    ?>
    <form action="login.php" method="POST">
        Username: <input type="text" name="username" required> <br>
        Password: <input type="password" name="login_password" required> <br>
        <input type="submit" value="Login"> <br>
    </form>
    <?php
    if(isset($_GET['Message'])){
        echo $_GET['Message'];
    }
    ?>
    </p>
</body>
</html>