<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        body section {
            border: 2px solid #757CB3;
            border-radius: 5px;
            text-align: left;
            max-width: fit-content;
            margin-bottom: 10px;
        }

        p {
            margin: 3px;
            padding: 5px;
            font-weight: 300;
        }

        b {
            font-weight: normal;
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
    <h2>Edit your profile </h2>
    <?php

    if (isset($_SESSION['username'])) {
        $loggedInUser = $_SESSION['username'];
        $userid = $_SESSION['id'];

        $sql = "SELECT * FROM users WHERE userid = '$userid'";
        $result = $link->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
        }

        echo "<section> <p> <b> Username:</b> $loggedInUser </p>";
        echo "<p> <b>Email:</b> $email </p> </section>";
    }
    ?>
    <p>
    <form action="change_username.php" method="POST">
        <input type="text" name="new_username" placeholder="New Username" required>
        <input type="submit" value="Change username"><br>
    </form>
    </p>
    <p>
    <form action="change_email.php" method="POST">
        <input size="50" type="email" name="new_email" placeholder="New Email Adress (example@email.com)" required>
        <input type="submit" value="Change email"><br>
    </form>
    </p>
    <?php
    if (isset($_GET['Message'])) {
        echo $_GET['Message'];
    }
    
    include "../footer.php";
    ?>
</body>

</html>