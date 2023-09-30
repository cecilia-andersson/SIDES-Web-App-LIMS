<!DOCTYPE html>
<html>
<head>
    
    <title>Drug Search</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <style>

    body {
        background-color: #ffffff;
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        color: #1a3038;
        line-height: 22px;
        margin: auto;
        padding: 4em;
    }

        header {

            text-align: center
        }
        h2 {
            color: #256e8a;
            font-size: 36px;
        }
/* search */
        .search-container {
            margin-top: 70px;
            display: flex;
            justify-content: center;
        }




        .search-input {
            width: 100%;
            padding: 20px ;
            font-size: 24px;
            border: 2px solid #E6E6E6; 
            color: #E6E6E6; 
            border-radius: 5px;
        }

/* filtering */
    .filter-container {
        margin-top: 20px;
        display: flex;

        justify-content: center;
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
            text-align: left;
        }

        .filter-button {
            background-color: #256e8a;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 15px 30px;
            font-size: 24px;
            cursor: pointer;
            text-align: right;
            transition: background-color 0.3s ease;
        }

        .filter-button:hover {
            background-color: #1A3038;
        }

/* collapsibles */

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

/* results */
        .search-results {
            background-color: #256e8a;
            color: white;
            padding: 10px 20px;
            font-size: 24px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: left;
        }
        .logo {
            text-align: left;  
        }
</style>
</head>
<body>

    <header>
        <sub><img src="../images/SIDES_head.png" alt="SIDES logo" id="logo" width="70" height="70"></sub>
        <nobr>
        <?php
        include "../navigation.php";
        ?>
    </header>
    
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

// active ingredient options
$act_sql = "SELECT DISTINCT drug_active_ingredient FROM drugs";
$act_result = $link->query($act_sql);

// Store unique values in an array
$act_list = [];
if ($act_result->num_rows > 0) {
    while ($act_row = $act_result->fetch_assoc()) {
        $act_list[] = $act_row["drug_active_ingredient"];
    }
}

//class options
$class_sql = "SELECT DISTINCT drug_class FROM drugs";
$class_result = $link->query($class_sql);
$class_list = [];
if ($class_result->num_rows > 0) {
    while ($class_row = $class_result->fetch_assoc()) {
        $class_list[] = $class_row["drug_class"];
    }
}

//
$brand_sql = "SELECT DISTINCT drug_brand FROM drugs";
$brand_result = $link->query($brand_sql);
$brand_list = [];

if ($brand_result->num_rows > 0) {
    while ($brand_row = $brand_result->fetch_assoc()) {
        $brand_list[] = $brand_row["drug_brand"]; 
        //print_r($brand_row);
    }
}


// filtering stuff:




// Close the database connection
$link->close();

?>




    
<div class="filter-container">
    <form action="s_p.php" method="POST">
    <input type="text" class="search-input" name="search_query" placeholder="Search for contraceptives">
        <table>
            <tr>
                <th>Sort By:</th>
                <th>
                    <select class="filter-select" name="sort_by" id="sort_by">
                        <option value="drug_brand">Brand</option>
                        <option value="drug_active_ingredient">Active Ingredient</option>
                        <option value="drug_class">Type</option>
                    </select>
                </th>
                <th>Active Ingredient:</th>
                <th>
                    <select class="filter-select" name="filter_active_ingredient" id="filter_active_ingredient">
                        <option value=""></option>
                        <?php
                        foreach ($act_list as $ingredient) {
                            $selected = ($filter_active_ingredient == $ingredient) ? 'selected' : '';  
                            echo "<option value='$ingredient'>$ingredient</option>";
                        }
                        ?>
                    </select>
                </th>
                <th>Brand:</th>
                <th>
                    <select class="filter-select" name="filter_brand" id="filter_brand">
                        
                        <option value=""></option>
                        <?php
                        foreach ($brand_list as $brand) {
                            $selected = ($filter_brand == $brand) ? 'selected' : '';
                            echo "<option value='$brand'>$brand</option>";
                        }
                        ?>
                    </select>
                </th>
                <th>Class:</th>
                <th>
                    <select class="filter-select" name="filter_class" id="filter_class">
                        <option value=""></option>
                        <?php
                        foreach ($class_list as $class) {
                            $selected = ($filter_class == $class) ? 'selected' : '';
                            echo "<option value='$class'>$class</option>";
                        }
                        ?>
                    </select>
                </th>
                <th>
                    <input type="submit" class="filter-button" value="Filter Search">
                </th>
            </tr>
        </table>
    </form>
    <br>        
</div>


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
$search_query = $_POST['search_query'];
$filter_brand = isset($_POST['filter_brand']) ? $_POST['filter_brand'] : '';
$filter_class = isset($_POST['filter_class']) ? $_POST['filter_class'] : '';
$filter_active_ingredient = isset($_POST['filter_active_ingredient']) ? $_POST['filter_active_ingredient'] : '';



echo '<div class="search-results">Search results for "' . $search_query . '":</div>';

// Build the SQL query based on filter criteria
$sql = "SELECT drugs.drug_class, drugs.drug_brand, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient, drugs.drug_id
        FROM drugs
        WHERE (drug_brand LIKE '%$search_query%'
            OR drug_class LIKE '%$search_query%'
            OR drug_active_ingredient LIKE '%$search_query%'
            OR drug_inactive_ingredient LIKE '%$search_query%')";

// code to implement filtering here - need to make them connected to the actual attribute names. 


if (!empty($filter_brand)) {
    $sql .= " AND drug_brand = '$filter_brand'";
}

if (!empty($filter_class)) {
    $sql .= " AND drug_class = '$filter_class'"; 
}

if (!empty($filter_active_ingredient)) {
    $sql .= " AND drug_active_ingredient = '$filter_active_ingredient'";
}

if (!empty($sort_by)) {
    $sql .= " ORDER BY $sort_by";
}

$result = $link->query($sql); // is it ok that I am concatenating this`?

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
<?php
    include "../footer.php";
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
