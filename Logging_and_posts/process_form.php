<!-- how to call the logging -->
<!DOCTYPE html>
<html lang="en">

<head>

    <style>
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




        #formContainer {
            background-color: #ffffff;
            border: 2px solid #256e8a;
            border-radius: 15px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;

            max-height: 95vh;
            overflow-y: auto;
            /*  vertical scrolling if content overflows */


            position: absolute;
            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        #formContainer input[type="submit"] {
            background-color: #9510AC;
            font-size: 0.875rem;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
            border: none;
            padding: 20px 30px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            width: 100%;
        }



        #formContainer button,
        #selectDate,
        #options {
            background-color: #256e8a;
            font-size: 0.875rem;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            width: 100%;
        }


        #selectDate {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 10px;
            margin-right: 10px;
        }

        #formContainer input[type="submit"]:hover,
        #formContainer button:hover,
        #selectDate:hover,
        #options:hover {
            background-color: #1A3038;
        }


        #options::-ms-expand {
            display: none;
        }

        #options {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('arrow-down.png') no-repeat right;
            background-size: 20px;
            padding-right: 30px;
        }




        #formContainer .slider {
            width: calc(100% - 20px);
            margin-top: 10px;
            margin-bottom: 20px;
            background: linear-gradient(to right, #256e8a, #1d5d70);
            height: 2px;
            border-radius: 5px;
            cursor: pointer;
            -webkit-appearance: none;
        }


        #formContainer .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 10px;
            background-color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 0px 10px 0px rgba(29, 93, 112, 0.7);
        }

        #formContainer .slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background-color: #ffffff;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        }



        #formContainer .search-dropdown {
            margin-top: 20px;
            margin-bottom: 20px;
            position: relative;
        }

        #formContainer .search-dropdown select {
            width: calc(100%);
            padding: 10px;
            border-radius: 5px;
            background-color: #ffffff;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            color: #1a3038;
            cursor: pointer;
            appearance: none;
            outline: none;
            border: 2px solid #246f8a;
            background-image: url('arrow-down.png');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
        }



        #formContainer .search-dropdown button {
            background-color: #256e8a;
            font-size: 0.875rem;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        #formContainer .search-dropdown button:hover {
            background-color: #1A3038;
        }




        #formContainer .checkbox-list input[type="checkbox"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #246f8a;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        #formContainer .checkbox-list input[type="checkbox"]:checked {
            background-color: #256e8a;
            border-color: #1d5d70;
        }

        #formContainer .checkbox-list label {
            display: flex;
            align-items: center;
        }

        #formContainer .checkbox-list .slidecontainer {
            margin-top: 5px;
        }

        .logging-button,
        .logged-button {
            background-color: #9510AC;
            color: #ffffff;
            border: none;
            padding: 20px 30px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            width: 15%;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            position: fixed;
            bottom: 0;
            right: 0;
            margin: 20px;
        }

        .logging-button:hover,
        .logged-button:hover {
            background-color: #1A3038;
        }

        .logged-button {
            background-color: #F5733A;
            /* Yellow color for logged button */
            border-radius: ;
        }


        .checkbox-slider-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <?php

    //setting up
    include "../DB_connect.php";

    if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
        $userid = $_SESSION['id'];


        //Fetching the sides
        $user_sides_sql = 'SELECT users.chosensides FROM users WHERE userid = ?';
        $stmt = $link->prepare($user_sides_sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $userSides = $result->fetch_assoc();
        $sideEffectIds = explode(',', $userSides['chosensides']);

        $chosenSideEffectsSql = 'SELECT side_effects.se_id, side_effects.se_name FROM side_effects WHERE se_id IN (' . implode(',', array_fill(0, count($sideEffectIds), '?')) . ')';
        $stmt = $link->prepare($chosenSideEffectsSql);
        $stmt->bind_param(str_repeat('i', count($sideEffectIds)), ...$sideEffectIds);
        $stmt->execute();
        $result = $stmt->get_result();

        $sql_all_sE = "SELECT se_name, se_id FROM side_effects";
        $result_all_sE = $link->query($sql_all_sE);


        //getting the current drug 
        $sql_drug = "SELECT * FROM user_drug WHERE userid = $userid";
        $result_drug = $link->query($sql_drug);
        if ($result_drug->num_rows > 0) {
            $noDrug = False;
            while ($row = $result_drug->fetch_assoc()) {
                $EndDate = NULL;
                $drug_id = $row["drug_id"];
                $date = $row["startdate"];
                $Date = date("Y-m-d", strtotime($date));
                if ($row["enddate"] != NULL) {
                    $enddate = $row["enddate"];
                    $EndDate = date("Y-m-d", strtotime($enddate));
                }
                $sql1 = "SELECT drug_brand FROM drugs WHERE drug_id = $drug_id";
                $result1 = $link->query($sql1);
                if ($result1->num_rows > 0) {
                    $row = $result1->fetch_assoc();
                    $drug_brand = $row["drug_brand"];
                    if ($EndDate == NULL) {
                        $currentDrug = " Logging for " . "<a href='../Drug_profile/nice_drug_page.php?drug_id=$drug_id'>$drug_brand</a> since $Date";
                    } else {
                    }
                } else {
                    $currentDrug = "<p>Drug_id does not exist in the drug table</p>";
                }
            }

            echo '<div id="overlay">'; // create the overlay effect
            echo '<div id="formContainer">';
            echo $currentDrug;
            echo '<form id="reportForm" action="../Logging_and_posts/submit_report.php" method="post">';
            echo '<input type="hidden" name="drugid" value="' . $drug_id . '">';

            $currentDate = date("Y-m-d"); // maybe time is not interesting? 
            echo '<label><input type="date" id="selectDate" name="selectDate" value="' . $currentDate . '"></label>';
            // realised this funciton is already included in calendar 
            //echo '<button name="selectDate" type="button" onclick="setDate()">Reset date</button>';
    
            echo '<div class="checkbox-list">'; //container for checkboxes
    
            while ($row = $result->fetch_assoc()) {
                //echo $row['se_id'];
                echo '<div class="checkbox-slider-row">';
                echo '<label><input type="checkbox" name="side_effects[]" value="' . $row['se_id'] . '">' . $row['se_name'] . '</label>';
                echo '<div class="slidecontainer"><input type="range" min="1" max="10" name="side_effects_intensity[]" value="1" class="slider" id="slider' . $row['se_id'] . '"></div>';
                echo '</div>';
            }


            // Interactive dropdown
            echo '<div class="search-dropdown">';
            echo '<label for="options">Add more side effects:</label>';
            echo '<select id="options" name="options">';
            echo '<option value="" disabled selected style="color: gray;">- - Select an option - -</option>';
            while ($row = $result_all_sE->fetch_assoc()) {
                echo '<option value="' . $row['se_id'] . '">' . $row['se_name'] . '</option>';
            }

            echo '</select>';


            echo '<button type="button" onclick="addOptionToCheckboxList()">Add to Checkbox List</button>';
            echo '</div>';
            echo '</div>';

            echo '<div class="bottom-buttons">';

            echo '<button type="button" onclick="overlay_off()">Close</button>';
            echo '<button type="button" onclick="window.location.href=\'../Forms/changesides_form.php\'">Configure side effects</button>';
            echo '<input type="submit" value="Submit"></form>';

            echo '</div>';
            echo '</div>'; // form container
            echo '</div>'; //overlay end
    
        } else {
            $currentDrug = "<h4>You have no registered contraceptive. <br>Please add one in your profile.</h4>";
            echo '<div id="overlay">'; // create the overlay effect
            echo '<div id="formContainer">';
            echo $currentDrug;
            echo '</div>'; // form container
            echo '</div>'; //overlay end
        }



        //chekc if user has logged
        $loggedToday = false;
        $currentDate = date("Y-m-d");
        $checkLogSql = "SELECT COUNT(*) as count FROM report WHERE userid = ? AND review_date = ?";
        $stmt = $link->prepare($checkLogSql);
        $stmt->bind_param("is", $userid, $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $loggedToday = $row['count'] > 0;
        //echo '<div class="Logging-button">';
    



        if ($userid != null) {
            // Check if the user has logged today
            if ($loggedToday) {
                echo '<button type="button" class="logged-button" onclick="overlay_on()">You have logged today!</button>'; //Moa add a link to the editing page here!
            } else {
                echo '<button type="button" class="logging-button" onclick="overlay_on()">Log your side effects</button>';
            }
        }
        //echo '</div>';
    

        $link->close();

        ?>

        <script>
            function addOptionToCheckboxList() {
                var selectedOptionId = document.getElementById("options").value;
                var selectedOptionName = document.getElementById("options").options[document.getElementById("options").selectedIndex].text;

                var checkboxList = document.querySelector('.checkbox-list');

                // Create checkbox and label elements
                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'side_effects[]';
                checkbox.value = selectedOptionId;

                // Create slider element for intensity
                var intensitySlider = document.createElement('input');
                intensitySlider.type = 'range';
                intensitySlider.min = 1;
                intensitySlider.max = 10;
                intensitySlider.value = 1;
                intensitySlider.name = 'side_effects_intensity[]';
                intensitySlider.className = 'slider';

                var label = document.createElement('label');
                label.appendChild(document.createTextNode(selectedOptionName)); // Display se_name as the label text

                // div element for checkbox, label, slider, and remove button, then append to the checkbox list
                var checkboxDiv = document.createElement('div');
                checkboxDiv.className = 'checkbox-slider-row'; // class here
                checkboxDiv.appendChild(checkbox);
                checkboxDiv.appendChild(label);
                checkboxDiv.appendChild(intensitySlider);

                // Create remove button
                var removeButton = document.createElement('span');
                removeButton.className = 'remove-option';
                removeButton.style.fontSize = '18px'; // font size larger
                removeButton.style.color = '#C43B39'; //red
                removeButton.appendChild(document.createTextNode('  x'));

                // remove the option when the remove button is clicked
                removeButton.addEventListener('click', function () {
                    checkboxDiv.remove();
                });

                checkboxDiv.appendChild(removeButton);
                checkboxList.appendChild(checkboxDiv);
            }


            // for datepicking:
            var currentDate = '<?php echo $currentDate; ?>';
            function setDate() {
                document.getElementById("selectDate").value = currentDate;
            }

            function overlay_on() {
                document.getElementById("overlay").style.display = "block";
            }

            function overlay_off() {
                document.getElementById("overlay").style.display = "none";
            }

            document.addEventListener("keydown", function (event) {// to allow for esc closing 
                if (event.key === "Escape") {
                    overlay_off(); y
                }
            });


        </script>

        <script>
            document.getElementById('reportForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Create a new FormData object from the form
                var formData = new FormData(this);

                // Send the form data to submit_report.php using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../Logging_and_posts/submit_report.php', true);
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // On success, close the overlay
                        overlay_off();
                        console.log(xhr.responseText); // You can log the response for debugging purposes
                    } else {
                        // Handle errors if any
                        console.error('Request failed with status:', xhr.status);
                    }
                };
                xhr.onerror = function () {
                    // Handle network errors
                    console.error('Request failed');
                };
                xhr.send(formData); // Send the form data

                // Note: You can show a loading spinner while the form is being submitted if needed.
            });

        </script>
        <?php
    }
    ?>
</body>

</html>