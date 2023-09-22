<!DOCTYPE html>
<html>
<head>
    <title>Drug Page</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
</head>
<body>
    <h2>Drug Details</h2>
    <?php
    // Retrieve the drug information based on the drug_id query parameter
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "things";
    $drug_id = $_GET['drug_id'];

    // Create connection
    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch drug details based on drug_id
    $sql = "SELECT drug_brand, drug_class, drug_active_ingredient, drug_inactive_ingredient
            FROM drugs
            WHERE drug_id = $drug_id";

    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display drug information
        echo "<p>Active Ingredients: " . $row["drug_active_ingredient"] . "</p>";
        echo "<p>Brand: " . $row["drug_brand"] . "</p>";
        echo "<p>Class: " . $row["drug_class"] . "</p>";
        echo "<p>Inactive Ingredients: " . $row["drug_inactive_ingredient"] . "</p>";
    } else {
        echo "Drug not found";
    }

    // Close the database connection
    mysqli_close($link);
    ?>
</body>
</html>
