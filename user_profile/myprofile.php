<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>
</head>

<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <?php

    session_start();

    if (isset($_SESSION['username'])) {
        $loggedInUser = $_SESSION['username'];
        echo "<p> User profile of: $loggedInUser </p>";
    }

    ?>


</body>

</html>