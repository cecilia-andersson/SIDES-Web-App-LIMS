<form action="search_drugs.php" method="POST">
    Search:<input type="text" name="search_query">
    <input type="submit" value="Go">
</form>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "things";
$search_query = $_POST['search_query']; // get query from somewhere

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname); 

if (mysqli_connect_error()) { 
    die("Connection failed: " . mysqli_connect_error());  
}

/// 

// Fetch data from GET request, search
// $mname = $_GET['mname'];


echo 'Search results for "'  . $search_query . '":' ;
echo '<table><tr><th>Brand</th><th></th><th>Class</th><th></th><th>Active Ingredients</th><th></th><th>Inactive Ingredients</th></tr>';

// $sql = "SELECT drugs.drug_name, drugs.drug_class, drugs.drug_brand, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient
// FROM drugs WHERE (drug_brand, drug_active_ingredient, drug_inactive_ingredient) LIKE '%$search_query%'";

$sql = "SELECT  drugs.drug_class, drugs.drug_brand, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient, drugs.drug_id
FROM drugs
WHERE drug_brand LIKE '%$search_query%'
   OR drug_class LIKE '%$search_query%'
   OR drug_active_ingredient LIKE '%$search_query%'
   OR drug_inactive_ingredient LIKE '%$search_query%'";



$result = $link->query($sql);


if ($result->num_rows > 0) { // more 
    while($row = $result->fetch_assoc()) {
        $drug_id = $row["drug_id"];
        echo "<tr> <td><a href='drug_page.php?drug_id=$drug_id'>" .  $row["drug_brand"] . "</a></td><td>" . "</td><td>" .  $row["drug_class"] . "</td><td>" . "</td><td>" . $row["drug_active_ingredient"] . "</td><td>" . "</td><td>" . $row["drug_inactive_ingredient"] . "</td></tr>";
    }
} else {
    echo "0 results";
}


echo '</table>';
?>
