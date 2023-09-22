<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
    <style>
        body {}

        .register-button {}
    </style>
    <h3 style="color: #9510AC; display: inline;">SID</h3><h3 style="color: #246F8A; display: inline;">ES</h3>
    <nav style="display: inline;">
        <a href="../Drug_profile/nice_search_page.php">Search</a>
        <a href="../index.php">Home</a>
        <a href="#">Contact</a>
        <a href="#">About us</a>
        <a href="#">My profile</a>
        <a href="#">Forum</a>
    </nav>
    <form action="login_page.php" style="display: inline">
        <input type="submit" value="Log in">
    </form>
    <form action="register.php" style="display: inline">
        <input type="submit" value="Register">
    </form>
</head>
<h2> Create your SIDES account right now baby </h2>


<body>
    <!-- POST / PUT? Urlencode? -->
    <form action="insertdata.php" method="POST">
        Username: <input type="text" name="username" required> <br>
        Password: <input type="password" name="pwd" pattern="^(?=.*[A-Z])(?=.*\d).+$"
            title="Password must contain at least one capital letter and one number." required> <br>
        Personal Identity Number: <input type="text" name="personnmr" placeholder="YYYYMMDDXXXX"
            pattern="(19[0-9]{2}|20[0-1][0-5])[0-9]{8}" required> <br>
        <input type="submit" value="Add" class="register-button"><br>

    </form>
    <?php
    if (isset($_GET['Message'])) {
        echo $_GET['Message'];
    }
    ?>
</body>

</html>