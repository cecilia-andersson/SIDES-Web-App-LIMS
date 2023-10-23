<!DOCTYPE html>
<html>

<head>
    <title>Drug Recommendations</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>
        /* Reset default list styles */
        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
            /* Adjust the margin as needed */
        }

        /* Spacing between list items */
        li {
            margin-bottom: 10px;
        }

        /* Styles for left-hand side items */
        .lhs {
            color: red;
            font-weight: bold;
        }

        /* Styles for right-hand side items */
        .rhs {
            color: green;
            font-weight: bold;
        }

        /* Styles for cursive text */
        .cursive {
            font-style: italic;
        }

        /* Common style for confidence */
        .confidence {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
    </header>
    <h2>Drug Recommendation</h2>
    <?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    // Include the FP-Growth implementation classes
    require __DIR__ . '/../vendor/autoload.php';
    // Include the results from drug_recommendation_fp_growth_v1.php
    define('DIRECT_ACCESS', false); // Don't include the displaying of all the rules
    require 'drug_recommendation_fp_growth_v1.php';
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "sides";
    // Create a connection
    $link = mysqli_connect($servername, $username, $password, $dbname);
    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Define the user's ID
    // $user_id = 14; // Replace with the desired user ID
    // Get all reviews for the user, including ratings
    // Define the user's ID from the URL
    $user_id = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
    $userReviews = array();
    $query = "SELECT d.drug_brand, r.rating
        FROM drugs AS d
        JOIN review AS r ON d.drug_id = r.drug_id
        WHERE r.userid = $user_id
        ORDER BY r.review_date ASC;";
    $result = mysqli_query($link, $query);
    // var_dump($result);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $drug_brand = $row["drug_brand"];
            $rating = ($row["rating"] >= 4) ? 0 : 1;
            $userReviews[$row["drug_brand"]] = $rating;
        }
    }
    // Get a list of drugs disliked by the user
    $userDislikedDrugs = array();
    foreach ($userReviews as $drug => $rating) {
        if ($rating === 1) {
            $userDislikedDrugs[] = $drug;
        }
    }
    // Filter the rules based on the user's disliked drugs with rating 1
    $user_rules = array();
    foreach ($Finalrules as $ruleString => $ruleData) {
        list($LHS, $RHS, $satisfactionConfidence) = $ruleData;
        $LHSItems = array_map('strip_tags', explode(', ', $LHS));
        // Check if all drugs in LHS are disliked by the user
        $dislikedAllLHS = true;
        foreach ($LHSItems as $lhsDrug) {
            if (!in_array($lhsDrug, $userDislikedDrugs)) {
                $dislikedAllLHS = false;
                break;
            }
        }
        if ($dislikedAllLHS) {
            $user_rules[] = $ruleData;
        }
    }
    // Display the personalized recommendations or a message if no recommendations are found
    echo '<ul>';
    if (empty($user_rules)) {
        echo '<li>No drug recommendations found. Feel free to explore our forum and review page for inspiration.</li>';
    } else {
        foreach ($user_rules as $ruleData) {
            list($LHS, $RHS, $satisfactionConfidence) = $ruleData;
            $LHSItems = array_map('strip_tags', explode(', ', $LHS));
            $RHSItems = array_map('strip_tags', explode(', ', $RHS));

            // Calculate the "Satisfaction Confidence" in terms of stars
            $starRating = '';

            if ($satisfactionConfidence >= 1 && $satisfactionConfidence < 10) {
                $starRating = '☆☆☆☆☆'; // 0 stars
            } elseif ($satisfactionConfidence >= 10 && $satisfactionConfidence < 30) {
                $starRating = '★☆☆☆☆'; // 1 star
            } elseif ($satisfactionConfidence >= 30 && $satisfactionConfidence < 50) {
                $starRating = '★★☆☆☆'; // 2 stars
            } elseif ($satisfactionConfidence >= 50 && $satisfactionConfidence < 70) {
                $starRating = '★★★☆☆'; // 3 stars
            } elseif ($satisfactionConfidence >= 70 && $satisfactionConfidence < 90) {
                $starRating = '★★★★☆'; // 4 stars
            } elseif ($satisfactionConfidence >= 90) {
                $starRating = '★★★★★'; // 5 stars
            } else {
                $starRating = '☆☆☆☆☆'; // 0 stars 
            }
            // LHS (dislike in lhs class, $LHSItems in lhs and cursive classes)
            echo '<li>If you <span class="lhs">dislike</span> <span class="lhs cursive">' . implode(', ', $LHSItems) . '</span>,';


            // RHS (dislike in rhs class, $RHSItems in rhs and cursive classes)
            echo ' you may <span class="rhs">like</span> <span class="rhs cursive">' . implode(', ', $RHSItems) . '</span>,';

            // Add the Satisfaction Confidence
            echo ' <span class="confidence">(Satisfaction Confidence: ' . $starRating . ' ' . $satisfactionConfidence . '%)</span></li>';

        }
    }
    echo '</ul>';
    ?>
</body>

</html>