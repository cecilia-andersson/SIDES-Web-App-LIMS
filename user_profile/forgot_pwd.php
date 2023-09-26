<!DOCTYPE html>
<html>

<head>
    <title>Forgot password</title>
    <link href="../images/S.png" rel="icon">
</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <h3> Log in </h3>
    <p>
    <form action="send_email.php" method="POST">
        Email: <input size="50" type="email" name="email" placeholder="example@email.com" required> <br>
        <input type="submit" value="Send new password"> <br>
    </form>
    <?php
    if (isset($_GET['Message'])) {
        echo $_GET['Message'];
    }
    ?>
    </p>
</body>

</html>