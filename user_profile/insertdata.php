<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sides";

$link = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error()); 
}

$inputUsername = $_POST['username'];
$hashedAndSaltedPassword = password_hash($_POST['pwd'], $PASSWORD_BCRYPT); // "Using the PASSWORD_BCRYPT as the algorithm, will result in the password parameter being truncated to a maximum length of 72 bytes."
$inputPersonnmr = $_POST['personnmr']; 
$birthdate = substr($inputPersonnmr, 0, 8);

// verify that personal number is unique by filtering out the same birthdates
$sql_birthdates = "SELECT * FROM users WHERE birthdate = '$birthdate'";
$result_birthdates = $link->query($sql_birthdates);

while($row = $result_birthdates->fetch_assoc()) {
    // compare last four digits using password_verify
    if (password_verify(substr($inputPersonnmr, 8), $row["uniquefour"])) {
        $message = urlencode("You already have an account");
        header("Location:register.php?Message=".$message);
        die;
    }
    else {
        continue;
    }
}

// For report: prove that if a perpetrator already knows the personal number, they don't need to hack (?)

$uniquefour = password_hash(substr($inputPersonnmr, 8), $PASSWORD_BCRYPT); // salt & hash four last digits

$sql1 = "INSERT INTO users (birthdate, uniquefour, username, pwd) VALUES (?, ?, ?, ?)";
$stmt1 = $link->prepare($sql1);
$stmt1->bind_param("ssss", $birthdate, $uniquefour, $inputUsername, $hashedAndSaltedPassword);
$result1 = $stmt1->execute();

if ($result1) {
    $message = urlencode("New account created successfully");
    header("Location:index.php?Message=".$message);
    die;
} else {
    $message = urlencode("Error: Account could not be created");
    header("Location:index.php?Message=".$message);
    die;
}

$link->close();
?>