<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        body {}

        .register-button {}

    </style>
</head>


<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <div class="white">

        <h2> Register </h2>

        <form action="insertdata.php" method="POST">
            <p>
                <input type="text" name="username" placeholder="Username" required>
            </p>
            <p>
                <input type="password" name="pwd" pattern="^((?=.*[A-Z])(?=.*\d).+)([a-zA-Z1-9]){7,}$"
                    title="Password must contain at least one capital letter and one number." placeholder="Password"
                    required>
            </p>
            <p>
                <input type="text" name="personnmr" placeholder="Personal Identity Number (YYYYMMDDXXXX)"
                    pattern="(19[0-9]{2}|20[0-9][0-9])[0-9]{8}" required>
            </p>
            <p>
                <input size="50" type="email" name="email" placeholder="E-mail (example@email.com)" required>
            </p>
            <?php echo 'I have read and accept SIDES <a href="http://localhost:443/user_profile/privacypolicy.php">privacy policy</a>.'; ?>
            <p>
                <input type="checkbox" name="acceptGDPR" value="I accept" required>
            </p>
            <input type="submit" value="Submit"><br>
        </form>
        <?php
        if (isset($_GET['Message'])) {
            echo $_GET['Message'];
        }
        ?>

    <?php
    include "../footer.php";
    include "../Powerpoint_overlays/register_slides.php";
    ?>
</body>

</html>