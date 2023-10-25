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

        /* Trying to make it orange. Doesnt work */
        .delete_button {
            /* background-color: #f5733a;*/
            background-color: #C43B39;
            color: white;
            border-radius: 0.375rem;
            padding: 0.625rem;
            cursor: pointer;
            border: 1px solid #C43B39;
            font-size: 0.875rem;
            text-align: center;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .delete_button:hover {
            background-color: #1A3038;
            border: 1px solid #1A3038;
        }

        .no_button {
            background-color: #246f8a;
            color: white;
            border-radius: 0.375rem;
            padding: 0.625rem;
            cursor: pointer;
            border: 1px solid #246f8a;
            font-size: 0.875rem;
            text-align: center;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .no_button:hover {
            background-color: #1A3038;
        }

        #overlay1 {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 10, 0.5);
            /*this is 757CB3 */
            z-index: 2;
            cursor: pointer;
        }

        #outerContainer1 {
            background-color: #ffffff;
            border: 2px solid #256e8a;
            border-radius: 15px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;

            max-height: 95vh;
            /* Set maximum height for the container */
            overflow-y: auto;
            /* Enable vertical scrolling if content overflows */


            position: absolute;
            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        #buttonContainer1 {
            text-align: center;
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
    <div class="white">

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
                            <?php
                            $sql = "SELECT userid FROM users WHERE username = '$loggedInUser'";
                            $result = $link->query($sql);
                            if ($result->num_rows == 1) {
                                $row = $result->fetch_assoc();
                                $user_id = $row["userid"];
                            }
                            ?>
                            <br>
                            <!-- Add the "Drug Recommendation" button -->
                            <a href="../Analytics/user_drug_recommendation.php?userid=<?php echo $userid; ?>">Drug
                                Recommendation</a>

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
                    <div id="overlay1">
                        <div id="outerContainer1">
                            <h4> Are you sure you want to delete your account and all its data?</h4>

                            <div id="buttonContainer1">
                                <form action="delete_account.php" action="overlay_on1()" style="display:inline;">
                                    <input type="submit" value="Yes"
                                        style="background-color: #C43B39; border: 1px solid #C43B39;" />
                                </form>
                                <button type="button" class="no_button" onclick="overlay_off1()">No</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="delete_button" onclick="overlay_on1()" style="display:inline">Delete
                        account</button>

                    <form action="edit_myprofile.php" style="display:inline">
                        <input type="submit" value="Edit info" />
                    </form>

                    </section> <!--Profile info-->
                </div><!-- Left content -->

                <div class="calendar">
                    <?php
                    if (isset($_GET['Message'])) {
                        echo $_GET['Message'];
                    }
                    ?>
                    <h4>Calendar</h4>
                    <p>Click on a date to see your daily log:</p>
                    <?php

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
                    <form action="../Analytics/analytics.php" method="POST">
                        <input type="submit" value="My SIDES intensity">
                    </form>
                    </p>
                </div><!-- Forms -->
        </main>
    </div><!-- All content -->



    <script>
        function overlay_on1() {
            document.getElementById("overlay1").style.display = "block";
        }

        function overlay_off1() {
            document.getElementById("overlay1").style.display = "none";
        }

        document.addEventListener("keydown", function (event) {// to allow for esc closing 
            if (event.key === "Escape") {
                overlay_off1(); y
            }
        });
    </script>
    </div>

</body>
<?php
include "../Logging_and_posts/process_form.php";
?>
<?php
include "../footer.php";
?>

</html>