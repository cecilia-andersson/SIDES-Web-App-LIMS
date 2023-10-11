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
    phpinfo();

        
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
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Sample function to preprocess ratings to binary values ~~
    // ~~ ( Either Good (4-5) or Bad(1-3) )                  ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


    // 
    function preprocessRatings($rating) {
        // Convert ratings to binary (e.g., 0 for ratings 4 and 5, 1 otherwise)
        return ($rating >= 4) ? 0 : 1;
    }
    // Include the library
    require 'path/to/fp-growth.php';

    // Sample dataset (replace with your data)
    $transactions = [
        ['item1', 'item2', 'item3'],
        ['item2', 'item3', 'item4'],
        // Add more transactions
    ];

    // Create an FP-Growth instance
    $fpGrowth = new FpGrowth();

    // Generate frequent itemsets
    $frequentItemsets = $fpGrowth->findFrequentItemsets($transactions, $minSupport);

    // Generate association rules
    $associationRules = $fpGrowth->generateRules($frequentItemsets, $minConfidence);

    // Filter or prune rules as necessary
    // For example, remove rules with low confidence

    // Return association rules as JSON
    echo json_encode($associationRules);


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




