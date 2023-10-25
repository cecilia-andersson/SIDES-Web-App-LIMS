<!DOCTYPE html>
<html>
<style>
    output {
        font-size: larger;
        color: black;
    }
        /* START STYLE PRESENTATION SLIDES */
        .slides_button {
            background-color: #9510AC;
            border: none;
            color: white;
            position: absolute;
            top: 40%;
            border-radius: 50%;
            padding: 25px;
            width: 100px;
            height: 100px;
        }
    /* Start slide overlay */
    #overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 10, 0.5);
    /*this is 757CB3 */
    z-index: 2;
    cursor: pointer;
        }
        #outerContainer {
            background-color: #ffffff;
            border: 2px solid #256e8a;
            border-radius: 15px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;

            max-height: 95vh;
            /* Set maximum height for the container */
            overflow-y: auto;
            /* Enable vertical scrolling if content overflows */

            position: absolute;
            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
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
    include "../Logging_and_posts/process_form.php";
    ?>
    <div>
        <div id="overlay">
            <div id="outerContainer">
                <h4> Updating Contraceptive </h4>
                <img src="../images/ceci_flows/changedrug.png" alt="database flowchart">
                <ul>
                    <li>  </li>
                    <li> </li>
                    <ul>
                        <li>  </li>
                        <li>  </li>
                        <li> </li>
                    </ul>
                    <li>  </li>
                    <li>  </li>
                </ul>
            </div>
        </div>
        <button type="button" class="slides_button" style="right:30%" onclick="overlay_on()">Say more!</button>
        <script>
            function overlay_on() {
                document.getElementById("overlay").style.display = "block";
            }

            function overlay_off() {
                document.getElementById("overlay").style.display = "none";
            }
            document.addEventListener("keydown", function (event) {// to allow for esc closing 
                if (event.key === "Escape") {
                    overlay_off();
                    overlay2_off(); y
                }
            });

        </script>

</body>

</html>