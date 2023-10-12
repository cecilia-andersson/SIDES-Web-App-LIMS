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




echo '<form action="submit_report.php" method="post">';
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


echo '<input type="submit" value="Submit"></form>';
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
        
</script>