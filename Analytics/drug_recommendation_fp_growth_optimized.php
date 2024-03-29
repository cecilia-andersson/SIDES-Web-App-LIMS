<!DOCTYPE html>
<html>
<head>
    <title>Analytics Page</title>
    <link href="/images/SIDES_head_icon.png" rel="icon">

</head>
<body>
    <header>
        <?php        
        include "/../navigation.php";
        ?>
       
    </header>
    <h2 id="header"></h2>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Including the FP-Growth implementation classes ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    require __DIR__ . '/../vendor/autoload.php';

        

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Sample function to preprocess ratings to binary values ~~
    // ~~ ( Either Like (4-5) or Dislike (1-3) )                ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    function preprocessRatings($rating) {
        // Categorize ratings as 0 (like) for (4-5) & 1 (dislike) for (1-3)
        return ($rating >= 4) ? 0 : 1;
    }
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Connecting to the database ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
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
    // Create an array to store user transactions (user_id => transaction)
    $transactions = array();
    // Set the minimum support and confidence thresholds
    $minSupport = 3; // Adjust according to your needs
    $minConfidence = 0.7; // Adjust according to your needs

    // Fetching unique user IDs
    $userQuery = "SELECT DISTINCT userid FROM review";
    $userResult = mysqli_query($link, $userQuery);


    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Fetch user reviews and sort by review date ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // PHP code to retrieve user reviews and sort them by review date


    $userQuery = "SELECT DISTINCT userid FROM review";
    $userResult = mysqli_query($link, $userQuery);
    if ($userResult) {
        while ($userRow = mysqli_fetch_assoc($userResult)) {
            $userId = $userRow['userid'];
            $userTransactions = array(); // Create a new array for this user's transactions
            
            // Query to fetch user reviews
            $query = "SELECT r.userid, d.drug_brand, r.rating, r.review_date
            FROM review r
            JOIN drugs d ON r.drug_id = d.drug_id
            ORDER BY r.review_date ASC";
            $result = mysqli_query($link, $query);
    
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $drug_brand = $row["drug_brand"];
                    $rating = $row["rating"];
                    $ratingCategory = preprocessRatings($rating);
                    $userTransactions[] = $drug_brand . ':' . $ratingCategory;
                }
                mysqli_free_result($result);
    
                // Add the user's transactions to the overall transactions array
                $transactions[$userId] = $userTransactions;
            } else {
                echo "Error fetching user reviews for user ID $userId: " . mysqli_error($link);
            }
    
            // Check if the execution time is close to the limit, and if so, stop processing and allow the script to continue in the next iteration.
            if (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"] > 50) {
                break;
            }
        }
        mysqli_free_result($userResult);
    } else {
        echo "Error fetching user IDs: " . mysqli_error($link);
    }
    
    // Close the database connection
    $link->close();
    
    // Fetching unique user IDs in batches
    $batchSize = 10; // Set the batch size
    $startUser = 0;
    while ($startUser < count($userId)) {
        $endUser = min($startUser + $batchSize, count($userId));
        $batchUserIds = array_slice($userId, $startUser, $endUser - $startUser);

        // Fetch transactions for users in the current batch and process them
        $transactions = array();
        foreach ($batchUserIds as $userId) {
            // Fetch and preprocess transactions for this user
            $userTransactions = fetchAndPreprocessTransactions($userId);
            $transactions[$userId] = $userTransactions;
        }

        // Create an instance of the FP-Growth class
        $fpgrowth = new \EnzoMC\PhpFPGrowth\FPGrowth($minSupport, $minConfidence);

        // Run the FP-Growth algorithm with the current batch of transactions
        $fpgrowth->run($transactions);

        // Retrieve and work with the patterns and rules generated by the algorithm for this batch
        $patterns = $fpgrowth->getPatterns();
        $rules = $fpgrowth->getRules();

        // You can save or process the patterns and rules for this batch as needed

        // Move on to the next batch
        $startUser = $endUser;
    }

    
    // Display or work with the association rules as needed
    echo "Frequent Patterns:\n";
    var_dump($patterns);
    
    echo "Association Rules:\n";
    var_dump($rules);
   ?>
</body>
<html>