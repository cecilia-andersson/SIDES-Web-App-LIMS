<!DOCTYPE html>
<html>
<head>
    <title>Drug Search</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
    <style>

        body {
            background-color: #ffffff;
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            color: #1a3038;
            line-height: 22px;
            width: 70%;
            margin: auto;
            padding: 4em;
        }

        h2 {
            color: #256e8a;
            font-size: 36px;
            text-align: center;
        }

        .search-container {
            text-align: center;
            margin-top: 20px;
        }

        .search-input {
            width: 100%;
            padding: 20px;
            font-size: 24px;
            border: none;
            border-radius: 5px;
        }

        .filter-container {
            text-align: center;
            margin-top: 20px;
        }
        .filter-container table {
        border-collapse: collapse;
        border: none; 
    }

        .filter-container th{
            border: none;
            white-space: nowrap; /* Prevent goint ot new row */  
        }

        .filter-select {
            border: none;
        }

        .filter-button {
            background-color: #256e8a;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 15px 30px;
            font-size: 24px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filter-button:hover {
            background-color: #1A3038;
        }

        .collapsible {
            background-color: #256e8a;
            color: white;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
        }

        .active, .collapsible:hover {
            background-color: #1A3038;
        }

        .collapsible:after {
            content: '\002B';
            color: white;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .content {
            padding: 0 18px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
            background-color: #f1f1f1;
        }

        .container {
            text-align: center;
        }
        .search-results {
            background-color: #256e8a;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 24px;
            border-radius: 5px;
            margin-top: 10px;
        }
</style>
</head>
<body>
    
    <h2>Drug Search</h2>
    <div class="search-container">
        <form action="s_p.php" method="POST">
            <input type="text" class="search-input" name="search_query" placeholder="Search">
        </form>
    </div>

    
    <div class="filter-container">
        <form action="s_p.php" method="POST">
            <table>
                <tr>

                    <th>Sort:</th>
                    <th>
                        <select class="filter-select" name="sort_by" id="sort_by">
                            <option value="empty"></option>
                            <option value="brand">Brand</option>
                            <label for="sort_by">Sort By:</label>
                            <option value="active_ingredient">Active Ingredient</option>
                            <option value="type">Type</option>
                        </select>
                    </th>
                    <th>
                        
                    </th>
                    <th>Fass side effects:</th>
                    <th>
                        <select class="filter-select" name="fast_side_effects" id="fast_side_effects">
                            <label for="fast_side_effects">Fast Side Effects:</label>
                            <option value=""></option>
                        </select>
                    </th>
                    <th>
                    <th>Our side effects:</th>   
                    </th>
                    <th>
                        <select class="filter-select" name="our_side_effects" id="our_side_effects">
                            <label for="our_side_effects">Our Side Effects:</label>
                            <option value=""></option>
                        </select>
                    </th>
                    <th>
                        
                    </th>
                    <th>Rating:</th>
                    <th>
                        <select class="filter-select" name="ratings" id="ratings">
                            <label for="ratings">Ratings:</label>
                            <option value=""></option>
                        </select>
                    </th>
                    <th>
                        <input type="submit" class="filter-button" value="Filter Search">
                    </th>
                </tr>
            </table>
        </form>
        


    <?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sides";

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize filter variables
$sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : '';
$fast_side_effects = isset($_POST['fast_side_effects']) ? $_POST['fast_side_effects'] : '';
$our_side_effects = isset($_POST['our_side_effects']) ? $_POST['our_side_effects'] : '';
$ratings = isset($_POST['ratings']) ? $_POST['ratings'] : '';
$search_query = $_POST['search_query'];

echo '<div class="search-results">Search results for "' . $search_query . '":</div>';

// Build the SQL query based on filter criteria
$sql = "SELECT drugs.drug_class, drugs.drug_brand, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient, drugs.drug_id
        FROM drugs
        WHERE (drug_brand LIKE '%$search_query%'
            OR drug_class LIKE '%$search_query%'
            OR drug_active_ingredient LIKE '%$search_query%'
            OR drug_inactive_ingredient LIKE '%$search_query%')";

// code to implement filtering here - need to make them connected to the actual attribute names. 
//if (!empty($sort_by)) {
//    $sql .= " ORDER BY $sort_by";
//}

//if (!empty($fast_side_effects)) {
//    $sql .= " AND fast_side_effects_column = '$fast_side_effects'";
//}

//if (!empty($our_side_effects)) {
//    $sql .= " AND our_side_effects_column = '$our_side_effects'";
//}

//if (!empty($ratings)) {
//    $sql .= " AND ratings_column = '$ratings'";
//}

$result = $link->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $drug_id = $row["drug_id"];
        $drug_brand = $row["drug_brand"];
        $drug_class = $row["drug_class"];
        $drug_active_ingredient = $row["drug_active_ingredient"];
        $drug_inactive_ingredient = $row["drug_inactive_ingredient"];

        // Generate collapsible elements for each result
        echo "<button class='collapsible'>$drug_brand</button>";
        echo "<div class='content'>";
        echo "<p><a href='nice_drug_page.php?drug_id=$drug_id'>$drug_brand</a></p>";
        echo "<p>Drug Class: $drug_class</p>";
        echo "<p>Active Ingredient: $drug_active_ingredient</p>";
        echo "<p>Inactive Ingredient: $drug_inactive_ingredient</p>";
        echo "</div>";
    }
} else {
    echo "0 results";
}

// Close the database connection
mysqli_close($link);
?>

</body>


<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}
</script>
</html>
