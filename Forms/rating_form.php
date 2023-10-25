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
        <h2>Review Contraceptive</h2>
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


        <form action="drugratings.php" method="POST">
            <!-- Selecting a drug associated with the user, star rating, text rating -->

            <label for="drug">Which drug would you like to review? </label><br>
            <!-- Will need to change this to ONLY allow to select drugs they have used! -->
            <select name="drug" id="drug">
                <option value=""></option>
                <?php
                foreach ($drug_list as $new_drug) {
                    $selected = ($drug == $new_drug) ? 'selected' : '';
                    echo "<option value='$new_drug'>$new_drug</option>";
                }
                ?>
            </select>
            <br>
            <br>
            <label for="starrating">Rate this drug: </label><br><br>
            <input type="range" id="rating" name="rating" min=1 max=5 step=1 />
            <output id="value"></output>
            <script>
                const value = document.querySelector("#value");
                const input = document.querySelector("#rating");
                value.textContent = input.value;
                input.addEventListener("input", (event) => {
                    value.textContent = event.target.value;
                });
            </script>
            <br>
            <br>
            <label for="textrating">Review: </label><br>
            <textarea id="txtreview" name="txtreview" rows="5" cols="33" maxlength="500"></textarea>
            <br><br>
            <input type="submit" value="Submit your review!">
        </form>
    </div>

    <?php
    include "../footer.php";
    include "../Logging_and_posts/process_form.php";
    ?>
</body>

</html>