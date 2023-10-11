<?php
// Validated and sanitized 11-10-2023

include "../DB_connect.php";

$inputUsername = $_POST['username'];
$hashedAndSaltedPassword = password_hash($_POST['pwd'], $PASSWORD_BCRYPT);

// PERSONAL SECURITY NUMBER
// sanitize personnummer and make sure user has reached the age of consent
$inputPersonnmr = filter_var($_POST['personnmr'], FILTER_SANITIZE_NUMBER_INT); 
$birthdate = substr($inputPersonnmr, 0, 8);
$earliestBirthdate=date('Ymd', strtotime('-15 years'));
if ($birthdate > $earliestBirthdate) {
    $message = urlencode("You have to be older than 15 to create an account");
    header("Location:register.php?Message=".$message);
    die;
}

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

$uniquefour = password_hash(substr($inputPersonnmr, 8), $PASSWORD_BCRYPT); // salt & hash four last digits

// EMAIL
// validate and sanitize email
$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);

// make sure email is unique
$sql_email = "SELECT * FROM users WHERE email = '$email'";
$no_email = $link->query($sql_email);

if ($no_email->num_rows > 0) {
    $message = urlencode("Error: Email is already connected to an account");
    header("Location:register.php?Message=".$message);
    die;
}

$sql1 = "INSERT INTO users (birthdate, uniquefour, username, pwd, email) VALUES (?, ?, ?, ?, ?)";
$stmt1 = $link->prepare($sql1);
$stmt1->bind_param("sssss", $birthdate, $uniquefour, $inputUsername, $hashedAndSaltedPassword, $email);
$result1 = $stmt1->execute();

if ($result1) {
    $message = urlencode("New account created successfully. You can now sign in.");
    header("Location:login_page.php?Message=".$message);
    die;
} else {
    $message = urlencode("Error: Account could not be created");
    header("Location:register.php?Message=".$message);
    die;
}
?>