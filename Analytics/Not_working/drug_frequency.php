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
    $dbname = "sides";
    $side_effect = $_GET['side_effect'];

    // Create connection
    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // $seName = "Specify your se_name here"; // Replace with the desired side effect name

    $seName = "Headache"; //"Specify your se_name here"; // Replace with the desired side effect name




    // Create a temporary table to store the frequency of R_se_fk_id for each R_drug_fk_id
    $query1 = "CREATE TEMPORARY TABLE drug_side_effect_frequency AS
    SELECT drug_association_report.R_drug_fk_id, drug_association_report.R_se_fk_id, COUNT(*) AS frequency
    FROM drug_association_report 
    INNER JOIN side_effects ON drug_association_report.R_se_fk_id = side_effects.se_id
    WHERE side_effects.se_name = $side_effect
    GROUP BY drug_association_report.R_drug_fk_id, drug_association_report.R_se_fk_id";
    
    // Fetch the drug information and frequency
    $query2 = "SELECT drugs.drug_brand, drugs.drug_class, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient, drug_side_effect_frequency.R_se_fk_id, drug_side_effect_frequency.frequency
    FROM drug_side_effect_frequency 
    INNER JOIN drugs ON drug_side_effect_frequency.R_drug_fk_id = drugs.drug_id;";
    
    $pdo = new PDO("your_database_connection_details_here");
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(':seName', $side_effect, PDO::PARAM_STR);
    $stmt1->execute();
    
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute();
    
    // Fetch the results
    $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    // Convert the results to JSON and pass it to the Python script
    $data = json_encode($results);
    $escapedData = escapeshellarg($data);
    $pythonScript = "plot_histogram.py"; // Name of the Python script
    
    // Run the Python script and capture its output
    $output = shell_exec("python $pythonScript $escapedData");

    // Save the image to a location accessible by your web server
    file_put_contents('histogram.png', $output);
    
// Prepare and execute the query
$pdo = new PDO("your_database_connection_details_here");
$stmt1 = $pdo->prepare($query1);
$stmt1->bindParam(':sideEffectName', $sideEffectName, PDO::PARAM_STR);
$stmt1->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt1->execute();

$stmt2 = $pdo->prepare($query2);
$stmt2->execute();

// Fetch the results if needed
$results = $stmt2->fetchAll(PDO::FETCH_ASSOC);

?>
<img src="histogram.png" alt="image not available">
</html>