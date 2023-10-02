<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #ffffff;
            color: #256e8a;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Styles for the popup */
        .form-popup {
            display: none;
            background-color: #ffffff;
            width: 100%; /* Make sure the popup takes up full width */
            max-width: 600px; /* Adjust the max-width of the form popup */
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #256e8a;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        /* Styles for the checkboxes and sliders */
        .form-check {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            width: 100%;
        }

        /* Styles for the labels */
        .form-check label {
            flex: 0 0 150px; /* Set a fixed width for the labels */
        }

        /* Styles for the sliders */
        .slider {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 10px;
            background: #256e8a;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
            border-radius: 5px;
            margin-top: 5px;
        }

        .form-check input[type="checkbox"] {
            display: none; /* Hide the default checkbox */
        }

        .form-check input[type="checkbox"] + label {
            position: relative;
            padding-left: 30px; /* Adjust the space for the custom checkbox */
            cursor: pointer;
            line-height: 20px;
        }

        /* Custom checkbox styles */
        .form-check input[type="checkbox"] + label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 20px; /* Size of the custom checkbox */
            height: 20px;
            border: 2px solid #256e8a; /* Empty blue ring */
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        /* Style the custom checkbox when checked */
        .form-check input[type="checkbox"]:checked + label:before {
            background-color: #256e8a; /* Solid blue circle when checked */
            border: none; /* Remove the border */
        }

        /* Styles for the form */
        .form-container {
            max-width: 100%;
        }

        /* Styles for the checkboxes and multiple select dropdown */
        .form-check,
        .search-dropdown {
            margin-bottom: 10px;
        }

        /* Styles for the remove option (x) button */
        .remove-option {
            cursor: pointer;
            color: red;
            margin-left: 5px;
        }

        /* Styles for the button */
        .btn {
            background-color: #256e8a;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .slider {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 10px;
            background: #256e8a;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
            border-radius: 5px;
            margin-top: 5px;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #256e8a;
            border-radius: 50%;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #256e8a;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }
        .search-dropdown select {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #256e8a;
            color: #ffffff;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        /* Styles for the "Add to Checkbox List" button */
        .search-dropdown button {
            background-color: #256e8a;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        .search-dropdown button:hover {
            background-color: #1d5d70; /* Darker shade of blue for hover effect */
        }
        .open-popup button {
            background-color: #256e8a;
            color: #ffffff;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .open-popup button:hover {
            background-color: #1d5d70; /* Darker shade of blue for hover effect */
        }
    </style>
</head>

<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sides";


// List of CHOSEN se, exchange when we have this
$ChosenSideEffects = ['Headache', 'Nausea', 'Fatigue', 'Dizziness', 'Dry mouth', 'Insomnia', 'Blurred vision', 'Constipation', 'Loss of appetite', 'Sweating'];


// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);


if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

// List of ALL se
$sql = "SELECT DISTINCT se_name FROM side_effects";
$result = $link->query($sql);
$se_list = []; //if in chosen, then dont show- should add 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $se_list[] = $row["se_name"]; 
    }
}

$link->close();


?>

<body>

    <!-- Button to open the popup -->
    <div class="open-popup"><button onclick="openForm()">Log Your Side Effects!</button></div>
    
    <!-- Popup with form, checkboxes, and multiple select dropdown -->
    <div class="form-popup" id="myForm">
        <form class="form-container">

            <!-- Checkboxes for side effects -->
            <div class="checkbox-list">
                <h2>Your sideffects:</h2>
                <?php
                foreach ($ChosenSideEffects as $index => $sideEffect) {
                    echo '<div class="form-check">
                            <input type="checkbox" id="se' . $index . '" name="se' . $index . '" value="' . $sideEffect . '">
                            <label for="se' . $index . '">' . $sideEffect . '</label>
                            <input type="range" min="1" max="10" value="1" class="slider" id="slider' . $index . '">
                        </div>';
                }
                ?>

                <h2>--------</h2>
            </div>

            <!-- Multiple select dropdown with checkboxes -->
            <div class="search-dropdown">
                <label for="options">Select an option:</label>
                <select id="options" name="options">
                        <?php
                        foreach ($se_list as $sE) {  
                            echo "<option value='$sE'>$sE</option>"; // NEED TO CHANGE THIS SO IT IS ID
                        }?>
                        
                </select>
                <button type="button" onclick="addOptionToCheckboxList()">Add to Checkbox List</button>
            </div>

            <!-- Close button for the form -->
            <button type="submit" class="btn submit-btn">Submit</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>

    <script>
        // Open/close popup
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        
        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }

    //Adding the selected option to the checkbox list
    function addOptionToCheckboxList() {
        var selectedOption = document.getElementById("options").value;
        var checkboxList = document.querySelector('.checkbox-list');

        // Create checkbox and label elements
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'dynamicOption[]';
        checkbox.value = selectedOption;

        var label = document.createElement('label');
        label.appendChild(document.createTextNode(selectedOption));

        // Create slider element
        var slider = document.createElement('input');
        slider.type = 'range';
        slider.min = 1;
        slider.max = 10;
        slider.value = 1; // Default value
        slider.className = 'slider'; // slider styles

        // Creating a div element form-check for checkbox, label, slider, and remove button, then append to the checkbox list
        var checkboxDiv = document.createElement('div');
        checkboxDiv.className = 'form-check';
        checkboxDiv.appendChild(checkbox);
        checkboxDiv.appendChild(label);
        checkboxDiv.appendChild(slider);

        // Create remove button remove-option
        var removeButton = document.createElement('span');
        removeButton.className = 'remove-option';
        removeButton.appendChild(document.createTextNode('x'));

        // Add click event to remove the option when the remove button is clicked
        removeButton.addEventListener('click', function () {
            checkboxDiv.remove();
        });

        checkboxDiv.appendChild(removeButton);
        checkboxList.appendChild(checkboxDiv);
        
        // Function to handle form submission, what is  listened for is the form submission event ('submit').
        document.querySelector('.form-container').addEventListener('submit', function (event) {
            // Prevent the default form submission
            event.preventDefault(); // normally refresh, but we want it to stay here so we can use the values to make sql input

            // Get all checked checkboxes and their corresponding slider values
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            var selectedValues = Array.from(checkboxes).map(function (checkbox) {
                var sliderValue = checkbox.parentElement.querySelector('.slider').value;
                return {
                    sideEffect: checkbox.value,
                    intensity: sliderValue
            };
        });

        // Do something with the selected values (for example, send them to the server via AJAX)
        console.log("Selected values: ", selectedValues);
    });
}

    </script>

</body>

</html>
