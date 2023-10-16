<!DOCTYPE html>
<html>

<head>
    <title>Reports</title>
    <link href="/images/SIDES_head_icon.png" rel="icon">
</head>

<body>
    <header>
        <?php
        include "navigation.php";
        include "DB_connect.php";
        ?>
        <style>
            table {
                width: fit-content;
                box-shadow: 0 0 5px #64a7ac;
                font-size: 16px;

            }

            tr th {
                background-color: ;
                text-align: left;
                border: none;
                text-align: center;
            }

            td {
                border-right: none;
                border-left: none;
                text-align: center;
                padding: 1rem;
            }
        </style>
    </header>
    <h2> Daily Logging </h2>
    <?php
    if (isset($_GET['day']) && isset($_GET['year']) && isset($_GET["month"])) {
        $day = $_GET['day'];
        $month = $_GET['month'];
        $year = $_GET['year'];

        echo "<p>Date: $day/$month $year</p>";
        if (strlen($day) == 1) {
            $day = '0' . $day;
        }
        $date = $year . '-' . $month . '-' . $day . ' ' . '00:00:00';

        if (isset($_SESSION['id'])) {
            $loggedInUser = 1; #CHANGE THIS LATER
            $sql = "SELECT * FROM report WHERE userid = ? AND review_date = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("ss", $loggedInUser, $date);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table> <tr><th>Side effect</th><th>Intensity 1-10</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    $se_id = $row["side_effect"];
                    $intensity = $row["intensity"];

                    $sql1 = "SELECT se_name FROM side_effects WHERE se_id = $se_id";
                    $result1 = $link->query($sql1);
                    if ($result1->num_rows > 0) {
                        $row = $result1->fetch_assoc();
                        $sideeffect = $row["se_name"];
                        echo "<tr><td>$sideeffect</td><td>$intensity</td></tr>";

                    }
                }
                echo "</table>";
                ?>
                <form action='/user_profile/delete_log.php' method='POST'>
                    <input type='hidden' name='date' value='<?php echo $date; ?>'>
                    <input type='submit' name='delete_log' value='Delete daily log'> <br>
                </form>
                <?php

            } else {
                echo "You have not logged this day.";
            }

            $stmt->close();
        } else {
            echo "Not logged in.";
        }

    } else {
        echo "<p>The 'date' parameter is not specified</p>";
    }
    ?>
    <form action='/user_profile/myprofile.php' method='POST'>
        <input type='submit' name='return' value='Go back'> <br>
    </form>
    <?php

    include "footer.php";
    ?>

</body>
</html>