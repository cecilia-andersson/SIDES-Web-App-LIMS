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
        $yearnow = date("Y");
        $useryear = substr($personalnumber, 0, 4);
        $age = $yearnow - $useryear;

        if (substr($age, 1, 2) > 5){
            $agerange = substr($age, 0, 1) . "6" . "-" . substr(($age+1), 0, 1) . "0";
        }
        else{
            $agerange = substr($age, 0, 1) . "0" . "-" . substr(($age+1), 0, 1) . "5";
        }
        $sql = "SELECT * FROM users WHERE username = '$loggedInUser'";
        $result = $link->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
        }

        echo "<p> User profile of: $loggedInUser </p>";
        echo "<p> Age: $agerange </p>";
        echo "<p> Email address: $email </p>"; // this cannot be displayed if salted and hashed
        
    }

    ?>
    <form action="edit_myprofile.php">
        <input type="submit" value="Edit profile" />
    </form>

    <?php
        include "../footer.php";
    ?>
</body>

</html>