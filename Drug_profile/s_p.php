<!DOCTYPE html>
<html>

<head>
    <title>Drug Search</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .checked {
            color: orange;
        }

        /* filtering */
        .filter-container {
            margin-top: 5vh;
        }

        .filter-container table {
            position: relative;
            border: none;
            margin-bottom: 0;
        }

        .filter-container th {
            margin-top: 1rem;
            border: none;
            white-space: nowrap;
            padding: 0.2em;
            display: inline-block;
        }

        .filter-select {
            border: 1px solid #757CB3;
            border-radius: 0.375rem;
            text-align: left;
            font-family: 'Roboto', sans-serif;
            font-size: 0.875rem;
            padding: 0.2rem;
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

        .active,
        .collapsible:hover {
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
            clear: both;
            /* Clear the floats */
        }

        .description {
            float: left;
            /* Align description to the left */
            width: 45%;
            /* Set width to 50% to allow for the drug info to be on the right */
        }

        .drug-info {
            float: right;
            /* Align drug info to the right */
            width: 45%;
            /* Set width to 50% to allow for the description to be on the left */
        }

        /* results */
        .search-results {
            background-color: #256e8a;
            color: white;
            padding: 10px 20px;
            font-size: 24px;
            border-radius: 0px;
            margin-top: 10px;
            text-align: left;
            margin-top: 0;
        }
    </style>
</head>

<body style="background-color: rgba(100,167,172,0.15);">
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>

    <?php
    include "../Logging_and_posts/process_form.php";
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
    <div class="white" style="background-color:white;">
        <h2>Search contraceptives </h2>
        <div class="filter-container">
            <form action="s_p.php" method="GET">
                <input type="text" name="search_query" placeholder="Search for contraceptives">
                <table>
                    <tr>
                        <th>Sort By:</th>
                        <th>
                            <select class="filter-select" name="sort_by" id="sort_by">
                                <option value="drug_brand" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'drug_brand')
                                    echo 'selected'; ?>>Brand</option>
                                <option value="drug_active_ingredient" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'drug_active_ingredient')
                                    echo 'selected'; ?>>Active Ingredient
                                </option>
                                <option value="drug_class" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'drug_class')
                                    echo 'selected'; ?>>Class</option>
                            </select>
                        </th>
                        <th>Active Ingredient:</th>
                        <th>
                            <select class="filter-select" name="filter_active_ingredient" id="filter_active_ingredient">
                                <option value=""></option>
                                <?php
                                foreach ($act_list as $ingredient) {
                                    $selected = ($filter_active_ingredient == $ingredient) ? 'selected' : '';
                                    echo "<option value='$ingredient' " . (isset($_GET['filter_active_ingredient']) && $_GET['filter_active_ingredient'] == $ingredient ? 'selected' : '') . ">$ingredient</option>";
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
                                    echo "<option value='$brand' " . (isset($_GET['filter_brand']) && $_GET['filter_brand'] == $brand ? 'selected' : '') . ">$brand</option>";
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
                                    echo "<option value='$class'  " . (isset($_GET['filter_class']) && $_GET['filter_class'] == $class ? 'selected' : '') . ">$class</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>

                            <input type="submit" class="filter-button" value="Filter Search">
                            <a href="http://localhost/Drug_profile/s_p.php" style="color:#757CB3; margin-left:5px">Clear Filters</a>

                        </th>
                    </tr>
                </table>
            </form>
            <br>
        </div>

        <?php
        include "../DB_connect.php";
        // Initialize filter variables
        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';

        if (isset($_GET['search_query']) && !empty(trim($_GET['search_query']))) {
            $search_query = trim($_GET['search_query']);
            echo '<div class="search-results">Search results for "' . htmlspecialchars($search_query) . '":</div>';
        } else {
            $search_query = "";
            echo '<div class="search-results">Search results:</div>';
        }

        $filter_brand = isset($_GET['filter_brand']) ? $_GET['filter_brand'] : '';
        $filter_class = isset($_GET['filter_class']) ? $_GET['filter_class'] : '';
        $filter_active_ingredient = isset($_GET['filter_active_ingredient']) ? $_GET['filter_active_ingredient'] : '';

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

        $result = $link->query($sql); // is it ok that I am concatenating this`? I I am input validating the search input. Could not get this to work with prepared sql statements
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $drug_id = $row["drug_id"];
                $drug_brand = $row["drug_brand"];
                $drug_class = $row["drug_class"];
                $drug_active_ingredient = $row["drug_active_ingredient"];
                $drug_inactive_ingredient = $row["drug_inactive_ingredient"];


                // ratings
                $rating_sql = 'SELECT rating FROM review WHERE drug_id=?';
                $rating_stmt = $link->prepare($rating_sql);
                $rating_stmt->bind_param("i", $drug_id); // Assuming drug_id is defined somewhere in your code
                $rating_stmt->execute();
                $rating_result = $rating_stmt->get_result();

                $total_ratings = 0;
                $rating_count = 0;
                while ($row = $rating_result->fetch_assoc()) {
                    $total_ratings += $row['rating'];
                    $rating_count++;
                }

                $rating_mean = $rating_count > 0 ? $total_ratings / $rating_count : 0;
                $rounded_rating = round($rating_mean);
                // comments
        
                $comment_sql = 'SELECT COUNT(post_text) AS comment_count FROM forum_posts WHERE user_drug_id=?';
                $comment_stmt = $link->prepare($comment_sql);
                $comment_stmt->bind_param("i", $drug_id);
                $comment_stmt->execute();

                $comment_result = $comment_stmt->get_result();





                // Generate collapsible elements for each result
                echo "<button class='collapsible'><p><a href='nice_drug_page.php?drug_id=$drug_id' style='color: #ffff'>$drug_brand</a></p> ";
                echo "";

                echo '<div id="rating-comment">';
                echo "<a href='../Forms/rating_form.php' style='color: #ffff;'>";
                if ($rating_count > 0) {
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rounded_rating) {
                            echo '<span class="fa fa-star checked"></span>';
                        } else {
                            echo '<span class="fa fa-star"></span>';
                        }
                    }
                }
                echo "</a>";
                // Output number of ratings
                echo "<a href='nice_drug_page.php?drug_id=$drug_id' style='color: #ffff'>$rating_count ratings, </a>";
                if ($comment_result->num_rows > 0) {
                    $row = $comment_result->fetch_assoc();
                    $comment_count = $row['comment_count'];
                    echo "<a href='..\user_profile\forum.php' style='color: #ffff;'>$comment_count comments</a>";
                } else {
                    echo "No comments";
                }
                echo '</div>';


                echo "</button>";


                echo "<div class='content'>";

                echo '<div class="description">';
                echo '<h3>Description</h3>';
                $description_sql = "SELECT drug_description FROM drugs WHERE drug_id = ?";
                $description_stmt = $link->prepare($description_sql);
                $description_stmt->bind_param("i", $drug_id);
                $description_stmt->execute();
                $description_result = $description_stmt->get_result();
                $description_row = $description_result->fetch_assoc();
                $drug_description = $description_row['drug_description'];

                // Get preview description (first 50 characters)
                $preview_description = substr($drug_description, 0, 150);

                // Output preview description
                echo $preview_description . "<a href='../Drug_profile/nice_drug_page.php?drug_id=$drug_id'>...</a>";
                echo "</div>";



                echo "<div class='drug-info'>";
                echo '<h3>Drug information </h3>';
                echo "<p>Drug Class: $drug_class</p>";
                echo "<p>Active Ingredient: $drug_active_ingredient</p>";
                echo "<p>Inactive Ingredient: $drug_inactive_ingredient</p>";
                echo "<a href='../Drug_profile/nice_drug_page.php?drug_id=$drug_id'>Read more</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "0 results";
        }



        // Close the database connection
        mysqli_close($link);
        ?>
    </div>

    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        }
    </script>
    </div>

    <?php
    include "../footer.php";
    //include "../Logging_and_posts/side_effect_logging.php";
    ?>
</body>

</html>