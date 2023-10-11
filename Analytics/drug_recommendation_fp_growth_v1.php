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

    /* Common style for confidence */
    .confidence {
        font-weight: bold;
    }

    /* Styles for drug names */
    .drug-name {
        font-style: italic;
    }

    </style>
</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <h2 id="header"></h2>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Include the FP-Growth implementation classes
    require __DIR__ . '/../vendor/autoload.php';

    // Function to preprocess ratings to binary values (like or dislike)
    function preprocessRatings($rating) {
        return ($rating >= 4) ? 0 : 1;
    }

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

    // Create an array to store user transactions (user_id => transaction)
    $transactions = array();

    // Set the minimum support and confidence thresholds
    $minSupport = 1;
    $minConfidence = 0.1;

    // Fetching unique user IDs
    $userQuery = "SELECT DISTINCT userid FROM review";
    $userResult = mysqli_query($link, $userQuery);

    // Initialize the array to store all transactions
    $allTransactions = array();

    // Fetch user reviews and sort by review date
    while ($userRow = mysqli_fetch_assoc($userResult)) {
        $userId = $userRow['userid'];
        $userTransactions = array(); // Create a new array for this user's transactions

        // Query to fetch user reviews
        $query = "SELECT drug_id, rating, review_date FROM review WHERE userid = $userId ORDER BY review_date ASC";
        $result = mysqli_query($link, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $drug_id = $row["drug_id"];
                $rating = $row["rating"];
                $ratingCategory = preprocessRatings($rating);
                $userTransactions[] = $drug_id . ':' . $ratingCategory;
            }
            mysqli_free_result($result);

            // Add the user's transactions to the overall transactions array
            $allTransactions[] = $userTransactions;
        } else {
            echo "Error fetching user reviews for user ID $userId: " . mysqli_error($link);
        }
    }

    // Create an instance of the FP-Growth class
    $fpgrowth = new \EnzoMC\PhpFPGrowth\FPGrowth($minSupport, $minConfidence);

    // Run the FP-Growth algorithm with all transactions
    $fpgrowth->run($allTransactions);

    // Retrieve and work with the patterns and rules generated by the algorithm
    $patterns = $fpgrowth->getPatterns();
    $rules = $fpgrowth->getRules();

    // Fetch the mapping of drug_id to drug_brand
    $drugIdToBrandMapping = array();
    $mappingQuery = "SELECT drug_id, drug_brand FROM drugs";
    $mappingResult = mysqli_query($link, $mappingQuery);

    if ($mappingResult) {
        while ($row = mysqli_fetch_assoc($mappingResult)) {
            $drugIdToBrandMapping[$row['drug_id']] = $row['drug_brand'];
        }
        mysqli_free_result($mappingResult);
    } else {
        echo "Error fetching drug mapping: " . mysqli_error($link);
    }

    // Create an associative array to store unique rules
    $uniqueRules = array();

    echo '<ul>';

    // Process and filter the LHS (Left Hand Side) and RHS (Right Hand Side)
    foreach ($rules as $rule) {
        if (count($rule) >= 2) {
            list($LHS, $RHS) = $rule;
            $LHSItems = explode(',', $LHS);

            $LHSBrands = array();
            $isDislike = false;
            $isLike = false;

            foreach ($LHSItems as $item) {
                list($drugId, $rating) = explode(':', $item);

                if (is_numeric($drugId)) {
                    $brandQuery = "SELECT drug_brand FROM drugs WHERE drug_id = $drugId";
                    $brandResult = mysqli_query($link, $brandQuery);

                    if ($brandResult) {
                        $brandRow = mysqli_fetch_assoc($brandResult);

                        if (isset($brandRow['drug_brand'])) {
                            $LHSBrands[] = '<span class="drug-name">' . $brandRow['drug_brand'] . '</span>';
                            if ($rating == 1) {
                                $isDislike = true;
                            }
                        }

                        mysqli_free_result($brandResult);
                    } else {
                        echo "Error fetching drug brand for drug ID $drugId: " . mysqli_error($link);
                    }
                }
            }

            $RHSBrands = array();
            $isUnexpectedFormatRHS = false;

            if (!empty($RHS)) {
                $RHSItems = explode(',', $RHS);

                foreach ($RHSItems as $item) {
                    list($drugId, $rating) = explode(':', $item);

                    if (is_numeric($drugId)) {
                        $brandQuery = "SELECT drug_brand FROM drugs WHERE drug_id = $drugId";
                        $brandResult = mysqli_query($link, $brandQuery);

                        if ($brandResult) {
                            $brandRow = mysqli_fetch_assoc($brandResult);

                            if (isset($brandRow['drug_brand'])) {
                                $RHSBrands[] = '<span class="drug-name">' . $brandRow['drug_brand'] . '</span>';
                                if ($rating == 0) {
                                    $isLike = true;
                                }
                            }

                            mysqli_free_result($brandResult);
                        } else {
                            echo "Error fetching drug brand for drug ID $drugId: " . mysqli_error($link);
                        }
                    } else {
                        $isUnexpectedFormatRHS = true;
                    }
                }
            }

            if (!$isUnexpectedFormatRHS) {
                // Calculate the "Satisfaction Confidence" manually
                $numerator = 0;
                $denominator = 0;

                foreach ($allTransactions as $transaction) {
                    // Check if LHS (Left Hand Side) items are disliked
                    $lhsDisliked = true;

                    foreach ($LHSItems as $item) {
                        list($drugId, $rating) = explode(':', $item);
                        $found = false;

                        foreach ($transaction as $transItem) {
                            list($transDrugId, $transRating) = explode(':', $transItem);
                            if ($transDrugId == $drugId && $transRating == 1) {
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) {
                            $lhsDisliked = false;
                            break;
                        }
                    }

                    if ($lhsDisliked) {
                        // Check if RHS (Right Hand Side) items are liked
                        $rhsLiked = true;

                        foreach ($RHSItems as $item) {
                            list($drugId, $rating) = explode(':', $item);
                            $found = false;

                            foreach ($transaction as $transItem) {
                                list($transDrugId, $transRating) = explode(':', $transItem);
                                if ($transDrugId == $drugId && $transRating == 0) {
                                    $found = true;
                                    break;
                                }
                            }

                            if (!$found) {
                                $rhsLiked = false;
                                break;
                            }
                        }

                        // Increment the denominator
                        $denominator++;

                        // Increment the numerator if RHS is liked
                        if ($rhsLiked) {
                            $numerator++;
                        }
                    }
                }

                // Calculate the "Satisfaction Confidence"
                $satisfactionConfidence = ($denominator > 0) ? ($numerator / $denominator * 100) : 0;

                // Create a unique rule string for checking duplicates
                $uniqueRuleString = $LHS . ' => ' . $RHS;
                if (!isset($uniqueRules[$uniqueRuleString])) {
                    // Display the rule only if it is what you want (LHS = Dislike and RHS = Like)
                    if ($isDislike && $isLike && $satisfactionConfidence > 0) {
                        echo '<li>If you <span class="lhs">dislike ' . implode(', ', $LHSBrands) . '</span>, you may instead <span class="rhs">like ' . implode(', ', $RHSBrands) . '</span> <span class="confidence">(Satisfaction Confidence: ';

                        // Calculate the "Satisfaction Confidence" in terms of stars
                        $starRating = '';
                        $percentage = 0;

                        if ($satisfactionConfidence >= 1 && $satisfactionConfidence < 10) {
                            $starRating = '☆☆☆☆☆'; // 0 stars
                            $percentage = 5; // Set the percentage based on your criteria
                        } elseif ($satisfactionConfidence >= 10 && $satisfactionConfidence < 30) {
                            $starRating = '★☆☆☆☆'; // 1 star
                            $percentage = 15; // Set the percentage based on your criteria
                        } elseif ($satisfactionConfidence >= 30 && $satisfactionConfidence < 50) {
                            $starRating = '★★☆☆☆'; // 2 stars
                            $percentage = 40; // Set the percentage based on your criteria
                        } elseif ($satisfactionConfidence >= 50 && $satisfactionConfidence < 70) {
                            $starRating = '★★★☆☆'; // 3 stars
                            $percentage = 60; // Set the percentage based on your criteria
                        } elseif ($satisfactionConfidence >= 70 && $satisfactionConfidence < 90) {
                            $starRating = '★★★★☆'; // 4 stars
                            $percentage = 80; // Set the percentage based on your criteria
                        } elseif ($satisfactionConfidence >= 90) {
                            $starRating = '★★★★★'; // 5 stars
                            $percentage = 100; // Set the percentage based on your criteria
                        } else {
                            $starRating = '☆☆☆☆☆'; // 0 stars
                        }

                        echo $starRating . ' ' . $percentage . '%';
                        echo ')</span></li>';

                        // Mark this rule as seen in the uniqueRules array
                        $uniqueRules[$uniqueRuleString] = true;
                    }
                }
            }
        }
    }

    echo '</ul>';

    $link->close();
    ?>

    <?php
    include "../footer.php";
    ?>
</body>
</html>
