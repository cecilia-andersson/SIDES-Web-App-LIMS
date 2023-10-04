<?php

include "../DB_connect.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    $userid = $_SESSION['id'];
}


$newUsername = $_POST['new_username'];

$sql_newUsername = "SELECT * FROM users WHERE username = '$newUsername'";
$no_newUsername = $link->query($sql_newUsername);

if ($no_newUsername->num_rows > 0) {
    $message = urlencode("Error: Username is already connected to an account");
    header("Location:edit_myprofile.php?Message=" . $message);
    die;
}

$sql = "UPDATE users SET username='$newUsername' WHERE userid=$userid";
$stmt = $link->prepare($sql);
$stmt->bind_param("s", $newUsername);
$result = $stmt->execute();


if ($result) {
    $message = urlencode("Username changed successfully");
    header("Location:edit_myprofile.php?Message=" . $message);
    $_SESSION['username']=$newUsername;
    die;
} else {
    $message = urlencode("Error: Username could not be changed");
    header("Location:edit_myprofile.php?Message=" . $message);
    die;
}



?>