<?php
include "../DB_connect.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION["id"])) {
    $userid = $_SESSION['id'];
    $userid = 1;
} else {
    $message = urlencode("Not logged in.");
    header("Location:login_page.php?Message=" . $message);
    die();
}

if (isset($_POST['date']) && isset($_POST['delete_log'])) {
    $date = $_POST['date'];

    $sql = "DELETE FROM report WHERE userid=? AND review_date=?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("is", $userid, $date);
    $result = $stmt->execute();

    if ($result) {
        $message = urlencode("Log deleted successfully");
        header("Location:myprofile.php?Message=" . $message);
        die();
    } else {
        $message = urlencode("Error: Log could not be deleted");
        header("Location:myprofile.php?Message=" . $message);
        die();
    }
} else {
    $message = urlencode("Invalid request.");
    header("<Location:myprofile.php?Message=" . $message);
    die();
}
?>
