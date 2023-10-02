<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        body section{
            border: 2px solid #757CB3;
            display: block;
            position: fixed;
            right: 10vw;
            top:15vh;
            padding: 1rem;
            text-align: left;
        }
    </style>
</head>

<body>
    <header>
        <?php
        include "../navigation.php";
        include "../DB_connect.php";
        ?>
    </header>

    <h2>My profile</h2>
    <?php
    if (isset($_SESSION['username'])) {
        $loggedInUser = $_SESSION['username'];
        $personalnumber = $_SESSION['personalnumber'];
        $yearnow = date("Y");
        $useryear = substr($personalnumber, 0, 4);
        $age = $yearnow - $useryear;

        if (substr($age, 1, 2) > 5) {
            $agerange = substr($age, 0, 1) . "6" . "-" . substr(($age + 1), 0, 1) . "0";
        } else {
            $agerange = substr($age, 0, 1) . "0" . "-" . substr(($age + 1), 0, 1) . "5";
        }
        $sql = "SELECT * FROM users WHERE username = '$loggedInUser'";
        $result = $link->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
        }

        echo "
        <section>
        <p> <b> Your information </b> </p>
        <p> Username: $loggedInUser </p>
        <p> Age: $agerange </p>
        <p> Email: $email </p>
        "; // this cannot be displayed if salted and hashed
    }

    ?>
    <form action="edit_myprofile.php">
        <input type="submit" value="Edit profile"/>
    </form>
    </section>

    <?php
    include "../footer.php";
    ?>
</body>
</html>