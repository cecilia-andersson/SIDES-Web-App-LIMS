<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
</head>

<body>
    <header>
        <?php
        include "../navigation.php";
        include "../Powerpoint_overlays/login_slides.php";
        ?>
    </header>
    <div class="white">

        <h2> Sign in </h2>
        <p>
        <form action="login.php" method="POST">
            <p>
                <input type="text" name="username" placeholder="Username" required> <br>
            </p>
            <p>
                <input type="password" name="login_password" placeholder="Password" required> <br>
            </p>
            <input type="submit" value="Sign in"> <br>
        </form>
        <p>
            <a href="forgot_pwd.php">I forgot my password</a> <br><br>
        </p>
        <?php
        if (isset($_GET['Message'])) {
            echo $_GET['Message'];
        }
        ?>
        </p>
    </div>

    <?php
    include "../footer.php";
    ?>
</body>

</html>