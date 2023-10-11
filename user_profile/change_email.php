<?php
// Sanitized and validated 11-10-2023

include "../DB_connect.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    $userid = $_SESSION['id']; // can this be changed?
}

$newEmail = $_POST['new_email'];

$newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
$newEmail = filter_var($newEmail, FILTER_VALIDATE_EMAIL);

// prepare and execute search for if email already exists
$sql_newEmail = "SELECT * FROM users WHERE email = ?";
$stmt = $link->prepare($sql_newEmail);
$stmt->bind_param("s", $newEmail);
$emailexists = $stmt->execute();
$emailexists = $stmt->get_result();

if ($emailexists->num_rows > 0) {
    $message = urlencode("Error: Email is already connected to an account");
    header("Location:edit_myprofile.php?Message=" . $message);
    die;
}
$stmt->close();

// prepare and execute update
$sql = "UPDATE users SET email=? WHERE userid=?";
$stmt = $link->prepare($sql);
$stmt->bind_param("ss", $newEmail, $userid);
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