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
        <h2>Update My Contraceptive</h2>

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
        <form action="/Forms/change_current_drug.php" method="POST">
            <label for "enddate">When did you STOP using your previous birth control method? </label>
            <br>
            <input type="date" id="end" name="end" value="2023-01-01" min="2022-01-01" max="2024-12-31" />
            <br>
            <label for "startdate">When did you BEGIN using this new birth control method? </label>
            <br>
            <input type="date" id="start" name="start" value="2023-01-01" min="2000-01-01" max="2024-12-31" />
            <br>
            <label for "newdrug">Which new contraceptive are you using? </label>
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
            <br>
            <input type="submit" value="Update contraceptive">
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