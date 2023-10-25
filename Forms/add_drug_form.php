<!DOCTYPE html>
<html>
<style>
    output {
        font-size: larger;
        color: black;
    }
</style>

<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <div class="white">
        <h2>Add Contraceptive</h2>

        <?php
        include "../DB_connect.php";

        // active ingredient options
        $drugs_sql = "SELECT drug_brand FROM drugs";
        $drugs_result = $link->query($drugs_sql);
        // add to an array
        $drug_list = [];
        if ($drugs_result->num_rows > 0) {
            while ($drug_row = $drugs_result->fetch_assoc()) {
                $drug_list[] = $drug_row["drug_brand"];
            }
        }
        ?>
        <form action="add_used_drug_sql.php" method="POST">
            <p>
                <label>When did you BEGIN using this birth control method?</label> <br>
                <input type="date" id="startdate" name="start" value="2023-01-01" min="2000-01-01" max="2024-12-31">
            </p>
            <p>
                <label>Which contraceptive are you using? </label> <br>
                <select name="drug" id="drug">
                    <option value=""></option>
                    <?php
                    foreach ($drug_list as $new_drug) {
                        $selected = ($_POST['drug'] == $new_drug) ? 'selected' : '';
                        echo "<option value='$new_drug'>$new_drug</option>";
                    }
                    ?>
                </select>
                <br>
            </p>
            <input type="submit" name="contraceptive">
        </form>
        <?php
        if (isset($_GET['Message'])) {
            echo $_GET['Message'];
        }
        ?>
    </div>
    <?php
    include "../footer.php";
    ?>
</body>

</html>