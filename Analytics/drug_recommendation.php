<!DOCTYPE html>
<html>
<head>
    <title>Analytics Page</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">

</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
        <!-- Include apriori.js library -->
        <script src="../Analytics/apriori.js"></script>

       
    </header>
    <h2 id="header"></h2>
    <?php

        
    // Connecting to the database
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "sides";
    // $side_effect = $_GET['side_effect']; // Get user input
    //$side_effect = 'Dizziness';
    //$side_effect = 'Headache';
    // Create connection
    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Fetch user reviews and sort by review date ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // PHP code to retrieve user reviews and sort them by review date
    function getUserReviews($userId) {
        global $link;
        $query = "SELECT drug_id, rating, review_date FROM review WHERE userid = $userId ORDER BY review_date ASC";
        $result = mysqli_query($link, $query);
        $reviews = array();

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $reviews[] = $row;
            }
            mysqli_free_result($result);
        } else {
            echo "Error fetching user reviews: " . mysqli_error($link);
        }

        return $reviews;
    }
   ?>
</body>
<html>
<?php
// Example: Retrieve and sort reviews for a user
$userId = 1;
$userReviews = getUserReviews($userId);
print_r($userReviews);
?>
<h2>Mined Association Rules:</h2>
<ul id="ruleList"></ul>




