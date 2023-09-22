<!DOCTYPE html>
<html>
<head>
    <title>Drug Page</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
    <!-- <style>
        
        body {
            background-color: #ffffff; 
            font-family: 'Roboto', sans-serif; 
            font-size: 16px; 
            color: #1a3038;
            margin: 20px; 
        }
        h1 {
            color: #256e8a; 
            margin-bottom: 20px; 
        }
        p {
            margin: 10px 0; 
        }
    </style> -->
</head>

<body>
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
        if ($row_fass["fass_side_effects"] !== "" && $row_fass["fass_side_effects"] !== null) 
            {echo "<p>Fass side effects: " . $row_fass["fass_side_effects"] . "</p>";}
        else
            {echo "<p>No Fass side effects found</p>";}             

    } else {
        echo "<p>Drug not found</p>"; // Added formatting for error message
    }
    

    // Close the database connection
    mysqli_close($link);
    ?>
</body>
</html>
