<!DOCTYPE html>
<html>
<head>
    <title>Configure SIDES</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <?php
        include "../navigation.php";
        ?>
<style>
    .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        overflow-y: auto; /* Enable vertical scrolling if content overflows */
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

<!-- connection and getting variables -->
<?php
    include "../DB_connect.php";
    session_start();

    if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
        $userid = $_SESSION['id'];
    }

    $userid = 1;


    include "../DB_connect.php";
    session_start();

    if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
        $userid = $_SESSION['id'];
    }

    $userid = 1;// for testing without session
    
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

    $sql_all_sE = "SELECT se_name, se_id FROM side_effects";
    $result_all_sE = $link->query($sql_all_sE);



    $sideEffectsData = [];
    while ($row = $result_all_sE->fetch_assoc()) {
        $sideEffectsData[] = $row;
    }

?>
<?php 

echo '<form action="../Logging_and_posts/submit_configure_log.php" method="post">';
echo '<div class="container">';
        //current chosen side effects
        echo '<div class="list">';
            if ($result->num_rows > 0) {
                echo '<h2>Chosen side effects:</h2>'; 
                echo '<ul>'; // Start unordered list
                while ($row = $result->fetch_assoc()) {
                    echo '<li><h3>' . $row['se_name'] . '</h2></li>';
                }
                echo '</ul>'; 
            } else {
                echo 'No side effects found, add some below!.'; 
            }
        echo '</div>';

        //the dropdowns 

        echo '<div class="dropdowns">';
            echo '<label for="options"><h2>Update chosen side effects:</h2></label><br><br>';

            for ($i = 0; $i < 10; $i++) {
                echo '<select id="options' . $i . '" name="options' . $i . '">';
                foreach ($sideEffectsData as $sideEffect) {
                    echo '<option value="' . $sideEffect['se_id'] . '">' . $sideEffect['se_name'] . '</option>';
                }
                echo '</select><br><br>';
            }
            echo '<input type="submit" value="Submit"></form>';

        echo '</div>';
    echo '</div>';

?>


</body>
<?php
    include "../footer.php";
    ?>
</html>