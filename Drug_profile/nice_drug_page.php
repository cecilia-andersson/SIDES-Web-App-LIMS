<!DOCTYPE html>
<html>

<head>
    <title>Drug Page</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
</head>

<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <div class="white">
        <h2>Drug Details</h2>
        <?php
        // Retrieve the drug information based on the drug_id query parameter
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "sides";
        $drug_id = $_GET['drug_id'];

        // Create connection
        $link = mysqli_connect($servername, $username, $password, $dbname);

        if (mysqli_connect_error()) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤   
        // Fetching general drug information based on drug_id
        // ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤
        $sql = "SELECT drug_brand, drug_class, drug_active_ingredient, drug_inactive_ingredient
            FROM drugs
            WHERE drug_id = $drug_id";
        // Executing the SQL query that gathers drug details based on drug_id and storing the result in $result
        $result = $link->query($sql);

        // ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤  
        // Fetching common side effects from Fass
        // ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤ 
        $drug_side_effects_fass = "SELECT GROUP_CONCAT(side_effects.se_name SEPARATOR ', ') AS fass_side_effects
    FROM side_effects
    JOIN drug_association_fass ON side_effects.se_id = drug_association_fass.F_se_fk_id
    WHERE drug_association_fass.F_drug_fk_id = $drug_id";

        // Executing the second SQL query that gathers common Fass side effects and stores the result in $fass_side_effects_result
        $fass_side_effects_result = $link->query($drug_side_effects_fass);

        // ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤
        // Fetching top user-reported side effects
        // ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤
        $query1 = "CREATE TEMPORARY TABLE occurrences AS
    SELECT side_effects.se_name, side_effects.se_id, drug_association_report.R_drug_fk_id
    FROM drug_association_report
    INNER JOIN side_effects ON side_effects.se_id=drug_association_report.R_se_fk_id";

        // Creating a temp table with drug IDs, side effect names, and count of identical occurrences of that unique combo (drug ID+side effect name)
        $query2 = "CREATE TEMPORARY TABLE running_tallies AS
    SELECT R_drug_fk_id, se_name, COUNT(*) AS occurrence_count
    FROM occurrences
    GROUP BY R_drug_fk_id, se_name
    ORDER BY R_drug_fk_id, occurrence_count DESC";

        // Temporary table of just the top 3 side effects for each drug, listed by drug ID
        $query3 = "CREATE TEMPORARY TABLE top_reported_sides AS
    SELECT R_drug_fk_id, se_name
    FROM running_tallies 
    LIMIT 3";

        // Fetching drug info and the top side effects
        $query4 = "SELECT drugs.drug_brand, drugs.drug_class, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient, GROUP_CONCAT(top_reported_sides.se_name SEPARATOR ', ') AS user_side_effects
    FROM top_reported_sides
    INNER JOIN drugs ON drugs.drug_id=top_reported_sides.R_drug_fk_id
    WHERE drug_id = $drug_id -- from a click, made to align with 'drug_page' syntax";


        // ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤  
        // ¤ Displaying the results ¤
        // ¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display drug information
            echo "<p>Active Ingredients: " . $row["drug_active_ingredient"] . "</p>";
            echo "<p>Brand: " . $row["drug_brand"] . "</p>";
            echo "<p>Class: " . $row["drug_class"] . "</p>";
            echo "<p>Inactive Ingredients: " . $row["drug_inactive_ingredient"] . "</p>";

            // ~~~~~~~~~~~~~~~~~~~~~~~~~~~
            // ~~ Displaying Fass side effects ~~
            // ~~~~~~~~~~~~~~~~~~~~~~~~~~~
            $row_fass = $fass_side_effects_result->fetch_assoc();
            # if $row_fass is not an empty string & not NULL, then the side effects gets displayed
            if ($row_fass["fass_side_effects"] !== "" && $row_fass["fass_side_effects"] !== null) {
                echo "<p><strong>Fass side effects: </strong>" . $row_fass["fass_side_effects"] . "</p>";
            } else {
                echo "<p>No Fass side effects found</p>";
            }

            // ~~~~~~~~~~~~~~~~~~~~~~~~~~~        
            // ~~ Displaying User reported side effects ~~
            // ~~~~~~~~~~~~~~~~~~~~~~~~~~~
            if ($link->query($query1)) {
                $query2;
                if ($link->query($query2)) {
                    $query3;
                    if ($link->query($query3)) {
                        $query4;
                        $top_sides_result = $link->query($query4);
                        if ($top_sides_result) {
                            if ($top_sides_result->num_rows > 0) {
                                $row4 = $top_sides_result->fetch_assoc();
                                if ($row4["user_side_effects"] !== "" && $row4["user_side_effects"] !== null) {
                                    echo "<p><strong>Top user-reported side effects: </strong>" . $row4["user_side_effects"] . "</p>";
                                } else {
                                    echo "<p>No side effects yet reported by users.</p>";
                                }
                            }
                        } else {
                            echo "Error with 4th query: " . $link->error;
                        }
                    } else {
                        echo "Error with 3rd query: " . $link->error;
                    }
                } else {
                    echo "Error with 2nd query: " . $link->error;
                }
            } else {
                echo "Error with 1st query: " . $link->error;
            }
        } else {
            echo "<p>Drug not found</p>"; // Added formatting for error message
        }
        ?>

        <form action="../Analytics/analytics.php" method="POST">
            <input type="submit" value="See more about this drug">
        </form>
        <!-- <form action="../Analytics/compare_analytics.php" method="POST">
    <input type="submit" value="Compare any two drugs">
    </form> -->

        <?php
        // Close the database connection
        mysqli_close($link);
        ?>
    </div>
    <?php
    include "../footer.php";
    ?>
</body>

</html>