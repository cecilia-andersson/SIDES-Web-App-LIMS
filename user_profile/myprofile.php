<!DOCTYPE html>
<html>

<?php
// Validated and sanitized -- assuming sessions variables can't be edited.
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
            max-height: 210px;
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

        .all_content {
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
        <div class="all_content"> <!-- All content -->
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
                <div class="left_content"> <!-- Left content -->
                    <div class='contraceptives'> <!-- Contraceptives -->
                        <h4>Contraceptives</h4>
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
                            $noDrug = False;
                            while ($row = $result->fetch_assoc()) {
                                $EndDate = NULL;
                                $drug_id = $row["drug_id"];
                                $date = $row["startdate"];
                                $Date = date("Y-m-d", strtotime($date));
                                if ($row["enddate"] != NULL) {
                                    $enddate = $row["enddate"];
                                    $EndDate = date("Y-m-d", strtotime($enddate));
                                }
                                $sql1 = "SELECT drug_brand FROM drugs WHERE drug_id = $drug_id";
                                $result1 = $link->query($sql1);
                                if ($result1->num_rows > 0) {
                                    $row = $result1->fetch_assoc();
                                    $drug_brand = $row["drug_brand"];
                                    if ($EndDate == NULL) {
                                        echo "<p><a href='../Drug_profile/nice_drug_page.php?drug_id=$drug_id'>$drug_brand</a><br>since $Date</p>";
                                    } else {
                                        echo "<p><a href='../Drug_profile/nice_drug_page.php?drug_id=$drug_id'>$drug_brand</a><br>ended $EndDate</p>";
                                    }
                                } else {
                                    echo "<p>Drug_id does not exist in the drug table</p>";
                                }
                            }

                        } else {
                            $noDrug = True;
                            ?>
                            <p>No reported contraceptives</p>
                            <form action="../Forms/add_drug_form.php" method="POST">
                                <input type="submit" value="Add contraceptive">
                            </form>
                            <?php
                        }
                        ?>

                    </div> <!-- Contraceptives -->
                    <?php
                    // PROFILE INFO
                    echo "<br><section>
        <p> <h4> About you </h4> <p>
        <p> <b> Username </b> <br> $loggedInUser </p>
        <p> <b> Age </b> <br> $agerange </p>
        <p> <b> Email </b> <br> $email </p>
        "; // this cannot be displayed if salted and hashed
            
            }
            ?>
                <form action="edit_myprofile.php">
                    <input type="submit" value="Edit info" style="background-color:#1A3038" />
                </form>
                </section> <!--Profile info-->
            </div><!-- Left content -->


            <?php
            include "calendar.php";
            ?>

            <div class="forms"><!--Forms-->
                <br>
                <p>
                    <strong>Something doesn't look right?</strong> <br>
                    <?php
                    if ($noDrug==False) { ?>
                    <form action="../Forms/changedrug_form.php" method="POST">
                        <input type="submit" value="Update my contraceptive">
                    </form>

                    <?php
                    }
                    ?>

                <p>
                <form action="../Forms/changesides_form.php" method="POST">
                    <input type="submit" value="Change my top SIDES">
                </form>
                <br>
                </p>
                <p>
                    <strong> More options: </strong>

                <form action="../Forms/rating_form.php" method="POST">
                    <input type="submit" value="Review a drug">
                </form>
                </p>
                <p>
                <form action="../Forms/sidesreport_form.php" method="POST">
                    <input type="submit" value="Report Past SIDES">
                </form>
                </p>
            </div><!-- Forms -->
    </main>
    </div><!-- All content -->
</body>

</html>