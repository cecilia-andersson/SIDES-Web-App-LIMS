<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
</head>

<body>
    <header>
        <?php
        include "../navigation.php";
        include "../DB_connect.php";
        ?>
    </header>
    <?php

    session_start();

    if (isset($_SESSION['username'])) {
        $loggedInUser = $_SESSION['username'];
        $personalnumber = $_SESSION['personalnumber'];

        $sql = "SELECT * FROM users WHERE username = '$loggedInUser'";
        $result = $link->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
        }

        echo "<p> User profile of: $loggedInUser </p>";
        echo "<p> Make user able to edit username, email etc. </p>";
        echo "<p> Email address: $email </p>"; // this cannot be displayed if salted and hashed
        
    }

    ?>
    

    <?php
        include "../footer.php";
    ?>
</body>

</html>