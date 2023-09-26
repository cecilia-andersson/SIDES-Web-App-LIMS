<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
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