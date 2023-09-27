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

        echo "<p> User profile of: $loggedInUser </p>";
        echo "<p> Age: $agerange </p>";
    }

    ?>


</body>

</html>