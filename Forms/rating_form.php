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
        <h2>Review Contraceptive</h2>
        <?php
        include "../DB_connect.php";
        session_start();

        if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
        $userid = $_SESSION['id'];
}
        
        // fetching only user's used drugs
        $usersdrugs = "SELECT drug_id FROM user_drug WHERE userid = '$userid'";
        $ud_result = $link->query($usersdrugs);
        $ud_list = [];
        if ($ud_result -> num_rows >0) {
            while($ud_row = $ud_result ->fetch_assoc()) {
                $ud_list[] = $ud_row["drug_id"];
            }
        } 
        $ud_list_broken = implode(',', $ud_list);

        // active ingredient options
        $drugs_sql = "SELECT drug_brand FROM drugs WHERE drug_id IN ($ud_list_broken)";
        $drugs_result = $link->query($drugs_sql);
        // add to an array
        $drug_list = [];
        if ($drugs_result->num_rows >= 0) {
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

<div>
        <div id="overlay">
            <div id="outerContainer">
                <h4> Reviewing Drugs </h4>
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