<!DOCTYPE html>
<html>
<head>
    <title>Analytics Page</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">

    <!-- Include Plotly library -->
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script> 
    <!-- <script src="plotly-latest.js"></script> -->

</head>
<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <h2 id="header"></h2>
    <?php

        
    // Retrieve the drug information based on the drug_id query parameter
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
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    
    // Fetch side effects from the "side_effects" table
    $query = "SELECT se_name FROM side_effects";
    $result = mysqli_query($link, $query);

    // Check if the query was successful
    if ($result) {
        $sideEffects = array();

        // Fetch side effects and store them in an array
        while ($row = mysqli_fetch_assoc($result)) {
            $sideEffects[] = $row['se_name'];
        }

        // Close the result set
        mysqli_free_result($result);
    } else {
        echo "Error fetching side effects: " . mysqli_error($link);
        $sideEffects = array(); // Default to an empty array if there was an error
    }
    ?>

    <!-- Create a form for user input -->
    <form method="get" action="drug_frequency.php">
        <label for="side_effect">Select Side Effect:</label>
        <select id="side_effect" name="side_effect">
            <?php
            // Generate dropdown options from the fetched side effects
            foreach ($sideEffects as $effect) {
                echo "<option value='$effect'>$effect</option>";
            }
            ?>
        </select>
        <input type="submit" value="Submit">
    </form>
    <?php       

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // ~~ Fetching drug frequency data from mysql, for the user specified side effect ~~
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    // Create a temporary table to store the frequency of R_se_fk_id for each R_drug_fk_id
    $query1 = "CREATE TEMPORARY TABLE drug_side_effect_frequency AS
    SELECT drug_association_report.R_drug_fk_id, drug_association_report.R_se_fk_id, COUNT(*) AS frequency
    FROM drug_association_report 
    INNER JOIN side_effects ON drug_association_report.R_se_fk_id = side_effects.se_id
    WHERE side_effects.se_name = '$side_effect'
    GROUP BY drug_association_report.R_drug_fk_id, drug_association_report.R_se_fk_id;";

    // Executing the first SQL query that gathers frequencies of the side effect for each drug
    if ($link->query($query1) === TRUE) {
        $side_effect_drug_frequencies = $link->query($query1);

        // Fetch the drug information and frequency
        $query2 = "SELECT drugs.drug_brand, drugs.drug_class, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient, drug_side_effect_frequency.R_se_fk_id, drug_side_effect_frequency.frequency
        FROM drug_side_effect_frequency 
        INNER JOIN drugs ON drug_side_effect_frequency.R_drug_fk_id = drugs.drug_id;";

        // Executing the second SQL query that gathers drug information and frequency
        $result_se_frequency_and_drug_information = $link->query($query2);
        
        // Creating an array to store the data
        $data = array();
        while ($row = mysqli_fetch_assoc($result_se_frequency_and_drug_information)) 
            {$data[] = $row;}
        


        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        // ~~ Passing the histogram data to Analytics/histogram_plot.js ~~
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        // Debugging: Output the JSON data to check its format
        //echo "<pre>";
        //var_dump($data);
        //echo "</pre>";

        // Passing the JSON histogram data to the JavaScript code
        echo "<script>var histogramData = " . json_encode($data) . ";</script>";

        // Set the sideEffectName variable in JavaScript
        echo '<script>var sideEffectName = "' . $side_effect . '";</script>';


        ?>

        <!-- Creating a container for the histogram plot -->
        <div id="histogram-plot">
            <canvas id="histogram"></canvas>
        </div>

        <!-- Including the JavaScript file creating the histogram plot -->
        <script src="histogram_plot.js"></script>
            

        <?php }
    else {"Error creating temporary table: " . $link->error;}

    // Close the database connection
    $link->close();
    ?>
<?php
    include "../footer.php";
?>
</body>
</html>
