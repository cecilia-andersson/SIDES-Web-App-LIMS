<!DOCTYPE html>
<html>
<head>
    <title>Drug Search</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to CSS file -->
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; 
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        a {
            color: #256e8a;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style> -->
</head>
<body>
    <h2>Drug Search</h2>
    <form action="search_drugs.php" method="POST">
        Search: <input type="text" name="search_query">
        <input type="submit" value="Go">
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "things";
    $search_query = $_POST['search_query']; 

    // Create connection
    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }

    echo 'Search results for "' . $search_query . '":';
    echo '<table><tr><th>Brand</th><th></th><th>Class</th><th></th><th>Active Ingredients</th><th></th><th>Inactive Ingredients</th></tr>';

    $sql = "SELECT drugs.drug_class, drugs.drug_brand, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient, drugs.drug_id
            FROM drugs
            WHERE drug_brand LIKE '%$search_query%'
            OR drug_class LIKE '%$search_query%'
            OR drug_active_ingredient LIKE '%$search_query%'
            OR drug_inactive_ingredient LIKE '%$search_query%'";

    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $drug_id = $row["drug_id"];
            echo "<tr> <td><a href='nice_drug_page.php?drug_id=$drug_id'>" . $row["drug_brand"] . "</a></td><td></td><td>" . $row["drug_class"] . "</td><td></td><td>" . $row["drug_active_ingredient"] . "</td><td></td><td>" . $row["drug_inactive_ingredient"] . "</td></tr>";
        }
    } else {
        echo "0 results";
    }

    // Close the database connection
    mysqli_close($link);
    ?>

</body>
</html>
