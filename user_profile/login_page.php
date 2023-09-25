<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->

<head>
    <title>Login</title>
    <h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline;">ES</h3>
    <nav style="display: inline;">
        <a href="../Drug_profile/nice_search_page.php">Search</a>
        <a href="../index.php">Home</a>
        <a href="contact.php">Contact</a>
        <a href="aboutus.php">About us</a>
        <a href="#">My profile</a>
        <a href="forum.php">Forum</a>
    </nav>
    <?php
    echo '<a href="login_page.php">Login</a>&nbsp;&nbsp;';
    echo '<a href="register.php">Register</a>';
    ?>
    <!--<form action="login_page.php" style="display: inline">
        <input type="submit" value="Log in">
    </form>
    <form action="register.php" style="display: inline">
        <input type="submit" value="Register">
    </form> -->
</head>

<body>

    <h3> Log in </h3>
    <p>
    <form action="login.php" method="POST">
        Username: <input type="text" name="username" required> <br>
        Password: <input type="password" name="login_password" required> <br>
        <input type="submit" value="Login"> <br>
    </form>
    <?php
    if (isset($_GET['Message'])) {
        echo $_GET['Message'];
    }
    ?>
    </p>
</body>

</html>