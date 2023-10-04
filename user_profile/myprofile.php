<!DOCTYPE html>
<html>

<?php
include "../footer.php";
?>

<head>
    <title>My Profile</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        body section {
            border: 2px solid #757CB3;
            border-radius: 5px;
            position: relative;
            padding: 1rem;
            text-align: left;
            max-width: fit-content;
        }

        p {
            margin: 3px;
            font-weight: 300;
        }

        h4 {
            color: #757CB3;
            margin: 3px;
        }

        b {
            font-weight: normal;
        }

        .contraceptives {
            position: relative;
        }
        main{
            display: flex;
            justify-content: space-between;
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

    <h2>Your profile</h2>
    <main>
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
            ?>

            <div class='contraceptives'>
                <h4>Current contraceptives</h4>
                <?php
                $sql = "SELECT userid FROM users WHERE username = '$loggedInUser'";
                $result = $link->query($sql);
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $userid = $row["userid"];
                }

                $sql = "SELECT * FROM user_drug WHERE userid = $userid";
                $result = $link->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $drug_id = $row["drug_id"];
                        $date = $row["reg_date"];
                        $Date = date("Y-m-d", strtotime($date));
                        $sql1 = "SELECT drug_brand FROM drugs WHERE drug_id = $drug_id";
                        $result1 = $link->query($sql1);
                        if ($result1->num_rows > 0) {
                            $row = $result1->fetch_assoc();
                            $drug_brand = $row["drug_brand"];
                            echo "<p><a href='../Drug_profile/nice_drug_page.php?drug_id=$drug_id'>$drug_brand</a> since $Date</p>";
                        } else {
                            echo "<p>Drug_id does not exist in the drug table</p>";
                        }
                    }
                } else {
                    echo "<p>No reported contraceptives</p>";
                }
                echo "</div>";



                include "calendar.php";
                echo "<section>
        <p> <h4> About you </h4> <p>
        <p> <b> Username </b> <br> $loggedInUser </p>
        <p> <b> Age </b> <br> $agerange </p>
        <p> <b> Email </b> <br> $email </p>
        "; // this cannot be displayed if salted and hashed
        
        }
        ?>
            <form action="edit_myprofile.php">
                <input type="submit" value="Edit profile" style="background-color:#1A3038" />
            </form>

            </section>



    </main>
</body>

</html>