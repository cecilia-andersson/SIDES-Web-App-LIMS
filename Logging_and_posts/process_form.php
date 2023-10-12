<!-- how to call the logging -->
<!DOCTYPE html>
<html lang="en">
    
<head>
<style>

body {
            background-color: #ffffff;
            color: #256e8a;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

#overlay {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color:  rgba(117, 124, 179, 0.5); /*this is 757CB3 */
  z-index: 2;
  cursor: pointer;
}




#formContainer{
    background-color: #ffffff; 
    border: 2px solid #256e8a;
    border-radius: 15px;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    padding: 20px;

    position: absolute;
    top: 50%;
    left: 50%;

  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
}



#formContainer button,
#selectDate,
#options {
    background-color: #256e8a;
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

#formContainer button:hover,
#selectDate:hover,
#options:hover {
    background-color: #1d5d70; 
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
    margin-top: 10px;
    position: relative;
}

#formContainer .search-dropdown select {
    width: calc(100% );
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #256e8a; 
    color: #ffffff; 
    cursor: pointer;
    appearance: none;
    outline: none; 
}

#formContainer .search-dropdown select:focus {
    border-color: #ffffff; 
}

#formContainer .search-dropdown button {
    background-color: #256e8a;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
}

#formContainer .search-dropdown button:hover {
    background-color: #1d5d70; 
}




#formContainer .checkbox-list input[type="checkbox"] {
    appearance: none;
    width: 20px;
    height: 10px;
    border: 2px solid #256e8a;
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
</style>
</head>
<body>



<?php
include "../DB_connect.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    $userid = $_SESSION['id'];
}

$userid = 1;// for testing without session
 
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

echo '<div id="overlay">';// create the overlay effect 
    echo '<div id="formContainer">'; 

    echo '<form action="submit_report.php" method="post">';

        $currentDate = date("Y-m-d"); // maybe time is not interesting? 
        echo '<label><input type="date" id="selectDate" name="selectDate" value="' . $currentDate . '"></label>';
        echo '<button name="selectDate" type="button" onclick="setDate()">Reset date</button>';

        echo '<div class="checkbox-list">'; //container for checkboxes

            while ($row = $result->fetch_assoc()) {
                //echo $row['se_id'];
                echo '<label><input type="checkbox" name="side_effects[]" value="' . $row['se_id'] . '">' . $row['se_name'] . '</label>';
                echo '<div class="slidecontainer"> <label><input type="range" min="1" max="10" name="side_effects_intensity[]" value="1" class="slider" id="slider' . $row['se_id'] .  '" > </div>';
            }

            // Interactive dropdown
            echo '<div class="search-dropdown">';
                echo '<label for="options">Select an option:</label>';
                echo '<select id="options" name="options">';
                while ($row = $result_all_sE->fetch_assoc()) {
                    echo '<option value="' . $row['se_id'] . '">' . $row['se_name'] . '</option>';
                }

                echo '</select>';


                echo '<button type="button" onclick="addOptionToCheckboxList()">Add to Checkbox List</button>';
            echo '</div>';
        echo '</div>';
        echo '<button type="button" onclick="overlay_off()">close</button>';            
                
    echo '<input type="submit" value="Submit"></form>';
    echo '</div>';
echo '</div>'; //overlay 
echo '<button onclick="overlay_on()">Log your side effects</button>';

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
        checkbox.name = 'side_effects[]'; // Set the name attribute to match the static checkboxes
        checkbox.value = selectedOptionId; // Store se_id as the checkbox value

        // Create slider element for intensity
        var intensitySlider = document.createElement('input');
        intensitySlider.type = 'range';
        intensitySlider.min = 1;
        intensitySlider.max = 10;
        intensitySlider.value = 1; // Default intensity value
        intensitySlider.name = 'side_effects_intensity[]'; // Set the name attribute for intensity
        intensitySlider.className = 'slider'; // Apply your slider styles here

        var label = document.createElement('label');
        label.appendChild(document.createTextNode(selectedOptionName)); // Display se_name as the label text

        // Create a div element for checkbox, label, slider, and remove button, then append to the checkbox list
        var checkboxDiv = document.createElement('div');
        checkboxDiv.className = 'form-check';
        checkboxDiv.appendChild(checkbox);
        checkboxDiv.appendChild(label);
        checkboxDiv.appendChild(intensitySlider);

        // Create remove button
        var removeButton = document.createElement('span');
        removeButton.className = 'remove-option';
        removeButton.appendChild(document.createTextNode('x'));

        // Add click event to remove the option when the remove button is clicked
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

    document.addEventListener("keydown", function(event) {// to allow for esc closing 
    if (event.key === "Escape") {
        overlay_off(); y
    }
});
</script>

</body>
</html>