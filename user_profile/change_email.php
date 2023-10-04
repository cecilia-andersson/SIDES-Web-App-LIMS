<?php

include "../DB_connect.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    $userid = $_SESSION['id'];
}


$newEmail = $_POST['new_email'];

$newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
$newEmail = filter_var($newEmail, FILTER_VALIDATE_EMAIL);
$sql_newEmail = "SELECT * FROM users WHERE email = '$newEmail'";
$no_newEmail = $link->query($sql_newEmail);

if ($no_newEmail->num_rows > 0) {
    $message = urlencode("Error: Email is already connected to an account");
    header("Location:edit_myprofile.php?Message=" . $message);
    die;
}
$sql = "UPDATE users SET email='$newEmail' WHERE userid=$userid";
echo "$sql";
$stmt = $link->prepare($sql);
$stmt->bind_param("s", $newEmail);
$result = $stmt->execute();


if ($result) {
    $message = urlencode("Email changed successfully");
    header("Location:edit_myprofile.php?Message=" . $message);
    die;
} else {
    $message = urlencode("Error: Email could not be changed");
    header("Location:edit_myprofile.php?Message=" . $message);
    die;
}

?>