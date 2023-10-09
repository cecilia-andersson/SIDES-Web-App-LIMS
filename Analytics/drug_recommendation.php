<!DOCTYPE html>
<html>
<head>
    <title>Analytics Page</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">

    <!-- Include Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <h2 id="header"></h2>
    <?php

        
    // Connecting to the database
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "sides";
    $side_effect = $_GET['side_effect']; // Get user input
    //$side_effect = 'Dizziness';
    //$side_effect = 'Headache';
    // Create connection
    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Retrieving user input of the side effect that the histogram should be based on ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Function to retrieve user reviews from the database
function getUserReviews($userId) {
    global $db;
    $query = "SELECT drug_id, rating FROM review WHERE userid = :userId";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Usage example
$userId = 1; // Replace with the user's actual ID
$userReviews = getUserReviews($userId);
print_r($userReviews);
?>
