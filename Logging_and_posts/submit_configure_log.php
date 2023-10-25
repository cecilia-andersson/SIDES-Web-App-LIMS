<!DOCTYPE html>
<html>

<head>
    <title>SIDES configured!</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
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
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <div class="white">
        <?php
        //DB connect
        include "../DB_connect.php";

        if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
            $userid = $_SESSION['id'];
        }
        //
        
        $updatedSides = '';

        for ($i = 0; $i < 10; $i++) {
            $updatedSides .= $_POST["options$i"] . ','; // Concatenate with ,
        }
        $updatedSides = rtrim($updatedSides, ',');


        $sql = "UPDATE users SET chosensides=? WHERE userid=?";
        $stmt2 = $link->prepare($sql);
        $stmt2->bind_param("ss", $updatedSides, $userid);
        $result = $stmt2->execute();

        if ($result) {
            echo "<h3>Your SIDES have been updated!</h3>";
        } else {
            echo "<h4>Error: " . $stmt2->error.". No update</h4>";
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

        

        <?php

        echo '<div class="list">';
        if ($result->num_rows > 0) {
            echo "<h3 style='color:#757CB3;'>Chosen side effects:</h3>";
            echo '<ul>'; // Start unordered list
            while ($row = $result->fetch_assoc()) {
                echo '<li><h4>' . $row['se_name'] . '</h4></li>';
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