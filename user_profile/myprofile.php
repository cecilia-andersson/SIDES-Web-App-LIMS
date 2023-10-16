<!DOCTYPE html>
<html>


<!-- Validated and sanitized -- assuming sessions variables can't be edited. -->


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
        }

        i {
            font-style: normal;
            color: grey;
        }

        h4 {
            color: #757CB3;
            margin: 3px;
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
        <p> Username <br><i> $loggedInUser</i> </p>
        <p> Age <br><i> $agerange </i></p>
        <p> Email <br><i> $email </i></p>
        "; // this cannot be displayed if salted and hashed
            
            }
            ?>

                <form action="edit_myprofile.php" style="display:inline">
                    <input type="submit" value="Edit info" />
                </form>

                <form action="delete_account.php" style="display:inline">
                    <input type="submit" value="Delete account"/>
                </form>

                </section> <!--Profile info-->
            </div><!-- Left content -->

            <div class="calendar">
                <?php
                if (isset($_GET['Message'])) {
                    echo $_GET['Message'];
                }

                include "calendar.php";
                ?>
            </div>

            <div class="forms"><!--Forms-->
                <br>
                <p>
                    <strong>Something doesn't look right?</strong> <br>
                    <?php
                    if ($noDrug == False) { ?>
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
<?php
include "../footer.php";
?>

</html>