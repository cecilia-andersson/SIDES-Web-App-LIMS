<!DOCTYPE html>
<html>

<head>
    <title>SIDES configured!</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <?php
    include "../navigation.php";
    ?>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            overflow-y: auto;
            /* Enable vertical scrolling if content overflows */
            margin-top: 5%;
        }

        .list {
            width: 45%;
        }

        .dropdown {
            width: 45%;
        }
    </style>

</head>

<body>
    <div class="white">

        <?php
        //DB connect
        include "../DB_connect.php";
        session_start();

        if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
            $userid = $_SESSION['id'];
        }
        //
        


        $updatedSides = '';

        for ($i = 0; $i < 10; $i++) {
            $updatedSides .= $_POST["options$i"] . ','; // Concatenate with ,
        }
        $updatedSides = rtrim($updatedSides, ',');


        echo $updatedSides;


        $sql = "UPDATE users SET chosensides=? WHERE userid=?";
        $stmt2 = $link->prepare($sql);
        $stmt2->bind_param("ss", $updatedSides, $userid);
        $result = $stmt2->execute();

        if ($result) {
            echo "Update successful!";
        } else {
            echo "Error: " . $stmt2->error;
        }


        $user_sides_sql = 'SELECT users.chosensides FROM users WHERE userid = ?';
        $stmt = $link->prepare($user_sides_sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $userSides = $result->fetch_assoc();
        $sideEffectIds = explode(',', $userSides['chosensides']);

        $chosenSideEffectsSql = 'SELECT side_effects.se_id, side_effects.se_name FROM side_effects WHERE se_id IN (' . implode(',', array_fill(0, count($sideEffectIds), '?')) . ')';
        $stmt = $link->prepare($chosenSideEffectsSql);
        $stmt->bind_param(str_repeat('i', count($sideEffectIds)), ...$sideEffectIds);
        $stmt->execute();
        $result = $stmt->get_result();



        ?>

        <br>
        <h2>Your SIDES have been updated!</h2>
        <br>

        <?php

        echo '<div class="list">';
        if ($result->num_rows > 0) {
            echo '<h2>Chosen side effects:</h2>';
            echo '<ul>'; // Start unordered list
            while ($row = $result->fetch_assoc()) {
                echo '<li><h3>' . $row['se_name'] . '</h2></li>';
            }
            echo '</ul>';
        } else {
            echo "No side effects found. Add some <a href='..\Logging_and_posts\process_form.php>now</a>. ";
        }
        echo '</div>';


        ?>


        <br>
        <form action="../user_profile/myprofile.php" method="POST">
            <input type="submit" value="My profile">
        </form>

    </div>
</body>
<?php
include "../footer.php";
?>

</html>